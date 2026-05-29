<div class="mt-4">
    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4 items-end">

        <div>
            {{ html()->label(__('Status'), 'filter[status_id]')->class('block text-gray-700 text-sm font-bold mb-2') }}
            {{ html()->select('filter[status_id]', $statuses, request('filter.status_id'))
                ->class('shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline')
                ->placeholder(__('All statuses')) }}
        </div>

        <div>
            {{ html()->label(__('Executor'), 'filter[assigned_to_id]')->class('block text-gray-700 text-sm font-bold mb-2') }}
            {{ html()->select('filter[assigned_to_id]', $users, request('filter.assigned_to_id'))
                ->class('shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline')
                ->placeholder(__('All users')) }}
        </div>

        <div>
            {{ html()->label(__('Labels'), 'filter[labels][]')->class('block text-gray-700 text-sm font-bold mb-2') }}
            {{ html()->multiselect('filter[labels][]', $labels, request('filter.labels', []))
                ->class('shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline')
                ->placeholder(__('All labels')) }}
        </div>

        <div>
            {{ html()->submit(__('Apply filter'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block') }}
        </div>
        <div>
            <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-block">
                {{ __('Cancel filter') }}
            </a>
        </div>
    </form>
</div>
