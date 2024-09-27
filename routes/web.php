<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/{any}' , [AppController::class, 'index'])->where('any', '.*');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/doctors', [AdminController::class, 'Dstore']); // To add a doctor
Route::get('/doctors', [AdminController::class, 'index']); // To list all doctors
