<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Illuminate\Support\Facades\Gate;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected const int PAGINATION_PER_PAGE = 15;

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

        $user = $this->user;

        Gate::shouldReceive('authorize')->with('create', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->get(route('task_statuses.create'));

        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.create');
        $response->assertViewHas('status');
    }

    public function test_store_status_success(): void
    {
        $user = $this->user;

        Gate::shouldReceive('authorize')->with('create', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->post(route('task_statuses.store'), [
            'name' => 'New Task Status',
        ]);
        $response->assertValid();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'New Task Status',
        ]);
    }

    #[DataProvider('InvalidNameProvider')]
    public function test_store_status_validation_fails(string $invalidName): void
    {
        $user = $this->user;
        $this->createTaskStatus('Duplicate Name');

        Gate::shouldReceive('authorize')->with('create', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->post(route('task_statuses.store'), [
            'name' => $invalidName,
        ]);
        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();
    }

    public function test_edit_status_success(): void
    {
        $user = $this->user;
        $taskStatus = $this->createTaskStatus();

        Gate::shouldReceive('authorize')->with('update', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->get(route('task_statuses.edit', [
            'task_status' => $taskStatus->id,
        ]));
        $response->assertStatus(200);
        $response->assertViewIs('task_statuses.edit');
        $response->assertViewHas('status', $taskStatus);
    }

    public function test_edit_status_as_guest(): void
    {
        $taskStatus = $this->createTaskStatus();
        $response = $this->actingAsGuest()->get(route('task_statuses.edit', [
            'task_status' => $taskStatus->id,
        ]));

        $response->assertStatus(403);
    }

    public function test_edit_status_non_existed(): void
    {
        $user = $this->user;
        Gate::shouldReceive('authorize')->with('update', TaskStatus::class)->andReturn(false);

        $response = $this->actingAs($user)->get(route('task_statuses.edit', [
            'task_status' => 000,
        ]));

        $response->assertStatus(404);
    }

    public function test_update_status_success(): void
    {
        $user = $this->user;
        $taskStatus = $this->createTaskStatus();
        Gate::shouldReceive('authorize')->with('update', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->patch(route('task_statuses.update', [
            'task_status' => $taskStatus->id,
        ]), [
            'name' => 'New Task Status'
        ]);

        $response->assertValid();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', [
            'id' => $taskStatus->id,
            'name' => 'New Task Status'
        ]);
    }

    public function test_update_status_empty_name_validation(): void
    {
        $user = $this->user;
        $taskStatus = $this->createTaskStatus();
        Gate::shouldReceive('authorize')->with('update', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->patch(route('task_statuses.update', [
            'task_status' => $taskStatus->id,
        ]), [
            'name' => ''
        ]);

        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();

        $this->assertDatabaseHas('task_statuses', [
            'id' => $taskStatus->id,
            'name' => $taskStatus->name
        ]);
    }

    public function test_update_status_duplicate_name_validation(): void
    {
        $user = $this->user;
        $this->createTaskStatus('Duplicate Name');
        $statusToUpdate = $this->createTaskStatus();
        Gate::shouldReceive('authorize')->with('update', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->patch(route('task_statuses.update',[
            'task_status' => $statusToUpdate->id,
        ]), [
            'name' => 'Duplicate Name'
        ]);

        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();
    }

    public function test_delete_status_success(): void
    {
        $user = $this->user;
        $taskStatus = $this->createTaskStatus();

        Gate::shouldReceive('authorize')->with('delete', TaskStatus::class)->andReturn(true);

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', [
            'task_status' => $taskStatus->id,
        ]));

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', [
            'id' => $taskStatus->id,
        ]);
    }

    public function test_delete_status_as_guest(): void
    {
        $taskStatus = $this->createTaskStatus();

        $response = $this->actingAsGuest()->delete(route('task_statuses.destroy', [
            'task_status' => $taskStatus->id,
        ]));

        $response->assertStatus(403);
    }

    public function test_delete_status_non_existed(): void
    {
        $user = $this->user;
        Gate::shouldReceive('authorize')->with('delete', TaskStatus::class)->andReturn(false);

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', [
            'task_status' => 0000,
        ]));

        $response->assertStatus(404);
    }

    protected function createTaskStatus(string $name = ''): TaskStatus
    {
        return empty($name) ?
            TaskStatus::factory()->create() :
            TaskStatus::factory()->create(['name' => $name]);
    }

    public static function invalidNameProvider(): array
    {
        return [
            'empty' => [''],
            'duplicate' => ['Duplicate Name']
        ];
    }

    protected function createTaskStatuses(int $pagination): Collection
    {
        return TaskStatus::factory()->count($pagination)->create();
    }
}
