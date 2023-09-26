<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Enums;

enum TaskStatusEnum:string
{
    case DONE = 'done';
    case TODO = 'todo';

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
