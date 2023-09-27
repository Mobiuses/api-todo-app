<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories;

use App\Modules\Api\Tasks\Filters\TaskFilter;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryContract
{

    /**
     * @param  int  $userId
     * @param  TaskFilter  $filter
     *
     * @return LengthAwarePaginator
     */
    public function getList(int $userId, TaskFilter $filter): LengthAwarePaginator
    {
        return $filter->getQuery()
                      ->where('user_id', $userId)
                      ->paginate(perPage: $filter->getPerPage(), page: $filter->getPage());
    }
}
