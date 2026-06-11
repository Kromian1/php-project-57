<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    protected const int PAGINATION_COUNT = 15;

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request)
    {
        $filteredTasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            )
            ->with(['status', 'createdBy', 'assignee'])
            ->paginate($this::PAGINATION_COUNT);

        $statuses = TaskStatus::pluck('name', 'id');
        $creators = User::pluck('name', 'id');
        $assigners = User::pluck('name', 'id');

        $filters = [
            'status_id' => $request->input('filter.status_id'),
            'created_by_id' => $request->input('filter.created_by_id'),
            'assigned_to_id' => $request->input('filter.assigned_to_id'),
            'id' => $request->input('filter.id')
        ];

        return view('tasks.index', compact('filteredTasks', 'statuses', 'creators', 'assigners', 'filters'));
    }

    public function create()
    {
        $task = new Task();

        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact('task', 'statuses', 'labels', 'users'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        $task = Auth::user()->createdTasks()->create($validated);

        $task->labels()->sync($request->input('labels', []));

        flash(__('flash.task.added'))->success()->important();

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task
            ]);
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        $taskLabels = $task->labels->pluck('id')->toArray();

        return view('tasks.edit', [
            'task' => $task,
            'statuses' => $statuses,
            'users' => $users,
            'labels' => $labels,
            'taskLabels' => $taskLabels
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->fill($validated)->save();
        $task->labels()->sync($request->input('labels', []));

        flash(__('flash.task.updated'))->success()->important();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        flash(__('flash.task.deleted'))->success()->important();

        return redirect()->route('tasks.index');
    }
}
