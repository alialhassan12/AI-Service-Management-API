<?php

use App\Http\Controllers\Api\authController;
use App\Http\Controllers\Api\plansController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//public routes
Route::post('/register', [authController::class, 'register'])->name('register');
Route::post('/login', [authController::class, 'login'])->name('login');


//client protected routes
Route::middleware('auth:sanctum','CheckRole:client')->group(function(){

});

//admin protected routes
Route::middleware('auth:sanctum','CheckRole:admin')->prefix('admin')->group(function(){
    Route::post('/create-plan',[plansController::class,'createPlan'])->name('create-plan');
    Route::get('/allPlans',[plansController::class,'getAllPlans'])->name('get-All-Plans');
    Route::put('/updatePlan/{id}',[plansController::class,'updatePlan'])->name('update-plan');
    Route::delete('/deletePlan/{id}',[plansController::class,'deletePlan'])->name('delete-plan');
    Route::put('/activatePlan/{id}',[plansController::class,'activatePLan'])->name('activate-plan');
    Route::put('/deactivatePlan/{id}',[plansController::class,'deactivatePLan'])->name('deactivate-plan');
});

//common admin and client protected routes
Route::middleware('auth:sanctum','CheckRole:admin,client')->group(function(){
    Route::post('/logout', [authController::class, 'logout'])->name('logout');
});