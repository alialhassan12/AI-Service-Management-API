<?php

use App\Http\Controllers\Api\aiRequestsController;
use App\Http\Controllers\Api\authController;
use App\Http\Controllers\Api\plansController;
use App\Http\Controllers\Api\servicesController;
use App\Http\Controllers\Api\subscriptionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//public routes
Route::post('/register', [authController::class, 'register'])
    ->name('register');
Route::post('/login', [authController::class, 'login'])
    ->name('login');


//client protected routes
Route::middleware('auth:sanctum','CheckRole:client')->group(function(){
    Route::post('/submit-subscription-request',[subscriptionsController::class,'submitSubscriptionRequest'])
        ->name('submit-subscription-request');
    Route::post('/ai-request',[aiRequestsController::class,'submitAiRequests'])
        ->name('submit-ai-request');
    Route::get('/ai-request/my-ai-requests',[aiRequestsController::class,'aiRequestHistory'])
        ->name('ai-request-history');
});

//admin protected routes
Route::middleware('auth:sanctum','CheckRole:admin')->prefix('admin')->group(function(){
    Route::post('/create-service',[servicesController::class,'createService'])
        ->name('create-service');
    Route::put('/service/update/{id}',[servicesController::class,'updateService'])
        ->name('update-service');
    Route::delete('/service/delete/{id}',[servicesController::class,'deleteService'])
        ->name('delete-service');
    Route::post('/create-plan',[plansController::class,'createPlan'])
        ->name('create-plan');
    Route::get('/allPlans',[plansController::class,'getAllPlans'])
        ->name('get-All-Plans');
    Route::put('/updatePlan/{id}',[plansController::class,'updatePlan'])
        ->name('update-plan');
    Route::delete('/deletePlan/{id}',[plansController::class,'deletePlan'])
        ->name('delete-plan');
    Route::put('/activatePlan/{id}',[plansController::class,'activatePLan'])
        ->name('activate-plan');
    Route::put('/deactivatePlan/{id}',[plansController::class,'deactivatePLan'])
        ->name('deactivate-plan');
    Route::get('/get-pendnig-requests',[subscriptionsController::class,'showPendingRequests'])
        ->name('get-pending-requests');
    Route::put('approve-subscription-requests/{id}',[subscriptionsController::class,'approveRequests'])
        ->name('approve-requests');
    Route::put('reject-subscription-requests/{id}',[subscriptionsController::class,'rejectRequests'])
        ->name('reject-requests');
    Route::get('/ai-requests',[aiRequestsController::class,'getAllAiRequests'])
        ->name('get-ai-requests');
});

//common admin and client protected routes
Route::middleware('auth:sanctum','CheckRole:admin,client')->group(function(){
    Route::post('/logout', [authController::class, 'logout'])
        ->name('logout');
    Route::get('/services',[servicesController::class,'getServices'])
        ->name('get all services with plans');
});