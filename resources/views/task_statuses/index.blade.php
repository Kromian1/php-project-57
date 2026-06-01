@extends('layouts.app')

@section('title', __('common.statuses'))

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('common.statuses') }}</h1>
        @can('create', App\Models\TaskStatus::class)
            <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('status.create') }}
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 dark:border-gray-600">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="px-6 py-3 border-b text-left">ID</th>
                <th class="px-6 py-3 border-b text-left">{{ __('status.name') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($taskStatuses as $status)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $status->id }}</td>
                    <td class="px-6 py-4">{{ $status->name }}</td>
                    <td class="px-6 py-4 space-x-2">
                        @can('update', $status)
                            <a href="{{ route('task_statuses.edit', $status) }}" class="text-yellow-600 hover:text-yellow-900">
                                {{ __('button.edit') }}
                            </a>
                        @endcan

                        @can('delete', $status)
                                <a href="{{ route('task_statuses.destroy', $status) }}?{{ csrf_token() }}"
                                   class="text-red-600 hover:text-red-900"
                                   data-method="delete"
                                   data-confirm="{{ __('common.are_you_sure') }}">
                                    {{ __('button.delete') }}
                                </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $taskStatuses->links() }}
    </div>
@endsection
