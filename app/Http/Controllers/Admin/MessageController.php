<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\ProjectMessage;
use App\Notifications\NewProjectMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Store a newly created message.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'body' => 'required|string|max:5000',
            'is_internal' => 'boolean',
            'files.*' => 'nullable|file|max:51200', // 50MB max per file
        ]);

        // Create message
        $message = $project->messages()->create([
            'sender_id' => auth()->id(),
            'body' => $request->body,
            'is_internal' => $request->boolean('is_internal', false),
        ]);

        // Handle file attachments
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('projects/' . $project->id . '/messages', 'local');
                
                $message->files()->create([
                    'uploader_id' => auth()->id(),
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        // Log activity
        $messageType = $message->is_internal ? 'internal note' : 'message';
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'message_sent',
            'description' => auth()->user()->name . ' posted a ' . $messageType,
        ]);

        // Notify project client about new message (if not internal)
        if (!$message->is_internal && $project->client) {
            $project->client->notify(new NewProjectMessage($project, $message));
        }

        return back()->with('success', 'Message posted successfully.');
    }

    /**
     * Update the specified message.
     */
    public function update(Request $request, Project $project, ProjectMessage $message)
    {
        $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $message->update([
            'body' => $request->body,
            'metadata' => array_merge($message->metadata ?? [], [
                'edited_at' => now()->toDateTimeString(),
                'edited_by' => auth()->id(),
            ]),
        ]);

        return back()->with('success', 'Message updated successfully.');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(Project $project, ProjectMessage $message)
    {
        // Only allow deleting own messages or if admin
        if ($message->sender_id !== auth()->id() && !auth()->user()->can('viewAny', Project::class)) {
            abort(403, 'Unauthorized to delete this message.');
        }

        $message->delete();

        // Log activity
        ActivityLog::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'type' => 'message_deleted',
            'description' => 'A message was deleted by ' . auth()->user()->name,
        ]);

        return back()->with('success', 'Message deleted successfully.');
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(Project $project, ProjectMessage $message)
    {
        $message->markAsReadBy(auth()->user());

        return response()->json(['success' => true]);
    }

    /**
     * Mark all messages as read.
     */
    public function markAllAsRead(Project $project)
    {
        $messages = $project->messages()
            ->whereDoesntHave('read_by', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        foreach ($messages as $message) {
            $message->markAsReadBy(auth()->user());
        }

        return back()->with('success', 'All messages marked as read.');
    }
}
