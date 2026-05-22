@extends('layouts.app')

@section('title', 'Статусы задач')

@section('header', 'Статусы задач')

@section('content')
    <div>
        <h1>Статусы задач</h1>
        @can('create', App\Models\TaskStatus::class)
            <a href="{{ route('task_statuses.create') }}">Создать статус</a>
        @endcan
    </div>
    <div>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
                @foreach($taskStatuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        <td>
                            @can('update', $status)
                                <a href="{{ route('task_statuses.edit', $status) }}">Изменить</a>
                            @endcan
                            @can('delete', $status)
                                    {{ html()->modelForm($status, 'DELETE', route('task_statuses.destroy', $status))->open() }}
                                        {{ html()->submit('Удалить')->attribute('onclick', 'return confirm (\'Вы уверены?\'') }}
                                    {{ html()->closeModelForm() }}
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
