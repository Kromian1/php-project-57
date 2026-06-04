<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected const int PAGINATION_PER_PAGE = 15;
    protected const string NEW_TEST_NAME = 'New Task Status';
    protected const string DUPLICATE_NAME = 'Duplicate Name';

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_response_code_and_pagination_15_per_page(): void
    {
        $this->createTaskStatuses(20);

        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
        $response->assertViewHas('taskStatuses');

        $taskStatuses = $response->viewData('taskStatuses');

        $this->assertEquals(self::PAGINATION_PER_PAGE, $taskStatuses->count());
        $this->assertTrue($taskStatuses->hasMorePages());
    }

    public function test_create_status_response_code(): void
    {
        $response = $this->actingAsGuest()->get(route('task_statuses.create'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.create');
        $response->assertViewHas('status');
    }

    public function test_store_status_success(): void
    {
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), [
            'name' => $this::NEW_TEST_NAME,
        ]);
        $response->assertValid();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', [
            'name' => $this::NEW_TEST_NAME,
        ]);
    }

    #[DataProvider('InvalidNameProvider')]
    public function test_status_validation_fails(string $invalidName): void
    {
        $this->createTaskStatus($this::DUPLICATE_NAME);

        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), [
            'name' => $invalidName,
        ]);
        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();
    }

    public function test_edit_status(): void
    {
        $taskStatus = $this->createTaskStatus();

        $response = $this->actingAsGuest()->get(route('task_statuses.edit', [
            'task_status' => $taskStatus,
        ]));

        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', [
            'task_status' => $taskStatus,
        ]));
        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.edit');
        $response->assertViewHas('status', $taskStatus);
    }

    public function test_edit_status_non_existed(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', [
            'task_status' => 000,
        ]));

        $response->assertStatus(404);
    }

    public function test_update_status_success(): void
    {
        $taskStatus = $this->createTaskStatus();

        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', [
            'task_status' => $taskStatus,
        ]), [
            'name' => $this::NEW_TEST_NAME,
        ]);

        $response->assertValid();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', [
            'id' => $taskStatus->id,
            'name' => $this::NEW_TEST_NAME,
        ]);
    }

    public function test_delete_status_success(): void
    {
        $taskStatus = $this->createTaskStatus();

        $response = $this->actingAsGuest()->delete(route('task_statuses.destroy', [
            'task_status' => $taskStatus,
        ]));

        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', [
            'task_status' => $taskStatus,
        ]));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', [
            'id' => $taskStatus->id,
        ]);
    }

    public function test_delete_status_non_existed(): void
    {
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', [
            'task_status' => 0000,
        ]));

        $response->assertStatus(404);
    }

    public function test_delete_status_connected_with_tasks(): void
    {
        $taskStatus = $this->createTaskStatus();
        $task = Task::factory()->create([
            'status_id' => $taskStatus->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', [
            'task_status' => $taskStatus,
        ]));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', [
            'id' => $task->id,
        ]);
    }

    public static function invalidNameProvider(): array
    {
        return [
            'empty' => [''],
            'duplicate' => ['Duplicate Name'],
        ];
    }

    protected function createTaskStatus(string $name = ''): TaskStatus
    {
        return empty($name) ?
            TaskStatus::factory()->create() :
            TaskStatus::factory()->create(['name' => $name]);
    }

    protected function createTaskStatuses(int $pagination): Collection
    {
        return TaskStatus::factory()->count($pagination)->create();
    }
}
