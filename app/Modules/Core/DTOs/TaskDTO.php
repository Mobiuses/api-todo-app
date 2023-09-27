<?php

declare(strict_types=1);

namespace App\Modules\Core\DTOs;

use App\Modules\Core\ORM\Enums\TaskPriorityEnum;
use App\Modules\Core\ORM\Enums\TaskStatusEnum;

final class TaskDTO
{
    /**
     * @param  string  $title
     * @param  string  $description
     * @param  int|null  $priority
     * @param  string|null  $status
     * @param  string|null  $parent_id
     */
    public function __construct(
        private string $title,
        private string $description,
        private ?int $priority = null,
        private ?string $status = null,
        private ?string $parent_id = null,
    ) {
        if ( ! $this->priority) {
            $this->priority = TaskPriorityEnum::PRIORITY_1->value;
        }

        if ( ! $this->status) {
            $this->status = TaskStatusEnum::TODO->value;
        }
    }

    /**
     * @param  array  $data
     *
     * @return static
     */
    static public function createFromArray(array $data): self
    {
        return new self(
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['priority'] ?? null,
            $data['status'] ?? null,
            $data['parent_id'] ?? null,
        );
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

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parent_id;
    }

}
