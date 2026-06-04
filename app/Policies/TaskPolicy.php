<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to create task'));
    }

    public function update(): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to update task'));
    }

    public function delete(User $user, Task $task): Response
    {
        return $user->id === $task->created_by_id ?
            Response::allow() :
            Response::deny(__('You do not have permission to delete task'));
    }
}
