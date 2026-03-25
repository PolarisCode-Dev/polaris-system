<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::Resource('users', UserController::class, ['except' => ['create']]);


Route::middleware('auth:api')->group(function () {
    //Rutas para autenticación
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    //users

    //companies
    Route::Resource('companies', CompanyController::class, ['except' => ['create', 'edit']]);
});
