<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users/create-validator', [App\Http\Controllers\SuperAdmin\UserController::class, 'createValidator'])->name('users.create-validator');
    Route::post('/users/store-validator', [App\Http\Controllers\SuperAdmin\UserController::class, 'storeValidator'])->name('users.store-validator');
    
    Route::resource('users', App\Http\Controllers\SuperAdmin\UserController::class);
    Route::post('/users/{user}/suspend', [App\Http\Controllers\SuperAdmin\UserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [App\Http\Controllers\SuperAdmin\UserController::class, 'unsuspend'])->name('users.unsuspend');
    Route::post('/users/{user}/verify-email', [App\Http\Controllers\SuperAdmin\UserController::class, 'verifyEmail'])->name('users.verify-email');
    Route::post('/users/{user}/resend-verification-email', [App\Http\Controllers\SuperAdmin\UserController::class, 'resendVerificationEmail'])->name('users.resend-verification-email');
    
    // Audit Logs
    Route::get('/audit-logs', [App\Http\Controllers\SuperAdmin\AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/{auditLog}', [App\Http\Controllers\SuperAdmin\AuditLogController::class, 'show'])->name('audit-logs.show');

    // Notifications
    Route::post('/users/{user}/notify', [App\Http\Controllers\SuperAdmin\NotificationController::class, 'store'])->name('users.notify');
});

// Legacy routes (Redirect or keep for backward compatibility if needed, but we are switching dashboard)
// Route::get('/users/super-admin/dashboard', [SuperAdminController::class, 'index'])->name('super-admin_dashboard'); 
// commented out to force new route usage if we change route('super-admin_dashboard') calls.

// We need to support the old route name 'super-admin_dashboard' temporarily or update all references.
// Let's add a redirect or alias.
Route::get('/users/super-admin/dashboard', function() {
    return redirect()->route('super-admin.dashboard');
})->middleware(['auth', 'role:super-admin'])->name('super-admin_dashboard');


Route::middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    Route::post('/users/{user}/suspend', [SuperAdminController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [SuperAdminController::class, 'unsuspend'])->name('users.unsuspend');
});

Route::middleware(['auth', 'verified', 'role:validator'])
    ->get('/users/validator/dashboard', function () {
        return view('validator.dashboard');
    })->name('validator_dashboard');

Route::middleware(['auth', 'verified', 'role:pengusul'])
    ->get('/users/pengusul/dashboard', function () {
        return view('pengusul.dashboard');
    })->name('pengusul_dashboard');


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('super-admin')) {
        return redirect()->route('super-admin.dashboard');
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
