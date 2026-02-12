<?php

namespace Tests\Unit\Policies;

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_view_update_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $policy = new ProjectPolicy();

        $this->assertTrue($policy->view($user, $project));
        $this->assertTrue($policy->update($user, $project));
        $this->assertTrue($policy->delete($user, $project));
    }

    public function test_non_owner_cannot_view_update_delete_project(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $owner->id]);

        $policy = new ProjectPolicy();

        $this->assertFalse($policy->view($other, $project));
        $this->assertFalse($policy->update($other, $project));
        $this->assertFalse($policy->delete($other, $project));
    }
}
