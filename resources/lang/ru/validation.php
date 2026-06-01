<?php

return [
    'required' => 'Это обязательное поле',
    'exists' => 'Выбранное значение для :attribute некорректно.',
    'confirmed' => 'Пароль и подтверждение не совпадают',
    'min' => [
        'string' => ':attribute должен иметь длину не менее :min символов.',
    ],
    'attributes' => [
        'name' => 'Название',
        'status_id' => 'Статус',
        'assigned_to_id' => 'Исполнитель',
        'description' => 'Описание',
        'labels' => 'Метки',
        'email' => 'Электронная почта',
        'password' => 'Пароль',
        'current_password' => 'Текущий пароль',
    ],
];
