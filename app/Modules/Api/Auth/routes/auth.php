<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Routes;

use App\Modules\Api\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/auth')->group(static function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/get-user', [AuthController::class, 'getUser']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/refresh', [AuthController::class, 'refresh']);
    });
});
