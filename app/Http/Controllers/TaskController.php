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

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
    public function index(Request $request)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $creators = User::query()
            ->whereIn('id', Task::query()->select('created_by_id'))
            ->pluck('name', 'id');

        $assigners = User::query()
            ->whereIn('id', Task::query()->select('assigned_to_id'))
            ->pluck('name', 'id');

        $filteredTasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            )
            ->with(['status', 'creator', 'assignee'])
            ->paginate();

        return view('tasks.index', compact('filteredTasks', 'statuses', 'creators', 'assigners'));
    }

    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact('task', 'statuses', 'labels', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:1|max:100',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

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

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|min:1|max:100',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

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
