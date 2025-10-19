<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectMessage>
 */
class ProjectMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'sender_id' => User::factory(),
            'body' => $this->faker->paragraphs($this->faker->numberBetween(1, 4), true),
            'is_internal' => $this->faker->boolean(30),
            'read_by' => $this->faker->boolean(60) ? [$this->faker->numberBetween(1, 10)] : [],
            'metadata' => $this->generateMetadata(),
        ];
    }

    /**
     * Generate metadata for the message
     */
    private function generateMetadata(): array
    {
        $metadata = [];

        // Add AI generation metadata occasionally
        if ($this->faker->boolean(15)) {
            $metadata['ai_draft'] = true;
            $metadata['ai_source'] = 'project_update_generator';
            $metadata['ai_prompt'] = 'Generate project status update';
        }

        // Add message type metadata
        $metadata['message_type'] = $this->faker->randomElement([
            'status_update',
            'question',
            'clarification',
            'approval_request',
            'milestone_update',
            'issue_report',
            'general_communication',
        ]);

        // Add priority occasionally
        if ($this->faker->boolean(25)) {
            $metadata['priority'] = $this->faker->randomElement(['low', 'medium', 'high']);
        }

        // Add attachments info occasionally
        if ($this->faker->boolean(20)) {
            $metadata['has_attachments'] = true;
            $metadata['attachment_count'] = $this->faker->numberBetween(1, 3);
        }

        return $metadata;
    }

    /**
     * Create a client-visible message
     */
    public function clientVisible(): static
    {
        return $this->state([
            'is_internal' => false,
        ]);
    }

    /**
     * Create an internal message
     */
    public function internal(): static
    {
        return $this->state([
            'is_internal' => true,
        ]);
    }

    /**
     * Create an AI-generated message
     */
    public function aiGenerated(): static
    {
        return $this->state([
            'body' => $this->faker->randomElement([
                'Project is progressing well. We have completed the initial setup and are moving into the development phase.',
                'Please review the latest designs and provide your feedback. We want to ensure everything meets your expectations.',
                'We have encountered a minor delay due to additional requirements. The new timeline will be shared shortly.',
                'Milestone completed successfully! Moving on to the next phase of development.',
                'Quality assurance testing is underway. We are ensuring everything works perfectly before delivery.',
            ]),
            'metadata' => [
                'ai_draft' => true,
                'ai_source' => 'project_update_generator',
                'ai_prompt' => 'Generate project status update',
                'message_type' => 'status_update',
            ],
        ]);
    }

    /**
     * Create a status update message
     */
    public function statusUpdate(): static
    {
        return $this->state([
            'body' => $this->faker->randomElement([
                'Project update: We have successfully completed the wireframing phase and are now moving into the design phase. All deliverables are on track.',
                'Weekly status: Development is 60% complete. We are on schedule to meet the delivery deadline.',
                'Milestone achieved: Initial testing phase completed successfully. No major issues found.',
                'Progress update: Backend development completed. Starting frontend integration next week.',
                'Current status: We are conducting final quality assurance tests. Launch preparation is underway.',
            ]),
            'is_internal' => false,
            'metadata' => [
                'message_type' => 'status_update',
                'milestone_related' => $this->faker->boolean(40),
            ],
        ]);
    }

    /**
     * Create a question message
     */
    public function question(): static
    {
        return $this->state([
            'body' => $this->faker->randomElement([
                'Could you please provide the brand guidelines and color palette for the project?',
                'We need clarification on the user roles and permissions for the system. Can you provide more details?',
                'Should the mobile version include all the features from the desktop version?',
                'What is your preference for the payment gateway integration - Stripe or PayPal?',
                'Do you have any specific accessibility requirements we should implement?',
            ]),
            'is_internal' => false,
            'metadata' => [
                'message_type' => 'question',
                'requires_response' => true,
                'priority' => $this->faker->randomElement(['medium', 'high']),
            ],
        ]);
    }

    /**
     * Create an approval request message
     */
    public function approvalRequest(): static
    {
        return $this->state([
            'body' => $this->faker->randomElement([
                'Please review and approve the attached designs before we proceed with development.',
                'The wireframes are ready for your review. Please provide approval or feedback.',
                'We have completed the initial prototype. Please test it and let us know if any changes are needed.',
                'Database schema has been finalized. Please review and approve before implementation.',
                'Content architecture is ready for review. Please approve or provide feedback.',
            ]),
            'is_internal' => false,
            'metadata' => [
                'message_type' => 'approval_request',
                'requires_approval' => true,
                'has_attachments' => $this->faker->boolean(70),
                'priority' => 'high',
            ],
        ]);
    }

    /**
     * Create an issue report message
     */
    public function issueReport(): static
    {
        return $this->state([
            'body' => $this->faker->randomElement([
                'We have identified a compatibility issue with older browser versions. Working on a solution.',
                'There is a delay with the third-party API integration. We are exploring alternative solutions.',
                'Minor bug found in the payment process. Fix will be deployed by end of day.',
                'Performance issue detected on mobile devices. Optimization in progress.',
                'Content loading issue on the homepage. Investigation underway.',
            ]),
            'is_internal' => $this->faker->boolean(50),
            'metadata' => [
                'message_type' => 'issue_report',
                'severity' => $this->faker->randomElement(['low', 'medium', 'high']),
                'priority' => $this->faker->randomElement(['medium', 'high']),
            ],
        ]);
    }

    /**
     * Create a milestone update message
     */
    public function milestoneUpdate(): static
    {
        return $this->state([
            'body' => $this->faker->randomElement([
                'Milestone 1 completed: Project planning and wireframing phase finished successfully.',
                'Design milestone achieved: All UI/UX designs approved and ready for development.',
                'Development milestone: Core functionality implementation completed.',
                'Testing milestone: Quality assurance testing completed with no critical issues.',
                'Final milestone: Project delivered and ready for launch.',
            ]),
            'is_internal' => false,
            'metadata' => [
                'message_type' => 'milestone_update',
                'milestone_related' => true,
                'completion_percentage' => $this->faker->numberBetween(20, 100),
            ],
        ]);
    }

    /**
     * Create a message that has been read
     */
    public function read(): static
    {
        return $this->afterMaking(function (ProjectMessage $message) {
            $message->read_by = [$this->faker->numberBetween(1, 5)];
        });
    }

    /**
     * Create an unread message
     */
    public function unread(): static
    {
        return $this->state([
            'read_by' => [],
        ]);
    }

    /**
     * Create a recent message (within last 7 days)
     */
    public function recent(): static
    {
        return $this->afterMaking(function (ProjectMessage $message) {
            $message->created_at = $this->faker->dateTimeBetween('-7 days', 'now');
        });
    }

    /**
     * Create an old message (older than 1 month)
     */
    public function old(): static
    {
        return $this->afterMaking(function (ProjectMessage $message) {
            $message->created_at = $this->faker->dateTimeBetween('-6 months', '-1 month');
        });
    }
}