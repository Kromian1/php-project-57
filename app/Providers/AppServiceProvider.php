<?php

namespace App\Providers;

use App\Models\{Label, Task, TaskStatus};
use App\Policies\{LabelPolicy, TaskStatusPolicy, TaskPolicy};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(TaskStatus::class, TaskStatusPolicy::class);
        Gate::policy(Label::class, LabelPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
    }
}
