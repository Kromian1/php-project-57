<?php

namespace Tests\Feature;

use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\{Task, Label, TaskStatus, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected const int PAGINATION_PER_PAGE = 15;

    protected User $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_response_code_and_pagination_15_per_page(): void
    {
        $this->createLabels(20);

        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
        $response->assertViewIs('labels.index');
        $response->assertViewHas('labels');

        $labels = $response->viewData('labels');

        $this->assertEquals(self::PAGINATION_PER_PAGE, $labels->count());
        $this->assertTrue($labels->hasMorePages());
    }

    public function test_create_label_response_code(): void
    {
        $response = $this->actingAsGuest()->get(route('labels.create'));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertViewIs('labels.create');
        $response->assertViewHas('label');
        $response->assertStatus(200);
    }

    public function test_store_label_success(): void
    {
        $response = $this->actingAs($this->user)->post(route('labels.store'), [
            'name' => 'Test label'
        ]);

        $response->assertValid();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', [
            'name' => 'Test label'
        ]);
    }

    #[DataProvider('InvalidNameProvider')]
    public function test_store_label_validation_fails(string $invalidName): void
    {
        $this->createLabel('Duplicate Name');

        $response = $this->actingAs($this->user)->post(route('labels.store'), [
            'name' => $invalidName
        ]);

        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();
    }

    public function test_edit_label(): void
    {
        $label = $this->createLabel();

        $response = $this->actingAsGuest()->get(route('labels.edit', $label));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('labels.edit', $label));
        $response->assertViewIs('labels.edit');
        $response->assertViewHas('label', $label);
        $response->assertStatus(200);
    }

    public function test_edit_label_non_existed(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', [
            'label' => 000000
        ]));
        $response->assertStatus(404);
    }

    public function test_update_label(): void
    {
        $label = $this->createLabel();

        $response = $this->actingAsGuest()->patch(route('labels.update', $label), [
            'name' => 'New Test label'
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->patch(route('labels.update', $label), [
            'name' => 'New Test label'
        ]);
        $response->assertValid();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', [
            'id' => $label->id,
            'name' => 'New Test label'
        ]);
    }

    #[DataProvider('InvalidNameProvider')]
    public function test_update_label_validation_fails(string $invalidName): void
    {
        $label = $this->createLabel('Duplicate Name');

        $response = $this->actingAs($this->user)->put(route('labels.update', $label), [
            'name' => $invalidName
        ]);
        $response->assertInvalid(['name']);
        $response->assertSessionHasErrors();
    }

    public function test_delete_label(): void
    {
        $label = $this->createLabel();

        $response = $this->actingAsGuest()->delete(route('labels.destroy', $label));

        $response->assertStatus(403);
        $this->assertDatabaseHas('labels', [
            'id' => $label->id
        ]);

        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', [
            'id' => $label
        ]);
    }

    public function test_delete_label_non_existed(): void
    {
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', [
            'label' => 0000
        ]));

        $response->assertStatus(404);
    }

    public function test_delete_label_connected_with_tasks(): void
    {
        $task = Task::factory()->create();
        $task->labels()->create([
            'name' => 'Test label'
        ]);

        $label = $task->labels()->first();

        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', [
            'id' => $label->id
        ]);
    }

    public static function invalidNameProvider(): array
    {
        return [
            'empty' => [''],
            'duplicate' => ['Duplicate Name']
        ];
    }

    protected function createLabel(string $name = ''): Label
    {
        return empty($name) ?
            Label::factory()->create() :
            Label::factory()->create(['name' => $name]);
    }

    protected function createLabels(int $pagination): Collection
    {
        return Label::factory()->count($pagination)->create();
    }
}
