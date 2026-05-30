<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private array $taskStatuses = [
        '1',
        '2',
        '3',
        '4',
        '1',
        '2',
        '3',
        '4',
        '1',
        '2',
        '3',
        '4',
        '1',
        '2',
        '3',
        '4',
        '1',
        '2',
        '3',
        '4',
    ];

    public function run(): void
    {
        foreach ($this->taskStatuses as $status) {
            Task::factory()->create(['status_id' => $status]);
        }
    }
}
