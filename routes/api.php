<?php

use App\Http\Controllers\Api\PingController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', [PingController::class, 'ping']);

// API для работы с задачами
Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});

// Расширенный ping с детектором окружения
Route::get('/ping-debug', function () {
    return response()->json([
        'message'        => 'pong',
        'octane'         => app()->bound('octane'),
        'sapi'           => php_sapi_name(),
        'octane_server'  => $_SERVER['OCTANE_SERVER'] ?? null,
        'octane_worker'  => $_SERVER['OCTANE_WORKER'] ?? null,
        // Просто для примера, можешь убрать или расширить
        'roadrunner_env' => getenv('RR_MODE') ?: 'not-rr',
    ]);
});
