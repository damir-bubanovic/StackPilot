<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TaskController;

Route::prefix('v1')->group(function () {

    // Auth (public) - throttled
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/auth/register', [AuthController::class, 'register']);
        Route::post('/auth/login', [AuthController::class, 'login']);
    });

    // Authenticated
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

        Route::get('/projects/{project}/tasks', [TaskController::class, 'index']);
        Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
        Route::patch('/tasks/{task}', [TaskController::class, 'update']);
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    });
});
