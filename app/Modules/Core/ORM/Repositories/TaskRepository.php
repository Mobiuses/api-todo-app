<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories;

use App\Models\Task;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryContract
{

    /**
     * @param  int  $userId
     *
     * @return Collection
     */
    public function getAllByUserId(int $userId): Collection
    {
        return Task::query()->where('user_id', $userId)->get();
    }
}
