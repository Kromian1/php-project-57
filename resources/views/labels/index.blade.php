@extends('layouts.app')

@section('title', __('Labels'))

@section('header', __('Labels'))

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">{{ __('Labels') }}</h1>
        @can('create', App\Models\Label::class)
            <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create label') }}
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 border-b text-left">ID</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Name') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Description') }}</th>
                <th class="px-6 py-3 border-b text-left">{{ __('Actions') }}</th>
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
                                {{ __('Edit') }}
                            </a>
                        @endcan

                        @can('delete', $label)
                            {{ html()->modelForm($label, 'DELETE', route('labels.destroy', $label))->open() }}
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
        {{ $taskStatuses->links() }}
    </div>
@endsection
