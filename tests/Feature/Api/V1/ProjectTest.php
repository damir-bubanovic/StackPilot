<?php

namespace Tests\Feature\Api\V1;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_index_requires_authentication(): void
    {
        $this->getJson('/api/v1/projects')->assertUnauthorized();
    }

    public function test_user_can_create_and_list_only_own_projects(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $create = $this->postJson('/api/v1/projects', [
            'name' => 'My Project',
            'description' => 'Description',
        ]);

        $create->assertCreated()
            ->assertJsonPath('data.name', 'My Project');

        $own = Project::factory()->count(2)->create(['user_id' => $user->id]);
        $foreign = Project::factory()->create();

        $index = $this->getJson('/api/v1/projects');

        $index->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta']);

        $ids = collect($index->json('data'))->pluck('id');

        $this->assertTrue($ids->contains($own->first()->id));
        $this->assertFalse($ids->contains($foreign->id));
    }

    public function test_user_cannot_delete_someone_elses_project(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $owner->id]);

        Sanctum::actingAs($other);

        $this->deleteJson("/api/v1/projects/{$project->id}")
            ->assertForbidden();
    }

    public function test_user_can_delete_own_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->deleteJson("/api/v1/projects/{$project->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
