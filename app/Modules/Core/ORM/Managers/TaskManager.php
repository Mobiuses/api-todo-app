<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Managers;

use App\Models\Task;
use App\Modules\Core\DTOs\TaskDTO;
use App\Modules\Core\ORM\Enums\TaskStatusEnum;
use App\Modules\Core\ORM\Managers\Contracts\TaskManagerContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskManager implements TaskManagerContract
{
    /**
     * @param  TaskDTO  $taskDTO
     *
     * @return void
     */
    public function create(TaskDTO $taskDTO): void
    {
        $task = new Task();
        $task->setTitle($taskDTO->getTitle())
             ->setDescription($taskDTO->getDescription())
             ->setPriority($taskDTO->getPriority())
             ->setStatus($taskDTO->getStatus());

        Auth::user()->tasks()->save($task);
    }

    /**
     * @param  Task  $task
     * @param  TaskDTO  $taskDTO
     *
     * @return void
     */
    public function update(Task $task, TaskDTO $taskDTO): void
    {
        $task->setTitle($taskDTO->getTitle())
             ->setDescription($taskDTO->getDescription())
             ->setPriority($taskDTO->getPriority());

        if ($task->isDirty()) {
            $task->save();
        }
    }

    /**
     * @param  Task  $task
     *
     * @return void
     */
    public function resolve(Task $task): void
    {
        $task->setStatus(TaskStatusEnum::DONE->value);
        $task->setCompletedAt(Carbon::now()->toDateTimeString());

        $task->save();
    }

    /**
     * @param  Task  $task
     *
     * @return void
     */
    public function delete(Task $task): void
    {
        $task->delete();
    }
}
