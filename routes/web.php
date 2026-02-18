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
    
    // Live Monitoring API
    Route::get('/api/online-users', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getOnlineUsers'])->name('api.online-users');
});



Route::middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    Route::post('/users/{user}/suspend', [SuperAdminController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [SuperAdminController::class, 'unsuspend'])->name('users.unsuspend');
});

Route::middleware(['auth', 'verified', 'role:validator'])
    ->prefix('validator')
    ->name('validator.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Validator\DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/submissions', [App\Http\Controllers\Validator\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [App\Http\Controllers\Validator\SubmissionController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/claim', [App\Http\Controllers\Validator\SubmissionController::class, 'claim'])->name('submissions.claim');
        Route::post('/submissions/{submission}/unclaim', [App\Http\Controllers\Validator\SubmissionController::class, 'unclaim'])->name('submissions.unclaim');
        Route::post('/submissions/{submission}/review', [App\Http\Controllers\Validator\SubmissionController::class, 'review'])->name('submissions.review');
        Route::post('/submissions/{submission}/field-verification', [App\Http\Controllers\Validator\SubmissionController::class, 'storeFieldVerification'])->name('submissions.field-verification');
    });

// Pengusul Routes
Route::middleware(['auth', 'verified', 'role:pengusul'])
    ->prefix('pengusul')
    ->name('pengusul.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Users\Pengusul\DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('submissions', App\Http\Controllers\Users\Pengusul\SubmissionController::class);
        Route::post('/submissions/{submission}/submit', [App\Http\Controllers\Users\Pengusul\SubmissionController::class, 'submit'])->name('submissions.submit');
        Route::delete('/submissions/{submission}/files/{file}', [App\Http\Controllers\Users\Pengusul\SubmissionController::class, 'destroyFile'])->name('submissions.files.destroy');
    });



Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('super-admin')) {
        return redirect()->route('super-admin.dashboard');
    } elseif ($user->hasRole('validator')) {
        return redirect()->route('validator.dashboard');
    } elseif ($user->hasRole('pengusul')) {
        return redirect()->route('pengusul.dashboard');
    }
    return view('dashboard'); // Fallback if no role
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
