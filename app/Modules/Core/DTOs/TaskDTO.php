<?php

declare(strict_types=1);

namespace App\Modules\Core\DTOs;

use App\Modules\Core\ORM\Enums\TaskPriorityEnum;
use App\Modules\Core\ORM\Enums\TaskStatusEnum;

class TaskDTO
{
    /**
     * @param  string  $title
     * @param  string  $description
     * @param  int|null  $priority
     * @param  string|null  $status
     */
    public function __construct(
        private string $title,
        private string $description,
        private ?int $priority = null,
        private ?string $status = null
    ) {
        if (!$this->priority) {
            $this->priority = TaskPriorityEnum::PRIORITY_1->value;
        }

        if (!$this->status) {
            $this->status = TaskStatusEnum::TODO->value;
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

}
