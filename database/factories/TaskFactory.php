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

            'description' => $this->faker->sentence(),

            'status' => $this->faker->randomElement(['todo', 'doing', 'done']),

            'due_date' => $this->faker
                ->dateTimeBetween('now', '+1 month')
                ->format('Y-m-d'),
        ];
    }
}
