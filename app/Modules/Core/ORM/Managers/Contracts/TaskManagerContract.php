<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Managers\Contracts;

use App\Models\Task;
use App\Modules\Core\DTOs\TaskDTO;

interface TaskManagerContract
{
    /**
     * @param  TaskDTO  $taskDTO
     *
     * @return void
     */
    public function create(TaskDTO $taskDTO): void;

    /**
     * @param  Task  $task
     * @param  TaskDTO  $taskDTO
     *
     * @return void
     */
    public function update(Task $task, TaskDTO $taskDTO): void;

    /**
     * @param  Task  $task
     *
     * @return void
     */
    public function resolve(Task $task): void;

    /**
     * @param  Task  $task
     *
     * @return void
     */
    public function delete(Task $task): void;
}
