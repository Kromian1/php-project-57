<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class LabelPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Label $label): bool
    {
        return true;
    }

    public function create(User $user): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to create label'));
    }

    public function update(User $user, Label $label): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to update label'));
    }

    public function delete(User $user, Label $label): Response
    {
        return Auth::check()
            ? Response::allow()
            : Response::deny(__('You do not have permission to delete label'));
    }
}
