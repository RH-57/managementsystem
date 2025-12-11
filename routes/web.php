<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ComponentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Component;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('manage.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboards', [DashboardController::class, 'index'])->name('dashboards.index');
    Route::resource('/users', UserController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/components', ComponentController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/leads', LeadController::class);
});
