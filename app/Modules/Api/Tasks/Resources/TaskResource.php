<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'priority' => $this->getPriority(),
            'status' => $this->getStatus(),
            'created_at' => $this->getCreatedAt(),
            'completed_at' => $this->getCompletedAt(),
            'sub_tasks' => $this->subTasks
        ];
    }
}
