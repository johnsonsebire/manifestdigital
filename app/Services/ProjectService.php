<?php

namespace App\Services;

use App\Events\ProjectCreated;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectCreated as ProjectCreatedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectService
{
    /**
     * Create a project from an approved order.
     */
    public function createFromOrder(Order $order, ?int $managerId = null): ?Project
    {
        // Validate order status
        if (!in_array($order->status, ['processing', 'completed'])) {
            Log::warning('Cannot create project from order with current status', [
                'order_id' => $order->id,
                'status' => $order->status,
            ]);
            return null;
        }

        // Check if project already exists
        if ($order->assigned_project_id) {
            Log::info('Project already exists for order', [
                'order_id' => $order->id,
                'project_id' => $order->assigned_project_id,
            ]);
            return $order->project;
        }

        try {
            DB::beginTransaction();

            // Generate project title from order items
            $title = $this->generateProjectTitle($order);

            // Create project
            $project = Project::create([
                'uuid' => Str::uuid(),
                'title' => $title,
                'description' => $this->generateProjectDescription($order),
                'client_id' => $order->customer_id,
                'status' => 'planning',
                'priority' => 'medium',
                'start_date' => now(),
                'estimated_end_date' => now()->addDays(30), // Default 30 days
                'metadata' => [
                    'created_from_order' => true,
                    'order_uuid' => $order->uuid,
                    'order_total' => $order->total_amount,
                    'services' => $order->items->map(function ($item) {
                        return [
                            'service_id' => $item->service_id,
                            'service_title' => $item->snapshot['service_title'] ?? $item->service->title ?? 'Service',
                            'variant_name' => $item->snapshot['variant_name'] ?? null,
                            'quantity' => $item->quantity,
                        ];
                    })->toArray(),
                ],
            ]);

            // Assign manager if provided
            if ($managerId) {
                $project->teamMembers()->attach($managerId, [
                    'role' => 'manager',
                    'can_manage_team' => true,
                ]);
            }

            // Link project to order
            $order->update(['assigned_project_id' => $project->id]);

            // Create activity log
            ActivityLog::create([
                'user_id' => $managerId ?? auth()->id(),
                'type' => 'project_created',
                'loggable_type' => Project::class,
                'loggable_id' => $project->id,
                'description' => "Project #{$project->uuid} created from order #{$order->uuid}",
                'metadata' => [
                    'order_id' => $order->id,
                    'order_uuid' => $order->uuid,
                ],
            ]);

            // Fire ProjectCreated event
            event(new ProjectCreated($project, $order));

            // Send notification to customer about project creation
            if ($order->customer) {
                $order->customer->notify(new ProjectCreatedNotification($project));
            }

            DB::commit();

            Log::info('Project created from order', [
                'project_id' => $project->id,
                'order_id' => $order->id,
            ]);

            return $project;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Project creation from order failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Generate project title from order.
     */
    protected function generateProjectTitle(Order $order): string
    {
        $firstItem = $order->items->first();
        if (!$firstItem) {
            return "Project for {$order->customer_name}";
        }

        $serviceTitle = $firstItem->snapshot['service_title'] ?? $firstItem->service->title ?? 'Service';
        
        if ($order->items->count() > 1) {
            return "{$serviceTitle} + " . ($order->items->count() - 1) . " more";
        }

        return $serviceTitle;
    }

    /**
     * Generate project description from order.
     */
    protected function generateProjectDescription(Order $order): string
    {
        $description = "Project created from order #{$order->uuid}\n\n";
        $description .= "**Services:**\n";

        foreach ($order->items as $item) {
            $serviceTitle = $item->snapshot['service_title'] ?? $item->service->title ?? 'Service';
            $variantName = $item->snapshot['variant_name'] ?? null;
            
            $description .= "- {$serviceTitle}";
            if ($variantName) {
                $description .= " ({$variantName})";
            }
            $description .= " × {$item->quantity}\n";
        }

        if ($order->notes) {
            $description .= "\n**Customer Notes:**\n{$order->notes}";
        }

        return $description;
    }

    /**
     * Assign team member to project.
     */
    public function assignTeamMember(Project $project, int $userId, string $role = 'member', bool $canManageTeam = false): bool
    {
        try {
            // Check if user is already assigned
            if ($project->teamMembers()->where('user_id', $userId)->exists()) {
                Log::info('User already assigned to project', [
                    'project_id' => $project->id,
                    'user_id' => $userId,
                ]);
                return true;
            }

            $project->teamMembers()->attach($userId, [
                'role' => $role,
                'can_manage_team' => $canManageTeam,
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'type' => 'team_member_assigned',
                'loggable_type' => Project::class,
                'loggable_id' => $project->id,
                'description' => "Team member assigned to project",
                'metadata' => [
                    'assigned_user_id' => $userId,
                    'role' => $role,
                ],
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Team member assignment failed', [
                'project_id' => $project->id,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Update project status.
     */
    public function updateStatus(Project $project, string $newStatus, ?int $userId = null): bool
    {
        $validStatuses = ['planning', 'in_progress', 'on_hold', 'review', 'completed', 'cancelled'];

        if (!in_array($newStatus, $validStatuses)) {
            return false;
        }

        try {
            $oldStatus = $project->status;
            $project->update(['status' => $newStatus]);

            ActivityLog::create([
                'user_id' => $userId ?? auth()->id(),
                'type' => 'project_status_changed',
                'loggable_type' => Project::class,
                'loggable_id' => $project->id,
                'description' => "Project status changed from {$oldStatus} to {$newStatus}",
                'metadata' => [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ],
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Project status update failed', [
                'project_id' => $project->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Calculate project completion percentage.
     */
    public function calculateCompletion(Project $project): float
    {
        $totalTasks = $project->tasks()->count();

        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $project->tasks()->where('status', 'done')->count();

        return round(($completedTasks / $totalTasks) * 100, 2);
    }

    /**
     * Update project completion percentage.
     */
    public function updateCompletion(Project $project): bool
    {
        $completion = $this->calculateCompletion($project);
        
        return $project->update(['completion_percentage' => $completion]);
    }

    /**
     * Get project statistics.
     */
    public function getProjectStatistics(?int $clientId = null): array
    {
        $query = Project::query();

        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        return [
            'total' => (clone $query)->count(),
            'planning' => (clone $query)->where('status', 'planning')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'on_hold' => (clone $query)->where('status', 'on_hold')->count(),
            'average_completion' => (clone $query)->avg('completion_percentage') ?? 0,
        ];
    }
}
