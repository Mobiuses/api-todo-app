<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks;

use App\Models\Task;
use App\Modules\Api\Tasks\Contracts\TaskServiceContract;
use App\Modules\Api\Tasks\Exceptions\TaskBelongsToAnotherUserException;
use App\Modules\Core\DTOs\TaskDTO;
use App\Modules\Core\ORM\Managers\Contracts\TaskManagerContract;
use Illuminate\Support\Facades\Auth;

class TaskService implements TaskServiceContract
{

    public function __construct(
        readonly private TaskManagerContract $taskManager
    )
    {
    }

    public function getAll()
    {
        // TODO: Implement getTasks() method.
    }

    public function create(TaskDTO $taskDTO): void
    {
        $this->taskManager->create($taskDTO);
    }

    /**
     * @param  Task  $task
     * @param  TaskDTO  $taskDTO
     *
     * @return void
     * @throws TaskBelongsToAnotherUserException
     */
    public function update(Task $task, TaskDTO $taskDTO): void
    {
        if (Auth::id() !== $task->getUserId()) {
            throw new TaskBelongsToAnotherUserException;
        }

        $this->taskManager->update($task, $taskDTO);
    }

    /**
     * @param  Task  $task
     * @param  int  $userId
     *
     * @return void
     * @throws TaskBelongsToAnotherUserException
     */
    public function resolve(Task $task, int $userId): void
    {
        if ($userId !== $task->getUserId()) {
            throw new TaskBelongsToAnotherUserException;
        }

        $this->taskManager->resolve($task);
    }

    /**
     * @param  Task  $task
     * @param  int  $userId
     *
     * @return void
     * @throws TaskBelongsToAnotherUserException
     */
    public function delete(Task $task, int $userId): void
    {
        if ($userId !== $task->getUserId()) {
            throw new TaskBelongsToAnotherUserException;
        }

        $this->taskManager->delete($task);
    }
}
