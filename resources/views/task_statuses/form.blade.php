<div class="mb-6">
    {{ html()->label(__('status.name'), 'name')->class('block text-gray-700 font-bold mb-2') }}
    {{ html()->input('text', 'name')
        ->class('w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 ' . ($errors->has('name') ? 'border-red-500' : ''))
        ->attribute('autofocus') }}
    @error('name')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
