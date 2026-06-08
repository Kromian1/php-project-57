<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected const int PAGINATION_PER_PAGE = 15;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
    }

    public function test_index_response_code_and_pagination_15_per_page(): void
    {
        $this->createTasks(20);

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('filteredTasks');

        $tasks = $response->viewData('filteredTasks');

        $this->assertEquals(self::PAGINATION_PER_PAGE, $tasks->count());
        $this->assertTrue($tasks->hasMorePages());
    }

    public function test_create_task_response_code(): void
    {
        $response = $this->actingAsGuest()->get(route('tasks.create'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.create');
        $response->assertViewHas('task');
    }

    public function test_store_task_success(): void
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), [
            'name' => 'Test task',
            'status_id' => $this->status->id,
        ]);

        $response->assertValid();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'name' => 'Test task',
        ]);
    }

    public function test_edit_status_success(): void
    {
        $task = $this->createTask();

        $response = $this->actingAsGuest()->get(route('tasks.edit', $task));

        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.edit');
        $response->assertViewHas('task', $task);
    }

    public function test_edit_task_non_existed(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.edit', [
            'task' => 000,
        ]));

        $response->assertStatus(404);
    }

    public function test_update_task_success(): void
    {
        $status = $this->status;
        $task = $this->createTask();

        $response = $this->actingAs($this->user)->put(route('tasks.update', [
            'task' => $task,
        ]), [
            'name' => 'New Test task',
            'status_id' => $status->id,
        ]);

        $response->assertValid();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'New Test task',
            'status_id' => $status->id,
        ]);
    }

    #[DataProvider('InvalidParametersProvider')]
    public function test_create_task_validation_fails(array $invalidParameters, array $expectedErrors): void
    {
        $this->createTask();

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $invalidParameters);

        $response->assertInvalid($expectedErrors);
        $response->assertSessionHasErrors();
    }

    public function test_delete_task_success(): void
    {
        $task = $this->createTaskWithOwner($this->user);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_delete_fails(): void
    {
        $task = $this->createTask();

        $response = $this->actingAsGuest()->delete(route('tasks.destroy', $task));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $response->assertStatus(403);
    }

    public function test_delete_task_non_existed(): void
    {
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', [
            'task' => 99900,
        ]));

        $response->assertStatus(404);
    }

    public function test_show_task(): void
    {
        $task = $this->createTask();

        $response = $this->actingAsGuest()->get(route('tasks.show', [
            'task' => $task,
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.show');
        $response->assertViewHas('task', $task);
    }

    public static function invalidParametersProvider(): array
    {
        return [
            'empty name' => [
                ['name' => ''],
                ['name'],
            ],
            'empty status_id' => [
                ['status_id' => null],
                ['status_id'],
            ],
            'invalid status_id' => [
                ['status_id' => 99999],
                ['status_id'],
            ],
            'invalid format status_id' => [
                ['status_id' => 'asd'],
                ['status_id'],
            ],
            'invalid assigned_to_id' => [
                ['assigned_to_id' => 99999],
                ['assigned_to_id'],
            ],
            'invalid format assigned_to_id' => [
                ['assigned_to_id' => 'asd'],
                ['assigned_to_id'],
            ],
        ];
    }

    protected function createTask(string $name = ''): Task
    {
        return empty($name) ?
            Task::factory()->create() :
            Task::factory()->create(['name' => $name]);
    }

    protected function createTaskWithOwner(User $user): Task
    {
        return Task::factory()->create(['created_by_id' => $user->id]);
    }

    public function createTasks(int $pagination): Collection
    {
        return Task::factory()->count($pagination)->create();
    }
}
