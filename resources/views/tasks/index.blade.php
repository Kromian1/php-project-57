@extends('layouts.app')

@section('title', __('Tasks'))

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('Tasks') }}</h1>
        @can('create', App\Models\Task::class)
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create task') }}
            </a>
        @endcan
    </div>

    <!-- Filters -->
    <div class="mb-8">
        {{ html()->form('GET', route('tasks.index'))->open() }}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[150px]">
                {{ html()->select('status_id', $statuses, request('status_id'))
                    ->placeholder(__('All statuses'))
                    ->class('w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none') }}
            </div>
            <div class="flex-1 min-w-[150px]">
                {{ html()->select('created_by_id', $creators, request('created_by_id'))
                    ->placeholder(__('All creators'))
                    ->class('w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none') }}
            </div>
            <div class="flex-1 min-w-[150px]">
                {{ html()->select('assigned_to_id', $assigners, request('assigned_to_id'))
                    ->placeholder(__('All assigners'))
                    ->class('w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none') }}
            </div>
            <div>
                {{ html()->submit(__('Accept'))
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
                <th class="px-6 py-3 border-b text-left">{{ __('Name') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Status') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Creator') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Executor') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Create date') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Actions') }}</th>
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
                    <td class="px-6 py-4">{{ $filteredTask->created_at->format('d.m.Y H:i') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        @can('update', $filteredTask)
                            <a href="{{ route('tasks.edit', $filteredTask) }}" class="text-yellow-600 hover:text-yellow-900">
                                {{ __('Edit') }}
                            </a>
                        @endcan

                        @can('delete', $filteredTask)
                            {{ html()->modelForm($filteredTask, 'DELETE', route('tasks.destroy', $filteredTask))->open() }}
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

    <!-- Pagination -->
    <div class="mt-6 d-flex justify-content-center">
        {{ $filteredTasks->withQueryString()->links() }}
    </div>
@endsection
