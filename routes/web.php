<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/{any}' , [AppController::class, 'index'])->where('any', '.*');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/add-doctors', [AdminController::class, 'docStore']); // To add a doctor
Route::post('/doctors', [AdminController::class, 'docIndex']); // To list all doctors
Route::delete('/doctors/{id}', [AdminController::class, 'docDestroy']);