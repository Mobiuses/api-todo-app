<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks;

use App\Modules\Api\Tasks\Contracts\TaskServiceContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TaskServiceContract::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/task.php');
    }
}
