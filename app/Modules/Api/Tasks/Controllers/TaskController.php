<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Modules\Api\Tasks\Contracts\TaskServiceContract;
use App\Modules\Api\Tasks\Exceptions\TaskBelongsToAnotherUserException;
use App\Modules\Api\Tasks\Filters\TaskFilter;
use App\Modules\Api\Tasks\Requests\TaskCreateUpdateRequest;
use App\Modules\Api\Tasks\Requests\TaskFilterRequest;
use App\Modules\Api\Tasks\Resources\TaskResource;
use App\Modules\Core\DTOs\TaskDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * @param  TaskServiceContract  $taskService
     */
    public function __construct(
        readonly private TaskServiceContract $taskService,
    ) {
    }

    /**
     * @param  TaskFilterRequest  $request
     * @param  TaskFilter  $filter
     *
     * @return AnonymousResourceCollection
     */
    public function list(TaskFilterRequest $request, TaskFilter $filter): AnonymousResourceCollection
    {
        return TaskResource::collection(
            $this->taskService->getList(Auth::id(), $filter)
        );
    }

    /**
     * @param  Task  $task
     * @param  TaskCreateUpdateRequest  $request
     *
     * @return JsonResponse
     */
    public function update(Task $task, TaskCreateUpdateRequest $request): JsonResponse
    {
        try {
            $this->taskService->update(
                $task,
                TaskDTO::createFromArray($request->validated())
            );
        } catch (TaskBelongsToAnotherUserException $e) {
            return $this->buildErrorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return response()->json(null, Response::HTTP_CREATED);
    }

    /**
     * @param  TaskCreateUpdateRequest  $request
     *
     * @return JsonResponse
     */
    public function create(TaskCreateUpdateRequest $request): JsonResponse
    {
        $this->taskService->create(
            TaskDTO::createFromArray($request->validated())
        );

        return response()->json(null, Response::HTTP_CREATED);
    }

    /**
     * @param  Task  $task
     *
     * @return JsonResponse
     */
    public function resolve(Task $task): JsonResponse
    {
        try {
            $this->taskService->resolve($task, Auth::id());
        } catch (TaskBelongsToAnotherUserException $e) {
            return $this->buildErrorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param  Task  $task
     *
     * @return JsonResponse
     */
    public function delete(Task $task): JsonResponse
    {
        try {
            $this->taskService->delete($task, Auth::id());
        } catch (TaskBelongsToAnotherUserException $e) {
            return $this->buildErrorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param  string  $message
     * @param  int  $code
     *
     * @return JsonResponse
     */
    private function buildErrorResponse(string $message, int $code): JsonResponse
    {
        return response()->json([
            'status'   => 'error',
            'messages' => $message,
        ], $code);
    }
}
