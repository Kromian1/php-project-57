<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to create task'));

    }

    public function update(User $user, Task $task): bool
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to update task'));

    }

    public function delete(User $user, Task $task): bool
    {
        //может удалять только автор задачи
    }
}
