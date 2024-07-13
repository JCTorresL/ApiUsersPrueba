<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//*Controladores
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'getUsers']);
Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::post('/users', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'editUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);