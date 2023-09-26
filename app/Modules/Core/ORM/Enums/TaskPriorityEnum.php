<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Enums;

enum TaskPriorityEnum:int
{
    case PRIORITY_1 = 1;
    case PRIORITY_2 = 2;
    case PRIORITY_3 = 3;
    case PRIORITY_4 = 4;
    case PRIORITY_5 = 5;


    /**
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
