@extends('layouts.app')

@section('title', $task->name)

@section('header', $task->name)

@section('content')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 dark:border-gray-600">
            <tbody>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left w-1/4">{{ __('task.name') }}</th>
                <td class="px-6 py-4">{{ $task->name }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left">{{ __('task.status') }}</th>
                <td class="px-6 py-4">{{ $task->status->name ?? __('task.without_status') }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left">{{ __('task.creator') }}</th>
                <td class="px-6 py-4">{{ $task->creator->name }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left">{{ __('task.executor') }}</th>
                <td class="px-6 py-4">{{ $task->assignee->name ?? __('task.not_assigned') }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left">{{ __('task.create_date') }}</th>
                <td class="px-6 py-4">{{ $task->created_at->format('d.m.Y H:i') }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left">{{ __('task.description') }}</th>
                <td class="px-6 py-4">{{ $task->description ?? __('task.without_description') }}</td>
            </tr>
            <tr>
                <th class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-left">{{ __('common.labels') }}</th>
                <td class="px-6 py-4">
                    @foreach($task->labels as $label)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                {{ $label->name }}
                            </span>
                    @endforeach
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('button.back') }}
        </a>
    </div>
@endsection
