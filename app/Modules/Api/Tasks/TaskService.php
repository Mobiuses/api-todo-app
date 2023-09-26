<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks;

use App\Modules\Api\Tasks\Contracts\TaskServiceContract;
use App\Modules\Api\Tasks\Requests\TaskCreateRequest;
use App\Modules\Core\DTOs\TaskDTO;
use App\Modules\Core\ORM\Managers\Contracts\TaskManagerContract;

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

    public function create(TaskCreateRequest $request): void
    {
        $this->taskManager->create(new TaskDTO(
            $request->get('title'),
            $request->get('description'),
            $request->get('priority'),
        ));
    }

    public function update()
    {
        // TODO: Implement UpdateTask() method.
    }

    public function resolve()
    {
        // TODO: Implement ResolveTask() method.
    }

    public function delete()
    {
        // TODO: Implement DeleteTask() method.
    }
}
