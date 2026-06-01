@extends('layouts.app')

@section('title', __('common.labels'))

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('common.labels') }}</h1>
        @can('create', App\Models\Label::class)
            <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('label.create') }}
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 dark:border-gray-600">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="px-6 py-3 border-b text-left">ID</th>
                <th class="px-6 py-3 border-b text-left">{{ __('label.name') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('label.description') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('common.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($labels as $label)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $label->id }}</td>
                    <td class="px-6 py-4">{{ $label->name }}</td>
                    <td class="px-6 py-4">{{ $label->description }}</td>
                    <td class="px-6 py-4 space-x-2">
                        @can('update', $label)
                            <a href="{{ route('labels.edit', $label) }}" class="text-yellow-600 hover:text-yellow-900">
                                {{ __('button.edit') }}
                            </a>
                        @endcan

                        @can('delete', $label)
                                <a href="{{ route('labels.destroy', $label)}}?{{ csrf_token() }} }}"
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
        {{ $labels->links() }}
    </div>
@endsection
