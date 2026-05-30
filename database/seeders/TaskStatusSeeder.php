<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private array $taskStatuses = [
        'Новая',
        'В работе',
        'Тестирование',
        'Выполнено',
    ];

    public function run(): void
    {
        foreach ($this->taskStatuses as $taskStatus) {
            TaskStatus::factory()->create(['name' => $taskStatus]);
        }
    }
}
