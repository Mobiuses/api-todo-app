<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Tasks\Contracts\TaskServiceContract;
use App\Modules\Api\Tasks\Requests\TaskCreateRequest;
use App\Modules\Api\Tasks\Resources\TaskResource;
use App\Modules\Core\ORM\Repositories\Contracts\TaskRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function __construct(
        readonly private TaskRepositoryContract $taskRepository,
        readonly private TaskServiceContract $taskService,
    )
    {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        return TaskResource::collection(
            $this->taskRepository->getAllByUserId(Auth::id())
        );
    }

    /**
     * @param  TaskCreateRequest  $request
     *
     * @return JsonResponse
     */
    public function create(TaskCreateRequest $request): JsonResponse
    {
        $this->taskService->create($request);

        return response()->json(null, Response::HTTP_CREATED);

    }
    public function update()
    {

    }
    public function resolve()
    {

    }
    public function delete()
    {

    }
}
