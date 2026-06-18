<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->isPendingAdminApproval()) {
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    $stats = [
        'total' => \App\Models\CulturalSubmission::whereIn('status', [\App\Models\CulturalSubmission::STATUS_PUBLISHED, \App\Models\CulturalSubmission::STATUS_VERIFIED])->count(),
        \App\Models\CulturalSubmission::STATUS_PUBLISHED => \App\Models\CulturalSubmission::published()->count(),
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

// PWA Offline Fallback
Route::get('/offline', function () {
    return response()->file(public_path('offline.html'));
})->name('offline');

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

Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi');

// Public Cultural Profile Routes
Route::get('/profil-kebudayaan', [\App\Http\Controllers\PublicCulturalController::class, 'index'])->name('profil-kebudayaan.index');
Route::get('/profil-kebudayaan/{slug}', [\App\Http\Controllers\PublicCulturalController::class, 'show'])->name('profil-kebudayaan.show');

// Public Active Culture Feed
Route::get('/kebudayaan-aktif', [\App\Http\Controllers\PublicActiveCultureController::class, 'index'])->name('kebudayaan-aktif.index');
Route::get('/kebudayaan-aktif/{slug}', [\App\Http\Controllers\PublicActiveCultureController::class, 'show'])->name('kebudayaan-aktif.show');

// Public Reports
Route::get('/laporan-publik/print', [\App\Http\Controllers\PublicReportController::class, 'print'])->name('public.reports.print');

// Reports (Super Admin & Validator)
Route::middleware(['auth', 'role:super-admin|validator'])->group(function () {
    Route::get('/laporan-kebudayaan', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan-kebudayaan/print', [\App\Http\Controllers\ReportController::class, 'print'])->name('reports.print');
    Route::get('/laporan-kebudayaan/print-komprehensif', [\App\Http\Controllers\ReportController::class, 'printComprehensive'])->name('reports.print-comprehensive');
});

Route::middleware(['auth', 'verified', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users/create-admin', [App\Http\Controllers\SuperAdmin\UserController::class, 'createAdmin'])->name('users.create-admin');
    Route::post('/users/store-admin', [App\Http\Controllers\SuperAdmin\UserController::class, 'storeAdmin'])->name('users.store-admin');
    Route::get('/users/create-validator', [App\Http\Controllers\SuperAdmin\UserController::class, 'createValidator'])->name('users.create-validator');
    Route::post('/users/store-validator', [App\Http\Controllers\SuperAdmin\UserController::class, 'storeValidator'])->name('users.store-validator');

    // Pengusul Desa Approval
    Route::get('/users/pengusul-desa', [App\Http\Controllers\SuperAdmin\UserController::class, 'pendingPenguslDesaApprovals'])->name('users.pengusul-desa');
    Route::post('/pengusul-desa/{user}/approve', [App\Http\Controllers\SuperAdmin\UserController::class, 'approvePenguslDesa'])->name('pengusul-desa.approve');
    Route::post('/pengusul-desa/{user}/reject', [App\Http\Controllers\SuperAdmin\UserController::class, 'rejectPenguslDesa'])->name('pengusul-desa.reject');

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
    Route::get('/notifications/{id}/redirect', [\App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read-and-redirect');
    Route::post('/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/delete-all', [\App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('notifications.delete-all');

    // Wilayah Management
    Route::resource('kecamatans', \App\Http\Controllers\SuperAdmin\KecamatanController::class);
    Route::resource('villages', \App\Http\Controllers\SuperAdmin\VillageController::class);
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
        Route::get('/submissions/{submission}/edit', [App\Http\Controllers\Validator\SubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('/submissions/{submission}', [App\Http\Controllers\Validator\SubmissionController::class, 'update'])->name('submissions.update');
        Route::post('/submissions/{submission}/claim', [App\Http\Controllers\Validator\SubmissionController::class, 'claim'])->name('submissions.claim');
        Route::post('/submissions/{submission}/unclaim', [App\Http\Controllers\Validator\SubmissionController::class, 'unclaim'])->name('submissions.unclaim');
        Route::get('/submissions/{submission}/review', [App\Http\Controllers\Validator\SubmissionController::class, 'reviewForm'])->name('submissions.review-form');
        Route::post('/submissions/{submission}/review', [App\Http\Controllers\Validator\SubmissionController::class, 'review'])->name('submissions.review');
        Route::post('/submissions/{submission}/field-verification', [App\Http\Controllers\Validator\SubmissionController::class, 'storeFieldVerification'])->name('submissions.field-verification');
        Route::post('/submissions/{submission}/publish', [App\Http\Controllers\Validator\SubmissionController::class, 'publish'])->name('submissions.publish');
        Route::post('/submissions/{submission}/unpublish', [App\Http\Controllers\Validator\SubmissionController::class, 'unpublish'])->name('submissions.unpublish');

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}/redirect', [App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read-and-redirect');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/delete-all', [App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
    });

// Pengusul Routes (only pengusul)
Route::middleware(['auth', 'verified', 'role:pengusul'])
    ->prefix('pengusul')
    ->name('pengusul.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Pengusul\DashboardController::class, 'index'])->name('dashboard');

        // Submission routes requiring phone verification
        Route::middleware('require.phone')->group(function () {
            // Active Culture Report Submissions
            Route::get('/submissions/create/{category}', [App\Http\Controllers\Pengusul\SubmissionController::class, 'createForm'])->name('submissions.create-form');
            Route::resource('submissions', App\Http\Controllers\Pengusul\SubmissionController::class);
            Route::post('/submissions/{submission}/submit', [App\Http\Controllers\Pengusul\SubmissionController::class, 'submit'])->name('submissions.submit');
            Route::delete('/submissions/{submission}/files/{file}', [App\Http\Controllers\Pengusul\SubmissionController::class, 'destroyFile'])->name('submissions.files.destroy');

            // opk Submissions
            Route::get('/opk-submissions/create/{category}', [App\Http\Controllers\Pengusul\OPKSubmissionController::class, 'createForm'])->name('opk-submissions.create-form');
            Route::resource('opk-submissions', App\Http\Controllers\Pengusul\OPKSubmissionController::class)->parameters([
                'opk-submissions' => 'submission'
            ]);
            Route::post('/opk-submissions/{submission}/submit', [App\Http\Controllers\Pengusul\OPKSubmissionController::class, 'submit'])->name('opk-submissions.submit');
            Route::delete('/opk-submissions/{submission}/files/{file}', [App\Http\Controllers\Pengusul\OPKSubmissionController::class, 'destroyFile'])->name('opk-submissions.files.destroy');

            // Cagar Budaya Submissions
            Route::resource('cagar-budaya-submissions', App\Http\Controllers\Pengusul\CagarBudayaSubmissionController::class)->parameters([
                'cagar-budaya-submissions' => 'submission'
            ]);
            Route::post('/cagar-budaya-submissions/{submission}/submit', [App\Http\Controllers\Pengusul\CagarBudayaSubmissionController::class, 'submit'])->name('cagar-budaya-submissions.submit');
            Route::delete('/cagar-budaya-submissions/{submission}/files/{file}', [App\Http\Controllers\Pengusul\CagarBudayaSubmissionController::class, 'destroyFile'])->name('cagar-budaya-submissions.files.destroy');
        });

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}/redirect', [App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read-and-redirect');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/delete-all', [App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
    });

// Admin Routes (New Role)
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // User Approvals (Pengusul Desa)
        Route::get('/user-approvals', [App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('user-approvals.index');
        Route::post('/user-approvals/{user}/approve', [App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('user-approvals.approve');
        Route::post('/user-approvals/{user}/reject', [App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])->name('user-approvals.reject');

        // User Management (General)
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/suspend', [App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('users.suspend');
        Route::post('/users/{user}/unsuspend', [App\Http\Controllers\Admin\UserController::class, 'unsuspend'])->name('users.unsuspend');
        Route::post('/users/{user}/verify-email', [App\Http\Controllers\Admin\UserController::class, 'verifyEmail'])->name('users.verify-email');

        // OPK Submissions Publication
        Route::get('/opk-submissions', [App\Http\Controllers\Admin\OPKSubmissionController::class, 'index'])->name('opk-submissions.index');
        Route::get('/opk-submissions/{submission}', [App\Http\Controllers\Admin\OPKSubmissionController::class, 'show'])->name('opk-submissions.show');
        Route::post('/opk-submissions/{submission}/update-status', [App\Http\Controllers\Admin\OPKSubmissionController::class, 'updateStatus'])->name('opk-submissions.update-status');

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}/redirect', [App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read-and-redirect');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/delete-all', [App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('notifications.delete-all');

        // Wilayah Management
        Route::resource('kecamatans', \App\Http\Controllers\Admin\KecamatanController::class);
        Route::resource('villages', \App\Http\Controllers\Admin\VillageController::class);
    });

// Pengusul Desa Routes (only pengusul-desa)
Route::middleware(['auth', 'role:pengusul-desa', \App\Http\Middleware\CheckAdminApproval::class])
    ->prefix('pengusul-desa')
    ->name('pengusul-desa.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\PengusulDesa\DashboardController::class, 'index'])->name('dashboard');

        // Submission routes requiring phone verification
        Route::middleware('require.phone')->group(function () {
            // Active Culture Report Submissions
            Route::get('/submissions/create/{category}', [App\Http\Controllers\PengusulDesa\SubmissionController::class, 'createForm'])->name('submissions.create-form');
            Route::resource('submissions', App\Http\Controllers\PengusulDesa\SubmissionController::class);
            Route::post('/submissions/{submission}/submit', [App\Http\Controllers\PengusulDesa\SubmissionController::class, 'submit'])->name('submissions.submit');
            Route::delete('/submissions/{submission}/files/{file}', [App\Http\Controllers\PengusulDesa\SubmissionController::class, 'destroyFile'])->name('submissions.files.destroy');

            // opk Submissions
            Route::get('/opk-submissions/create/{category}', [App\Http\Controllers\PengusulDesa\OPKSubmissionController::class, 'createForm'])->name('opk-submissions.create-form');
            Route::resource('opk-submissions', App\Http\Controllers\PengusulDesa\OPKSubmissionController::class)->parameters([
                'opk-submissions' => 'submission'
            ]);
            Route::post('/opk-submissions/{submission}/submit', [App\Http\Controllers\PengusulDesa\OPKSubmissionController::class, 'submit'])->name('opk-submissions.submit');
            Route::delete('/opk-submissions/{submission}/files/{file}', [App\Http\Controllers\PengusulDesa\OPKSubmissionController::class, 'destroyFile'])->name('opk-submissions.files.destroy');

            // Cagar Budaya Submissions
            Route::resource('cagar-budaya-submissions', App\Http\Controllers\PengusulDesa\CagarBudayaSubmissionController::class)->parameters([
                'cagar-budaya-submissions' => 'submission'
            ]);
            Route::post('/cagar-budaya-submissions/{submission}/submit', [App\Http\Controllers\PengusulDesa\CagarBudayaSubmissionController::class, 'submit'])->name('cagar-budaya-submissions.submit');
            Route::delete('/cagar-budaya-submissions/{submission}/files/{file}', [App\Http\Controllers\PengusulDesa\CagarBudayaSubmissionController::class, 'destroyFile'])->name('cagar-budaya-submissions.files.destroy');

            // Potensi Kebudayaan Submissions
            Route::resource('potensi-submissions', App\Http\Controllers\PengusulDesa\PotensiSubmissionController::class)->parameters([
                'potensi-submissions' => 'submission'
            ]);
            Route::post('/potensi-submissions/{submission}/submit', [App\Http\Controllers\PengusulDesa\PotensiSubmissionController::class, 'submit'])->name('potensi-submissions.submit');
            Route::delete('/potensi-submissions/{submission}/files/{file}', [App\Http\Controllers\PengusulDesa\PotensiSubmissionController::class, 'destroyFile'])->name('potensi-submissions.files.destroy');
        });

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}/redirect', [App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read-and-redirect');
        Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/delete-all', [App\Http\Controllers\NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
    });



Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('super-admin')) {
        return redirect()->route('super-admin.dashboard');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('validator')) {
        return redirect()->route('validator.dashboard');
    } elseif ($user->hasRole('pengusul')) {
        return redirect()->route('pengusul.dashboard');
    } elseif ($user->hasRole('pengusul-desa')) {
        if ($user->isPendingAdminApproval()) {
            return redirect()->route('pending-approval');
        }
        return redirect()->route('pengusul-desa.dashboard');
    }
    return view('dashboard'); // Fallback if no role
})->middleware(['auth'])->name('dashboard');

// Pending Approval Route for unvalidated pengusul-desa
Route::get('/pending-approval', function () {
    if (!auth()->check() || !auth()->user()->isPendingAdminApproval()) {
        return redirect('/dashboard');
    }
    return view('auth.pending-approval');
})->name('pending-approval');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // OTP Verification Routes
    Route::post('/phone-verification/send', [\App\Http\Controllers\PhoneVerificationController::class, 'send'])->name('phone.verification.send');
    Route::post('/phone-verification/verify', [\App\Http\Controllers\PhoneVerificationController::class, 'verify'])->name('phone.verification.verify');
});

require __DIR__.'/auth.php';

// ── Email Preview Routes (Development Only) ──────────────────────────────────
if (config('app.debug')) {
    Route::prefix('_preview/email')->name('preview.email.')->group(function () {
        Route::get('/verify', function () {
            return (new \App\Notifications\VerifyEmailNotification())
                ->toMail(new class {
                    public $name  = 'Budi Santoso';
                    public $email = 'budi@example.com';
                })
                ->render();
        })->name('verify');

        Route::get('/verify-desa', function () {
            return (new \App\Notifications\PengusulDesaVerifyEmailNotification())
                ->toMail(new class {
                    public $name  = 'Siti Rahayu';
                    public $email = 'siti@example.com';
                })
                ->render();
        })->name('verify-desa');

        Route::get('/approved', function () {
            $user = new \App\Models\User([
                'name'  => 'Budi Santoso',
                'email' => 'budi@example.com',
            ]);
            return (new \App\Mail\PenguslDesaApprovedNotification($user))->render();
        })->name('approved');

        Route::get('/rejected', function () {
            $user = new \App\Models\User([
                'name'  => 'Budi Santoso',
                'email' => 'budi@example.com',
            ]);
            return (new \App\Mail\PenguslDesaRejectedNotification($user, 'Dokumen surat pengajuan tidak lengkap dan tidak memenuhi persyaratan yang ditetapkan.'))->render();
        })->name('rejected');

        Route::get('/otp', function () {
            return (new \App\Mail\PhoneVerificationMail('847291'))->render();
        })->name('otp');

        Route::get('/admin-notification', function () {
            $user = new \App\Models\User([
                'name'  => 'Admin VeriCult',
                'email' => 'admin@example.com',
            ]);
            return (new \App\Mail\AdminNotification(
                $user,
                'Pemberitahuan Sistem',
                'Mohon segera tinjau pengajuan budaya terbaru dari Desa Sukamaju yang memerlukan validasi Anda.'
            ))->render();
        })->name('admin-notification');
    });
}
