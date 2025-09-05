<?php

use App\Http\Controllers\LoggerController;
use Illuminate\Support\Facades\Route;

Route::get('/logs', [LoggerController::class, 'getAllLogs'])->name('api.logs.all');
Route::get('/logs/{name}', [LoggerController::class, 'getLogsByName'])->name('api.logs.by-name');
Route::post('/logs', [LoggerController::class, 'createLog'])->name('api.logs.create');
