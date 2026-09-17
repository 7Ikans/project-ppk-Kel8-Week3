<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteListTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_delete_list_with_tasks_and_collaborators(): void
    {
        $owner = User::factory()->create();
        $collaborator = User::factory()->create();

        $list = TaskList::create([
            'user_id' => $owner->id,
            'name' => 'List Test SRS-10',
            'description' => 'Testing delete list',
        ]);

        $task = Task::create([
            'list_id' => $list->id,
            'title' => 'Task Test SRS-10',
        ]);

        $list->members()->attach($collaborator->id);

        $this->actingAs($owner)
            ->delete(route('lists.destroy', $list))
            ->assertRedirect(route('lists.index'));

        $this->assertDatabaseMissing('lists', [
            'id' => $list->id,
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);

        $this->assertDatabaseMissing('list_user', [
            'list_id' => $list->id,
            'user_id' => $collaborator->id,
        ]);
    }
}
