<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories\Contracts;

use App\Modules\Api\Tasks\Filters\TaskFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepositoryContract
{
    /**
     * @param  int  $userId
     * @param  TaskFilter  $filter
     *
     * @return LengthAwarePaginator
     */
    public function getList(int $userId, TaskFilter $filter): LengthAwarePaginator;
}
