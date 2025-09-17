<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\McpController;

Route::get('/', [McpController::class, 'index'])->name('home');
Route::post('/generate', [McpController::class, 'generate'])->name('generate');
Route::get('/{name}/{url}', [McpController::class, 'install'])->name('install')->where('url', '.*');
