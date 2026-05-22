<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

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
            : Response::deny('У вас недостаточно прав для создания статуса');
    }

    public function update(User $user, TaskStatus $taskStatus): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny('У вас недостаточно прав для изменения статуса');
    }

    public function delete(User $user, TaskStatus $taskStatus): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny('У вас недостаточно прав для удаления статуса');
    }
}
