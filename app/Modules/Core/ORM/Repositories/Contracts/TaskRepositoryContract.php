<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryContract
{
    /**
     * @param  int  $userId
     *
     * @return mixed
     */
    public function getAllByUserId(int $userId): Collection;
}
