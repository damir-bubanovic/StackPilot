<?php

namespace Tests\Feature\Api\V1;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_index_requires_authentication(): void
    {
        $project = Project::factory()->create();

        $this->getJson("/api/v1/projects/{$project->id}/tasks")
            ->assertUnauthorized();
    }

    public function test_user_can_list_and_create_tasks_for_own_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        Task::factory()->count(2)->create(['project_id' => $project->id]);

        $this->getJson("/api/v1/projects/{$project->id}/tasks")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'project_id', 'title', 'status'],
                ],
            ]);

        $create = $this->postJson("/api/v1/projects/{$project->id}/tasks", [
            'title' => 'New Task',
            'description' => 'Do the thing',
        ]);

        $create->assertCreated()
            ->assertJsonPath('data.title', 'New Task');

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'title' => 'New Task',
        ]);
    }

    public function test_user_cannot_access_tasks_for_someone_elses_project(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $owner->id]);
        Task::factory()->create(['project_id' => $project->id]);

        Sanctum::actingAs($other);

        $this->getJson("/api/v1/projects/{$project->id}/tasks")->assertForbidden();

        $this->postJson("/api/v1/projects/{$project->id}/tasks", [
            'title' => 'Should fail',
        ])->assertForbidden();
    }

    public function test_user_can_toggle_task_status_on_own_task(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'status' => 'todo',
        ]);

        Sanctum::actingAs($user);

        $this->patchJson("/api/v1/tasks/{$task->id}")
            ->assertOk()
            ->assertJsonPath('data.status', 'done');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'done',
        ]);
    }

    public function test_user_cannot_modify_or_delete_someone_elses_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $owner->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        Sanctum::actingAs($other);

        $this->patchJson("/api/v1/tasks/{$task->id}")->assertForbidden();
        $this->deleteJson("/api/v1/tasks/{$task->id}")->assertForbidden();
    }

    public function test_user_can_delete_own_task(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        Sanctum::actingAs($user);

        $this->deleteJson("/api/v1/tasks/{$task->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
