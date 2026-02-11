<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'demo@stackpilot.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        $projects = Project::factory()
            ->count(3)
            ->for($user)
            ->create();

        foreach ($projects as $project) {
            Task::factory()->count(8)->for($project)->create();
        }
    }
}
