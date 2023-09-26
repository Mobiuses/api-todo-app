<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Routes;

use App\Modules\Api\Tasks\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/tasks')->middleware(['api', 'auth:api'])->group(static function () {
    Route::get('/', [TaskController::class, 'list']);
    Route::post('/', [TaskController::class, 'create']);
    Route::put('/', [TaskController::class, 'update']);
    Route::patch('/', [TaskController::class, 'resolve']);
    Route::delete('/', [TaskController::class, 'delete']);
});
