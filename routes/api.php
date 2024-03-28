<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeeRecordsController;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clients', [ClientController::class, 'index']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
Route::post('/clients/add', [ClientController::class, 'store']);
Route::get('/getClientReview/{id}', [ClientController::class, 'clientReview']);

Route::post('/membershipFee/clients/{id}', [FeeRecordsController::class, 'recordClientMembershipFee']);

Route::get('/admin/{id}', [UserController::class, 'show']);
Route::put('/admin/{id}', [UserController::class, 'update']);

Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);
