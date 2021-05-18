<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\UserCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/code', [CodeController::class, 'store']);
Route::post('/user/code', [UserCodeController::class, 'store']);
Route::get('/user/code/{code}/{phone}', [UserCodeController::class, 'checkWin']);