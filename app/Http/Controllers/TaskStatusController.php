<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::query()->paginate();

        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        Gate::authorize('create', TaskStatus::class);
        $status = new TaskStatus();

        return view('task_statuses.create', compact('status'));
    }

    public function store(TaskStatusRequest $request)
    {
        Gate::authorize('create', TaskStatus::class);

        $data = $request->validate([
            'name' => 'required|min:1|unique:task_statuses',
        ]);

        $status = new TaskStatus();
        $status->fill($data)->save();

        flash(__('flash.status.added'))->success()->important();

        return redirect()->route('task_statuses.index');
    }

    public function edit(int $id)
    {
        $status = TaskStatus::findOrFail($id);

        Gate::authorize('update', $status);

        return view('task_statuses.edit', compact('status'));
    }

    public function update(TaskStatusRequest $request, int $id)
    {
        $status = TaskStatus::findOrFail($id);

        Gate::authorize('update', $status);

        $data = $request->validate([
            'name' => "required|min:1|unique:task_statuses,name,{$status->id}",
        ]);

        $status->fill($data)->save();

        flash(__('flash.status.updated'))->success()->important();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(int $id)
    {
        $status = TaskStatus::findOrFail($id);
        Gate::authorize('delete', $status);

        if ($status->tasks()->exists()) {
            flash(__('flash.status.cannot_delete'))->error()->important();

            return redirect()->route('task_statuses.index');
        }

        $status->delete();

        flash(__('flash.status.deleted'))->success()->important();

        return redirect()->route('task_statuses.index');
    }
}
