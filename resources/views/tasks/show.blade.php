@extends('layouts.app')

@section('title', __('Task'))

@section('header', __('Task'))

@section('content')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <tbody>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 text-left w-1/4">{{ __('Name') }}</th>
                <td class="px-6 py-4">{{ $task->name }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 text-left">{{ __('Status') }}</th>
                <td class="px-6 py-4">{{ $task->status->name ?? __('Without a status') }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 text-left">{{ __('Creator') }}</th>
                <td class="px-6 py-4">{{ $task->creator->name }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 text-left">{{ __('Executor') }}</th>
                <td class="px-6 py-4">{{ $task->assignee->name ?? __('Not assigned') }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 text-left">{{ __('Create date') }}</th>
                <td class="px-6 py-4">{{ $task->created_at->format('d.m.Y H:i') }}</td>
            </tr>
            <tr class="border-b">
                <th class="px-6 py-3 bg-gray-100 text-left">{{ __('Description') }}</th>
                <td class="px-6 py-4">{{ $task->description ?? __('Without a description') }}</td>
            </tr>
            <tr>
                <th class="px-6 py-3 bg-gray-100 text-left">{{ __('Labels') }}</th>
                <td class="px-6 py-4">
                    @forelse($task->labels as $label)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                {{ $label->name }}
                            </span>
                    @endforelse
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('Back') }}
        </a>
    </div>
@endsection
