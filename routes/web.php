<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    Route::get('/users/super-admin/dashboard', [SuperAdminController::class, 'index'])->name('super-admin_dashboard');
    Route::post('/users/{user}/suspend', [SuperAdminController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [SuperAdminController::class, 'unsuspend'])->name('users.unsuspend');
});

Route::middleware(['auth', 'verified', 'role:validator'])
    ->get('/users/validator/dashboard', function () {
        return view('users.validator.dashboard');
    })->name('validator_dashboard');

Route::middleware(['auth', 'verified', 'role:pengusul'])
    ->get('/users/pengusul/dashboard', function () {
        return view('users.pengusul.dashboard');
    })->name('pengusul_dashboard');


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('super-admin')) {
        return redirect()->route('super-admin_dashboard');
    } elseif ($user->hasRole('validator')) {
        return redirect()->route('validator_dashboard');
    } elseif ($user->hasRole('pengusul')) {
        return redirect()->route('pengusul_dashboard');
    }
    return view('dashboard'); // Fallback if no role
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
