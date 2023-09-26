<?php

declare(strict_types=1);

namespace App\Modules\Core\ORM\Managers;

use App\Models\Task;
use App\Models\User;
use App\Modules\Core\DTOs\TaskDTO;
use App\Modules\Core\ORM\Managers\Contracts\TaskManagerContract;
use App\Modules\Core\ORM\Managers\Contracts\UserManagerContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManager implements UserManagerContract
{

    /**
     * @param  string  $name
     * @param  string  $passwd
     *
     * @return User
     */
    public function create(string $name, string $passwd): User
    {
        return User::create([
            'name'     => $name,
            'password' => Hash::make($passwd),
        ]);
    }
}
