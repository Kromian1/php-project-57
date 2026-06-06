<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    public function index()
    {
        $taskStatuses = TaskStatus::query()->paginate();

        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create()
    {
        $status = new TaskStatus();

        return view('task_statuses.create', compact('status'));
    }

    public function store(TaskStatusRequest $request)
    {
        $taskStatus = new TaskStatus();

        $validated = $request->validated();

        $taskStatus->fill($validated)->save();

        flash(__('flash.status.added'))->success()->important();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', [
            'status' => $taskStatus
        ]);
    }

    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $validated = $request->validated();

        $taskStatus->fill($validated)->save();

        flash(__('flash.status.updated'))->success()->important();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('flash.status.cannot_delete'))->error()->important();

            return redirect()->route('task_statuses.index');
        }

        $taskStatus->delete();

        flash(__('flash.status.deleted'))->success()->important();

        return redirect()->route('task_statuses.index');
    }
}
