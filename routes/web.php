<?php

use Illuminate\Support\Facades\Route;

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
