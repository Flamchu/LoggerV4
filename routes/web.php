<?php

use App\Http\Controllers\LoggerController;
use Illuminate\Support\Facades\Route;

// api routes
Route::prefix('api')->group(function () {
    Route::get('/logs', [LoggerController::class, 'getAllLogs'])->name('api.logs.all');
    Route::get('/logs/{name}', [LoggerController::class, 'getLogsByName'])->name('api.logs.by-name');
    Route::post('/logs', [LoggerController::class, 'createLog'])->name('api.logs.create');
});

// welcome message 
Route::get('/', function () {
    return response()->json([
        'message' => 'Academy Logger API',
        'endpoints' => [
            'GET /api/logs' => 'Get all logs',
            'GET /api/logs/{name}' => 'Get logs by name',
            'POST /api/logs' => 'Create new log (form-data: name)'
        ],
        'current_time' => now()->format(format: 'Y-m-d H:i:s'),
    ]);
});
