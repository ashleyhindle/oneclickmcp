<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\McpController;

Route::get('/', [McpController::class, 'index'])->name('home');
Route::post('/generate', [McpController::class, 'generate'])->name('generate');
