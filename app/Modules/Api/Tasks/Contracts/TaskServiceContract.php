<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Contracts;

use App\Modules\Api\Tasks\Requests\TaskCreateRequest;

interface TaskServiceContract
{
    public function getAll();
    public function create(TaskCreateRequest $request);
    public function update();
    public function resolve();
    public function delete();
}
