@extends('layouts.app')

@section('title', __('Tasks'))

@section('header', __('Tasks'))

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('Tasks') }}</h1>
        @can('create', App\Models\Task::class)
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create task') }}
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 dark:border-gray-600">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="px-6 py-3 border-b text-left">ID</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Name') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Status') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Creator') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Executor') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Create date') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $task->id }}</td>
                    <td class="px-6 py-4"><a href="{{ route('tasks.show', $task) }}" class="underline hover:text-yellow-900">{{ $task->name }}</a></td>
                    <td class="px-6 py-4">{{ $task->status->name ?? '' }}</td>
                    <td class="px-6 py-4">{{ $task->creator->name }}</td>
                    <td class="px-6 py-4">{{ $task->assignee->name ?? '' }}</td>
                    <td class="px-6 py-4">{{ $task->created_at->format('d.m.Y H:i') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:text-yellow-900">
                                {{ __('Edit') }}
                            </a>
                        @endcan

                        @can('delete', $task)
                            {{ html()->modelForm($task, 'DELETE', route('tasks.destroy', $task))->open() }}
                            {{ html()->submit(__('Delete'))
                                ->class('text-red-600 hover:text-red-900')
                                ->attribute('onclick', "return confirm('" . __('Are you sure?') . "')")
                            }}
                            {{ html()->closeModelForm() }}
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
@endsection
