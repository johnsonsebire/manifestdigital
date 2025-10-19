<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-2 months', '+1 month');
        $dueDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d') . ' +2 months');
        $estimatedHours = $this->faker->randomFloat(2, 1, 40);
        $spentHours = $this->faker->randomFloat(2, 0, $estimatedHours * 1.2);

        return [
            'project_id' => Project::factory(),
            'title' => $this->generateTaskTitle(),
            'description' => $this->faker->paragraphs(2, true),
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'review', 'done']),
            'priority' => $this->faker->randomElement([0, 1, 2, 3]), // 0=Low, 1=Medium, 2=High, 3=Urgent
            'assignee_id' => $this->faker->boolean(80) ? User::factory() : null,
            'reporter_id' => User::factory(),
            'due_date' => $dueDate,
            'start_date' => $startDate,
            'estimated_hours' => $estimatedHours,
            'spent_hours' => $spentHours,
            'order_item_id' => $this->faker->boolean(30) ? OrderItem::factory() : null,
            'metadata' => $this->generateMetadata(),
        ];
    }

    /**
     * Generate realistic task titles
     */
    private function generateTaskTitle(): string
    {
        $taskTitles = [
            // Development tasks
            'Implement user authentication system',
            'Create database schema design',
            'Build responsive homepage layout',
            'Integrate payment gateway API',
            'Develop admin dashboard',
            'Implement search functionality',
            'Create user profile management',
            'Build contact form with validation',
            'Implement email notification system',
            'Create product catalog interface',
            
            // Design tasks
            'Design wireframes for mobile app',
            'Create brand style guide',
            'Design user interface mockups',
            'Develop logo concepts',
            'Create marketing material designs',
            'Design database architecture diagram',
            'Create user journey flowcharts',
            'Design error page layouts',
            'Create loading animation graphics',
            'Design icon set for application',
            
            // Testing tasks
            'Perform cross-browser compatibility testing',
            'Conduct user acceptance testing',
            'Execute security vulnerability assessment',
            'Test mobile responsiveness',
            'Perform load testing',
            'Validate form submissions',
            'Test payment processing flow',
            'Conduct accessibility audit',
            'Verify API endpoint functionality',
            'Test database backup procedures',
            
            // Project management tasks
            'Conduct project kickoff meeting',
            'Create project timeline',
            'Review client requirements',
            'Prepare project documentation',
            'Schedule weekly progress meetings',
            'Conduct team retrospective',
            'Prepare project status report',
            'Review and approve deliverables',
            'Coordinate with stakeholders',
            'Finalize project deployment plan',
            
            // Content tasks
            'Write technical documentation',
            'Create user manual content',
            'Develop website copy',
            'Prepare marketing content',
            'Create API documentation',
            'Write test case scenarios',
            'Develop training materials',
            'Create FAQ content',
            'Write blog post content',
            'Prepare project proposal',
        ];

        return $this->faker->randomElement($taskTitles);
    }

    /**
     * Generate metadata for the task
     */
    private function generateMetadata(): array
    {
        $metadata = [];

        // Add AI generation metadata occasionally
        if ($this->faker->boolean(20)) {
            $metadata['ai_source'] = true;
            $metadata['ai_generator'] = 'task_breakdown_ai';
            $metadata['ai_confidence'] = $this->faker->randomFloat(2, 0.7, 0.95);
        }

        // Add task category
        $metadata['category'] = $this->faker->randomElement([
            'development',
            'design',
            'testing',
            'documentation',
            'research',
            'planning',
            'review',
            'deployment',
        ]);

        // Add complexity level
        $metadata['complexity'] = $this->faker->randomElement(['simple', 'medium', 'complex']);

        // Add skill requirements
        $metadata['skills_required'] = $this->faker->randomElements([
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'HTML/CSS', 'MySQL',
            'API Integration', 'UI/UX Design', 'Testing', 'DevOps'
        ], $this->faker->numberBetween(1, 3));

        // Add blockers occasionally
        if ($this->faker->boolean(15)) {
            $metadata['blocked'] = true;
            $metadata['blocker_reason'] = $this->faker->randomElement([
                'Waiting for client approval',
                'Dependent on external API',
                'Waiting for design assets',
                'Technical research needed',
            ]);
        }

        return $metadata;
    }

    /**
     * Create a task in todo status
     */
    public function todo(): static
    {
        return $this->state([
            'status' => 'todo',
            'spent_hours' => 0,
        ]);
    }

    /**
     * Create a task in progress
     */
    public function inProgress(): static
    {
        return $this->state([
            'status' => 'in_progress',
        ])->afterMaking(function (Task $task) {
            $task->spent_hours = $task->estimated_hours * $this->faker->randomFloat(2, 0.1, 0.7);
        });
    }

    /**
     * Create a task in review
     */
    public function inReview(): static
    {
        return $this->state([
            'status' => 'review',
        ])->afterMaking(function (Task $task) {
            $task->spent_hours = $task->estimated_hours * $this->faker->randomFloat(2, 0.8, 1.0);
        });
    }

    /**
     * Create a completed task
     */
    public function completed(): static
    {
        return $this->state([
            'status' => 'done',
        ])->afterMaking(function (Task $task) {
            $task->spent_hours = $task->estimated_hours * $this->faker->randomFloat(2, 0.9, 1.3);
        });
    }

    /**
     * Create a high priority task
     */
    public function highPriority(): static
    {
        return $this->state([
            'priority' => 2, // High
        ])->afterMaking(function (Task $task) {
            // High priority tasks often have shorter deadlines
            $task->due_date = $this->faker->dateTimeBetween('now', '+2 weeks');
        });
    }

    /**
     * Create an urgent task
     */
    public function urgent(): static
    {
        return $this->state([
            'priority' => 3, // Urgent
        ])->afterMaking(function (Task $task) {
            // Urgent tasks have very short deadlines
            $task->due_date = $this->faker->dateTimeBetween('now', '+3 days');
        });
    }

    /**
     * Create a low priority task
     */
    public function lowPriority(): static
    {
        return $this->state([
            'priority' => 0, // Low
        ]);
    }

    /**
     * Create an overdue task
     */
    public function overdue(): static
    {
        return $this->state([
            'status' => $this->faker->randomElement(['todo', 'in_progress']),
        ])->afterMaking(function (Task $task) {
            $task->due_date = $this->faker->dateTimeBetween('-2 weeks', '-1 day');
        });
    }

    /**
     * Create an AI-generated task
     */
    public function aiGenerated(): static
    {
        return $this->state([
            'title' => $this->faker->randomElement([
                'Set up development environment',
                'Configure database connections',
                'Implement responsive navigation',
                'Add form validation logic',
                'Create API endpoints',
                'Write unit tests',
                'Optimize database queries',
                'Implement caching strategy',
            ]),
            'metadata' => [
                'ai_source' => true,
                'ai_generator' => 'task_breakdown_ai',
                'ai_confidence' => $this->faker->randomFloat(2, 0.8, 0.95),
                'category' => 'development',
                'complexity' => 'medium',
            ],
        ]);
    }

    /**
     * Create a development task
     */
    public function development(): static
    {
        return $this->state([
            'title' => $this->faker->randomElement([
                'Implement user registration flow',
                'Create REST API endpoints',
                'Build database migration scripts',
                'Integrate third-party services',
                'Implement security middleware',
                'Create background job processing',
                'Build real-time notifications',
                'Implement file upload system',
            ]),
            'metadata' => [
                'category' => 'development',
                'skills_required' => ['PHP', 'Laravel', 'MySQL', 'JavaScript'],
                'complexity' => $this->faker->randomElement(['medium', 'complex']),
            ],
        ]);
    }

    /**
     * Create a design task
     */
    public function design(): static
    {
        return $this->state([
            'title' => $this->faker->randomElement([
                'Create user interface wireframes',
                'Design mobile app mockups',
                'Develop brand identity guidelines',
                'Create interactive prototypes',
                'Design email templates',
                'Create marketing graphics',
                'Design dashboard layouts',
                'Create icon library',
            ]),
            'metadata' => [
                'category' => 'design',
                'skills_required' => ['UI/UX Design', 'Adobe Creative Suite', 'Figma'],
                'complexity' => $this->faker->randomElement(['simple', 'medium']),
            ],
        ]);
    }

    /**
     * Create a testing task
     */
    public function testing(): static
    {
        return $this->state([
            'title' => $this->faker->randomElement([
                'Perform browser compatibility testing',
                'Execute user acceptance tests',
                'Conduct security penetration testing',
                'Test mobile responsiveness',
                'Validate API functionality',
                'Perform load testing',
                'Execute automated test suite',
                'Conduct accessibility audit',
            ]),
            'metadata' => [
                'category' => 'testing',
                'skills_required' => ['Testing', 'QA', 'Automation Tools'],
                'complexity' => 'medium',
            ],
        ]);
    }

    /**
     * Create a blocked task
     */
    public function blocked(): static
    {
        return $this->state([
            'status' => $this->faker->randomElement(['todo', 'in_progress']),
            'metadata' => [
                'blocked' => true,
                'blocker_reason' => $this->faker->randomElement([
                    'Waiting for client approval',
                    'Dependent on external API documentation',
                    'Waiting for design assets',
                    'Technical research required',
                    'Waiting for third-party integration',
                ]),
                'blocked_since' => $this->faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
        ]);
    }
}