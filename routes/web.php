<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/{any}' , [AppController::class, 'index'])->where('any', '.*');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::post('/add-doctors', [AdminController::class, 'docStore']); // To add a doctor
Route::post('/doctors', [AdminController::class, 'docIndex']); // To list all doctors
Route::delete('/doctors/{id}', [AdminController::class, 'docDestroy']);
Route::get('/doctors/{id}/edit', [AdminController::class, 'editDoctor']); // Fetch the doctor data
Route::put('/doctors/{id}', [AdminController::class, 'updateDoctor']); // Update doctor data

Route::post('/add-departments', [AdminController::class, 'Depstore']); // Add a new department
Route::post('/departments', [AdminController::class, 'Depindex']); // Get all departments
Route::delete('/departments/{id}', [AdminController::class, 'Depdestroy']); // Delete a department