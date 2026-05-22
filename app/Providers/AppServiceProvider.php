<?php

namespace App\Providers;

use App\Models\TaskStatus;
use App\Policies\TaskStatusPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
    }
}
