<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Contracts;

use App\Models\Task;
use App\Modules\Api\Tasks\Exceptions\TaskBelongsToAnotherUserException;
use App\Modules\Api\Tasks\Filters\TaskFilter;
use App\Modules\Core\DTOs\TaskDTO;

interface TaskServiceContract
{
    /**
     * @return mixed
     */
    public function getList(int $userId, TaskFilter $filter);

    /**
     * @param  TaskDTO  $taskDTO
     *
     * @return mixed
     */
    public function create(TaskDTO $taskDTO);

    /**
     * @param  Task  $task
     * @param  TaskDTO  $taskDTO
     *
     * @return void
     * @throws TaskBelongsToAnotherUserException
     */
    public function update(Task $task, TaskDTO $taskDTO): void;

    /**
     * @param  Task  $task
     * @param  int  $userId
     *
     * @return void
     * @throws TaskBelongsToAnotherUserException
     */
    public function resolve(Task $task, int $userId): void;

    /**
     * @param  Task  $task
     * @param  int  $userId
     *
     * @return void
     * @throws TaskBelongsToAnotherUserException
     */
    public function delete(Task $task, int $userId): void;
}
