<?php

use App\Http\Controllers\Api\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[authController::class,'register'])->name('register');
Route::post('/login',[authController::class,'login'])->name('login');