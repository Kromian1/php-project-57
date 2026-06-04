@extends('layouts.app')

@section('title', __('common.tasks'))

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('common.tasks') }}</h1>
        @can('create', App\Models\Task::class)
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('task.create') }}
            </a>
        @endcan
    </div>

    <!-- Filters -->
    <div class="mb-8">
        {{ html()->form('GET', route('tasks.index'))->open() }}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[150px]">
                {{ html()->select('status_id', $statuses, request('status_id'))
                    ->placeholder(__('filter.all_statuses'))
                    ->class('w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none') }}
            </div>
            <div class="flex-1 min-w-[150px]">
                {{ html()->select('created_by_id', $creators, request('created_by_id'))
                    ->placeholder(__('filter.all_creators'))
                    ->class('w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none') }}
            </div>
            <div class="flex-1 min-w-[150px]">
                {{ html()->select('assigned_to_id', $assigners, request('assigned_to_id'))
                    ->placeholder(__('filter.all_assigners'))
                    ->class('w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none') }}
            </div>
            <div>
                {{ html()->submit(__('button.accept'))
                    ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition') }}
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>

    <!-- Tasks Table -->
    <div class="overflow-x-auto mt-8">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="px-6 py-3 border-b text-left">ID</th>
                <th class="px-6 py-3 border-b text-left">{{ __('task.name') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('task.status') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('task.creator') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('task.executor') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('task.create_date') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($filteredTasks as $filteredTask)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $filteredTask->id }}</td>
                    <td class="px-6 py-4"><a href="{{ route('tasks.show', $filteredTask) }}" class="underline hover:text-yellow-900">{{ $filteredTask->name }}</a></td>
                    <td class="px-6 py-4">{{ $filteredTask->status->name ?? '' }}</td>
                    <td class="px-6 py-4">{{ $filteredTask->creator->name }}</td>
                    <td class="px-6 py-4">{{ $filteredTask->assignee->name ?? '' }}</td>
                    <td class="px-6 py-4">{{ $filteredTask->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        @can('update', $filteredTask)
                            <a href="{{ route('tasks.edit', $filteredTask) }}" class="text-yellow-600 hover:text-yellow-900">
                                {{ __('button.edit') }}
                            </a>
                        @endcan

                        @can('delete', $filteredTask)
                                {{ html()->form('DELETE', route('tasks.destroy', $filteredTask))->id('delete-form-' . $filteredTask->id)->style('display: none;')->open() }}
                                {{ html()->hidden('_token', csrf_token()) }}
                                {{ html()->closeModelForm() }}

                                <a href="{{ route('tasks.destroy', $filteredTask) }}"
                                   onclick="if(confirm('{{ __('common.are_you_sure') }}')) { event.preventDefault(); document.getElementById('delete-form-{{ $filteredTask->id }}').submit(); } else { event.preventDefault(); }"
                                   class="text-red-600 hover:text-red-900">
                                    {{ __('button.delete') }}
                                </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 d-flex justify-content-center">
        {{ $filteredTasks->withQueryString()->links() }}
    </div>
@endsection
