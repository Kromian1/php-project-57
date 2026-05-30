@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        {{ html()->label(__('Name'), 'name')->class('block text-gray-700 font-bold mb-2') }}
        {{ html()->input('text', 'name')
            ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('name') ? 'border-red-500' : ''))
            ->attribute('autofocus') }}
        @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        {{ html()->label(__('Description'), 'description')->class('block text-gray-700 font-bold mb-2') }}
        {{ html()->textarea('description')
            ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('description') ? 'border-red-500' : ''))
            ->rows(4) }}
        @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
