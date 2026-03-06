<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    $stats = [
        'total' => \App\Models\CulturalSubmission::whereIn('status', [\App\Models\CulturalSubmission::STATUS_PUBLISHED, \App\Models\CulturalSubmission::STATUS_VERIFIED])->count(),
        'published' => \App\Models\CulturalSubmission::published()->count(),
        'users' => \App\Models\User::role('pengusul')->count(),
        'pending' => \App\Models\CulturalSubmission::where('status', \App\Models\CulturalSubmission::STATUS_SUBMITTED)->count(),
        'revision' => \App\Models\CulturalSubmission::where('status', \App\Models\CulturalSubmission::STATUS_REVISION)->count(),
        'validators' => \App\Models\User::role('validator')->count(),
    ];

    $recentDiscoveries = \App\Models\CulturalSubmission::published()->with('files')->latest('published_at')->take(3)->get();
    
    // CMS Content
    $content = \Illuminate\Support\Facades\Cache::remember('site_content_beranda', 3600, function() {
        return \App\Models\SiteContent::getContentForPage('beranda');
    });

    return view('index', compact('stats', 'recentDiscoveries', 'content'));
})->name('beranda');

Route::get('/tentang', function () {
    $content = \Illuminate\Support\Facades\Cache::remember('site_content_tentang', 3600, function() {
        return \App\Models\SiteContent::getContentForPage('tentang');
    });
    return view('tentang', compact('content'));
})->name('tentang');

Route::get('/fitur', function () {
    $content = \Illuminate\Support\Facades\Cache::remember('site_content_fitur', 3600, function() {
        return \App\Models\SiteContent::getContentForPage('fitur');
    });
    return view('fitur', compact('content'));
})->name('fitur');

// Public Cultural Profile Routes
Route::get('/profil-kebudayaan', [\App\Http\Controllers\PublicCulturalController::class, 'index'])->name('profil-kebudayaan.index');
Route::get('/profil-kebudayaan/{slug}', [\App\Http\Controllers\PublicCulturalController::class, 'show'])->name('profil-kebudayaan.show');

// Reports (Super Admin & Validator)
Route::middleware(['auth', 'role:super-admin|validator'])->group(function () {
    Route::get('/laporan-kebudayaan', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan-kebudayaan/print', [\App\Http\Controllers\ReportController::class, 'print'])->name('reports.print');
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
    
    // Site Content Management
    Route::get('/site-content', [\App\Http\Controllers\SuperAdmin\SiteContentController::class, 'index'])->name('site-content.index');
    Route::get('/site-content/{page}/edit', [\App\Http\Controllers\SuperAdmin\SiteContentController::class, 'edit'])->name('site-content.edit');
    Route::put('/site-content/{page}', [\App\Http\Controllers\SuperAdmin\SiteContentController::class, 'update'])->name('site-content.update');

    // Cultural Submissions Management
    Route::resource('cultural-submissions', \App\Http\Controllers\SuperAdmin\CulturalSubmissionController::class)->parameters([
        'cultural-submissions' => 'submission'
    ]);

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
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
        Route::get('/submissions/{submission}/review', [App\Http\Controllers\Validator\SubmissionController::class, 'reviewForm'])->name('submissions.review-form');
        Route::post('/submissions/{submission}/review', [App\Http\Controllers\Validator\SubmissionController::class, 'review'])->name('submissions.review');
        Route::post('/submissions/{submission}/field-verification', [App\Http\Controllers\Validator\SubmissionController::class, 'storeFieldVerification'])->name('submissions.field-verification');
        Route::post('/submissions/{submission}/publish', [App\Http\Controllers\Validator\SubmissionController::class, 'publish'])->name('submissions.publish');

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    });

// Pengusul Routes
Route::middleware(['auth', 'verified', 'role:pengusul'])
    ->prefix('pengusul')
    ->name('pengusul.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Pengusul\DashboardController::class, 'index'])->name('dashboard');
        
        // Category-specific form route (must be before resource route)
        Route::get('/submissions/create/{category}', [App\Http\Controllers\Pengusul\SubmissionController::class, 'createForm'])->name('submissions.create-form');
        
        Route::resource('submissions', App\Http\Controllers\Pengusul\SubmissionController::class);
        Route::post('/submissions/{submission}/submit', [App\Http\Controllers\Pengusul\SubmissionController::class, 'submit'])->name('submissions.submit');
        Route::delete('/submissions/{submission}/files/{file}', [App\Http\Controllers\Pengusul\SubmissionController::class, 'destroyFile'])->name('submissions.files.destroy');

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
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
