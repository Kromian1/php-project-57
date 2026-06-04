<?php

namespace App\Policies;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TaskStatusPolicy
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
            : Response::deny(__('You do not have permission to create status'));
    }

    public function update(): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to update status'));
    }

    public function delete(): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to delete status'));
    }
}
