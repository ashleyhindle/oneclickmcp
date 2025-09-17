<?php

use App\Http\Controllers\McpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [McpController::class, 'index'])->name('home');
Route::post('/generate', [McpController::class, 'generate'])->name('generate');
Route::get('/badge/{name}/{url}', [McpController::class, 'badge'])->name('badge')->where('url', '.*');
Route::get('/{name}/{url}', [McpController::class, 'install'])->name('install')->where('url', '.*');
