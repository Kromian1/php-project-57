<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private array $labels = [
        'Улучшение' => 'Предложение по улучшению функциональности или производительности',
        'Ошибка' => 'Проблема, баг или некорректное поведение системы',
        'Аналитика' => 'Задачи по сбору данных, исследованию и анализу требований',
        'Дизайн' => 'Работы по проектированию интерфейсов и пользовательского опыта',
        'Тест' => 'Написание тестов, проверка качества, QA мероприятия',
        'Архитектура' => 'Проектирование структуры приложения и технических решений',
        'Релиз' => 'Подготовка и проведение выпуска новой версии',
    ];

    public function run(): void
    {
        foreach ($this->labels as $name => $description) {
            Label::factory()->create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
