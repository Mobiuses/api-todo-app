<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Routes;

use App\Modules\Api\Tasks\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/tasks')->middleware(['api', 'auth:api'])->group(static function () {
    Route::get('/', [TaskController::class, 'list']);
    Route::post('/', [TaskController::class, 'create']);
    Route::put('/{task}', [TaskController::class, 'update']);
    Route::patch('/{task}', [TaskController::class, 'resolve']);
    Route::delete('/{task}', [TaskController::class, 'delete']);
});
