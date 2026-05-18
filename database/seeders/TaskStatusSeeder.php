<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private array $taskStatuses = [
        'Новый',
        'В работе',
        'Тестирование',
        'Выполнено'
    ];
    public function run(): void
    {
        foreach ($this->taskStatuses as $taskStatus) {
            $status = new TaskStatus();
            $status->fill(['name' => $taskStatus])->save();
        }
    }
}
