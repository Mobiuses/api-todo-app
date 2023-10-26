<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories\Contracts;

use App\Modules\Api\Tasks\Filters\TaskFilter;
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

    /**
     * @param  string  $query
     * @param  int  $page
     * @param  int  $perPage
     *
     * @return array
     */
    public function search(string $query, int $page, int $perPage): array;

    /**
     * @return array
     */
    public function getAllIdsFromElastic(): array;

}
