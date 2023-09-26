<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Exceptions;

use Exception;

class TaskBelongsToAnotherUserException extends Exception
{
    public function __construct(string $message = 'This task belongs to another user.')
    {
        parent::__construct($message);
    }
}
