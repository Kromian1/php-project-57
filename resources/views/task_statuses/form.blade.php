@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-4">
    {{ html()->label(__('Name'), 'name')->class('block text-gray-700 text-sm font-bold mb-2') }}
    {{ html()->input('text', 'name')
        ->class('shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' . ($errors->has('name') ? ' border-red-500' : ''))
        ->attribute('autofocus') }}
    @error('name')
    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>
