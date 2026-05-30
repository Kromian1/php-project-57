<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TaskStatusPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }

    public function create(User $user): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to create status'));
    }

    public function update(User $user, TaskStatus $taskStatus): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to update status'));
    }

    public function delete(User $user, TaskStatus $taskStatus): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to delete status'));
    }
}
