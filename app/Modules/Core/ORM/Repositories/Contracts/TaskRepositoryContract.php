<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Repositories\Contracts;

interface TaskRepositoryContract
{
    public function getAllByUserId(int $userId);
    public function getOneById();
}
