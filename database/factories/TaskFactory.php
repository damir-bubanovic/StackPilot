<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),

            'title' => $this->faker->sentence(4),

            // Keep descriptions short for test payloads
            'description' => $this->faker->optional()->sentence(),

            // Default to todo so toggle tests are deterministic
            'status' => 'todo',

            'due_date' => $this->faker
                ->optional()
                ->dateTimeBetween('now', '+1 month')
                ?->format('Y-m-d'),
        ];
    }
}
