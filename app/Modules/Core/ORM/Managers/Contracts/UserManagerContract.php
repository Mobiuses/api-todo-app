<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Managers\Contracts;

use App\Models\User;

interface UserManagerContract
{
    /**
     * @param  string  $name
     * @param  string  $passwd
     *
     * @return User
     */
    public function create(string $name, string $passwd): User;
}
