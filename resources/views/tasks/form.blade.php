@foreach($users as $id => $name)
    <div>{{ $id }} => {{ $name }}</div>
@endforeach
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        {{ html()->label(__('task.name'), 'name')->class('block text-gray-700 font-bold mb-2') }}
        {{ html()->input('text', 'name')
            ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('name') ? 'border-red-500' : ''))
            ->attribute('autofocus') }}
        @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {{ html()->label(__('task.description'), 'description')->class('block text-gray-700 font-bold mb-2') }}
        {{ html()->input('text', 'description')
            ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('description') ? 'border-red-500' : '')) }}
        @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {{ html()->label(__('task.status'), 'status_id')->class('block text-gray-700 font-bold mb-2') }}
        {{ html()->select('status_id', $statuses)
            ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('status_id') ? 'border-red-500' : ''))
            ->placeholder(__('filter.select_status')) }}
        @error('status_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {{ html()->label(__('task.executor'), 'assigned_to_id')->class('block text-gray-700 font-bold mb-2') }}
        {{ html()->select('assigned_to_id', $users)
            ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('assigned_to_id') ? 'border-red-500' : ''))
            ->placeholder(__('filter.select_user')) }}
        @error('assigned_to_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {{ html()->label(__('common.labels'), 'labels')->class('block text-gray-700 font-bold mb-3') }}

        <div class="space-y-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
            @foreach($labels as $id => $name)
                <div class="flex items-center">
                    {{ html()->checkbox('labels[]', in_array($id, $taskLabels ?? []), $id)
                        ->class('h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded') }}
                    {{ html()->label($name, 'labels_' . $id)->class('ml-3 text-gray-700') }}
                </div>
            @endforeach
        </div>

        @error('labels')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>
