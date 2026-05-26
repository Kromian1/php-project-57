<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::query()->paginate();
        return view('tasks.index', compact('tasks'));
    }

    public function create(Request $request)
    {
        Gate::authorize('create', Task::class);

        $task = new Task();

        return view('tasks.create', compact('task'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Task::class);

        $data = $request->validate([
            'name' => 'required|min:1',
            'status_id' => 'required|integer|exists:task_statuses,id',
            'assigned_to_id' => 'integer|exists:users,id'
        ]);

        $task = new Task();
        $task->fill($data)->save();

        flash(__('Task successfully created'))->success()->important();
        return redirect()->route('tasks.index');
    }

    public function show(int $id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task, int $id)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, int $id)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('update', $task);

        $data = $request->validate([
            'name' => 'required|min:1',
            'status_id' => 'required|integer|exists:task_statuses,id',
            'assigned_to_id' => 'integer|exists:users,id'
        ]);

        $task->fill($data)->save();

        flash(__('Task successfully updated'))->success()->important();
        return redirect()->route('tasks.index');
    }


    public function destroy(int $id)
    {
        $task = Task::findOrFail($id);

        Gate::authorize('delete', $task);

        $task->delete();

        flash(__('Task successfully deleted'))->success()->important();
        return redirect()->route('tasks.index');
    }
}
