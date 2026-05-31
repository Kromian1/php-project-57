<?php

namespace App\Http\Controllers;

use App\Filters\TaskFilter;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(TaskFilter $request)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $creators = User::whereIn('id', Task::distinct()->pluck('created_by_id'))->pluck('name', 'id');
        $assigners = User::whereIn('id', Task::distinct()->pluck('assigned_to_id'))->pluck('name', 'id');

        $filteredTasks = Task::filter($request)->paginate();

        return view('tasks.index', compact('filteredTasks', 'statuses', 'creators', 'assigners'));
    }

    public function create()
    {
        Gate::authorize('create', Task::class);

        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('tasks.create', compact('task', 'statuses', 'labels', 'users'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Task::class);

        $data = $request->validate([
            'name' => 'required|min:1',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

        $task = new Task([
            'created_by_id' => auth()->id(),
        ]);
        $task->fill($data)->save();
        $task->labels()->sync($request->input('labels', []));

        flash(__('flash.task.added'))->success()->important();

        return redirect()->route('tasks.index');
    }

    public function show(int $id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    public function edit(int $id)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('update', $task);

        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        $taskLabels = $task->labels->pluck('id')->toArray();

        return view('tasks.edit', compact('task', 'statuses', 'labels', 'taskLabels', 'users'));
    }

    public function update(Request $request, int $id)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('update', $task);

        $data = $request->validate([
            'name' => 'required|min:1',
            'status_id' => 'required|integer|exists:task_statuses,id',
            'assigned_to_id' => 'integer|exists:users,id',
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id',
        ]);

        $task->fill($data)->save();
        $task->labels()->sync($request->input('labels', []));

        flash(__('flash.task.updated'))->success()->important();

        return redirect()->route('tasks.index');
    }

    public function destroy(int $id)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('delete', $task);

        $task->delete();

        flash(__('flash.task.deleted'))->success()->important();

        return redirect()->route('tasks.index');
    }
}
