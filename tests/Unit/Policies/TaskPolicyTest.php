<?php

namespace Tests\Unit\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_view_update_delete_task(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $policy = new TaskPolicy();

        $this->assertTrue($policy->view($user, $task));
        $this->assertTrue($policy->update($user, $task));
        $this->assertTrue($policy->delete($user, $task));
    }

    public function test_non_owner_cannot_view_update_delete_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $owner->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $policy = new TaskPolicy();

        $this->assertFalse($policy->view($other, $task));
        $this->assertFalse($policy->update($other, $task));
        $this->assertFalse($policy->delete($other, $task));
    }
}
