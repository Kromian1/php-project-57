# Менеджер задач

### Тесты и состояние проекта:
[![check.yml](https://github.com/Kromian1/php-project-57/actions/workflows/check.yml/badge.svg)](https://github.com/Kromian1/php-project-57/actions/workflows/check.yml)
[![hexlet-check](https://github.com/Kromian1/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Kromian1/php-project-57/actions/workflows/hexlet-check.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=bugs)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Kromian1_php-project-57&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=Kromian1_php-project-57)


## О проекте

**Менеджер задач** — это веб-приложение для управления задачами, разработанное на Laravel 13.
Приложение позволяет пользователям создавать задачи, назначать исполнителей, управлять статусами и метками, а также выполнять поиск и фильтрацию данных. Проект реализует типичный жизненный цикл задачи: от создания до завершения, с разграничением прав доступа между пользователями.

## Демо
[Менеджер задач на Render.com](https://php-project-57-avpo.onrender.com)

## Возможности

### Авторизация и аутентификация

регистрация новых пользователей;
вход и выход из системы;
защита маршрутов для авторизованных пользователей;
разграничение прав доступа через Laravel Policies.

### Управление задачами

Пользователь может:

создавать задачи;
просматривать список задач;
открывать страницу отдельной задачи;
редактировать задачу;
удалять задачу;
назначать исполнителя;
изменять статус;
добавлять метки.

Каждая задача содержит:

название;
описание;
автора;
исполнителя;
статус;
набор меток;
дату создания.

### Управление статусами

Статусы позволяют отслеживать этап выполнения задачи.
Поддерживаются операции:
создание статуса;
редактирование статуса;
удаление статуса;
отображение списка статусов.
Примеры статусов:
Новый
В работе
На проверке
Завершён

### Управление метками

Метки используются для группировки и дополнительной классификации задач.
Поддерживаются:
создание меток;
редактирование меток;
удаление меток;
привязка нескольких меток к задаче.

### Фильтрация задач

Для удобства работы реализована фильтрация по:
статусу;
автору задачи;
исполнителю задачи.
Это позволяет быстро находить нужные задачи даже при большом количестве записей.

## Архитектура приложения

Основные сущности системы:

### Пользователь (User)

Хранит информацию о зарегистрированных пользователях системы.
Пользователь может:
создавать задачи;
быть исполнителем задач;
управлять собственными данными.

### Задача (Task)

Центральная сущность приложения.
Связи:
принадлежит автору;
может иметь исполнителя;
имеет один статус;
может иметь множество меток.

### Статус (TaskStatus)

Определяет текущее состояние задачи.
Связь:
один статус может использоваться многими задачами.

### Метка (Label)
Дополнительная характеристика задачи.

Связь:
многие ко многим с задачами.

## Используемые технологии

### Backend

PHP 8.3
Laravel 13
Eloquent ORM
Blade Templates

### База данных

PostgreSQL
SQLite (для тестирования)

### Frontend

Blade
Bootstrap
Vite

### Тестирование

PHPUnit
Laravel Testing Framework

### Контроль качества

PHP CodeSniffer
Laravel Pint
SonarCloud

### Инфраструктура

GitHub Actions
Render

## Установка проекта

### Клонирование репозитория

git clone https://github.com/Kromian1/php-project-57.git

cd php-project-57

### Установка зависимостей

composer install

npm install

### Создание файла окружения

cp .env.example .env

### Генерация ключа приложения

php artisan key:generate

### Настройка базы данных

Укажите параметры подключения в файле .env.

После этого выполните миграции:

php artisan migrate

### Сборка фронтенда

npm run build

### Запуск приложения

php artisan serve

После запуска приложение будет доступно по адресу:

http://localhost:8000

## Быстрая установка

Для удобства проект содержит сценарий автоматической настройки:

composer run setup

Команда выполняет:

установку PHP-зависимостей;
создание файла окружения;
генерацию ключа приложения;
запуск миграций;
установку JavaScript-зависимостей;
сборку фронтенда.

### Запуск тестов

Выполнить все тесты:
composer test
или
php artisan test

### Проверка качества кода
Проверка кодстайла:
vendor/bin/phpcs
Автоматическое форматирование:
./vendor/bin/pint

### Структура проекта
app/
├── Filters
├── Http
│   ├── Controllers
│   ├── Requests
│   └── Middleware
├── Models
├── Policies
└── Providers

database/
├── migrations
├── factories
└── seeders

resources/
├── views
├── lang
└── css

routes/
tests/

### Особенности реализации

В проекте используются:

Form Requests для валидации входящих данных;
Eloquent Relationships для работы со связями между моделями;
Policies для разграничения доступа;
Фильтрация через отдельные классы фильтров;
Локализация интерфейса;
Feature и Unit тесты;
CI-проверки через GitHub Actions.

## Автор

**Михаил Кузнецов**

**GitHub:** https://github.com/Kromian1
