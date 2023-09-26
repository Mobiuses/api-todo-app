<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Managers;

use App\Models\Task;
use App\Modules\Core\DTOs\TaskDTO;
use App\Modules\Core\ORM\Managers\Contracts\TaskManagerContract;
use Illuminate\Support\Facades\Auth;

class TaskManager implements TaskManagerContract
{
    /**
     * @param  TaskDTO  $taskDTO
     *
     * @return Task
     */
    public function create(TaskDTO $taskDTO): Task
    {
        $task = new Task();
        $task->setTitle($taskDTO->getTitle())
             ->setDescription($taskDTO->getDescription())
             ->setPriority($taskDTO->getPriority())
             ->setStatus($taskDTO->getStatus());

        Auth::user()->tasks()->save($task);

        return $task;
    }

    public function update()
    {
        // TODO: Implement updateTask() method.
    }

    public function resolve()
    {
        // TODO: Implement resolveTask() method.
    }

    public function delete()
    {
        // TODO: Implement deleteTask() method.
    }
}
