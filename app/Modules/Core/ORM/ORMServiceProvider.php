<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM;

use App\Modules\Core\ORM\Managers\Contracts\TaskManagerContract;
use App\Modules\Core\ORM\Managers\Contracts\UserManagerContract;
use App\Modules\Core\ORM\Managers\TaskManager;
use App\Modules\Core\ORM\Managers\UserManager;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use App\Modules\Core\ORM\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class ORMServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositories();
        $this->bindManagers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return void
     */
    private function bindRepositories(): void
    {
        $this->app->singleton(TaskRepositoryContract::class, TaskRepository::class);

    }

    /**
     * @return void
     */
    private function bindManagers(): void
    {
        $this->app->singleton(TaskManagerContract::class, TaskManager::class);
        $this->app->singleton(UserManagerContract::class, UserManager::class);
    }
}
