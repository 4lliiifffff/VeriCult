<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:super-admin'])
    ->get('/users/super-admin/dashboard', [SuperAdminController::class, 'index'])
    ->name('super-admin_dashboard');

Route::middleware(['auth', 'verified', 'role:validator'])
    ->get('/users/validator/dashboard', function () {
        return view('users.validator.dashboard');
    })->name('validator_dashboard');

Route::middleware(['auth', 'verified', 'role:pengusul'])
    ->get('/users/pengusul/dashboard', function () {
        return view('users.pengusul.dashboard');
    })->name('pengusul_dashboard');


Route::get('/dashboard', function () {
    return view('users.pengusul.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
