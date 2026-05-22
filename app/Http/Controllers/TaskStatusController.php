<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::query()->paginate();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', TaskStatus::class);
        $status = new TaskStatus();

        return view('task_statuses.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:1|unique:task_statuses'
        ]);

        $status = new TaskStatus();
        $status->fill($data)->save();

        flash(__('Status successfully added'))->success()->important();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $status = TaskStatus::findOrFail($id);

        Gate::authorize('update', $status);

        return view('task_statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $status = TaskStatus::findOrFail($id);

        $data = $request->validate([
            'name' => "required|min:1|unique:task_statuses,name,{$status->id}"
        ]);

        $status->fill($data)->save();

        flash(__('Status successfully updated'))->success()->important();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = TaskStatus::findOrFail($id);
        Gate::authorize('delete', $status);

        $status->delete();

        flash(__('Status successfully deleted'))->success()->important();
        return redirect()->route('task_statuses.index');
    }
}
