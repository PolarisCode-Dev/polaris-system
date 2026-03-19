<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;

//users
Route::Resource('users', UserController::class , ['except' => ['create', 'edit']]);
//tus rutas para la autenticación, login y logout.

//companies
Route::Resource('companies', CompanyController::class, ['except' => ['create', 'edit']]);