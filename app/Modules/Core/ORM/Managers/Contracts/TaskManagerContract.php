<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Managers\Contracts;

use App\Models\Task;
use App\Modules\Core\DTOs\TaskDTO;

interface TaskManagerContract
{
    public function create(TaskDTO $taskDTO): Task;
    public function update();
    public function resolve();
    public function delete();
}
