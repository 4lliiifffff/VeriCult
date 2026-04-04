<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PenguslDesaApprovedNotification;

class UserApprovalController extends Controller
{
    /**
     * Show pending pengusul-desa approvals
     */
    public function index()
    {
        $pendingUsers = User::role('pengusul-desa')
            ->with(['profile', 'profile.village'])
            ->whereHas('profile', fn($q) => $q->where('is_approved_by_admin', false))
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.user-approvals.index', compact('pendingUsers'));
    }

    /**
     * Approve a pengusul-desa user
     */
    public function approve(User $user)
    {
        if (!$user->hasRole('pengusul-desa')) {
            return back()->with('error', 'User ini bukan pengusul desa.');
        }

        if ($user->profile?->is_approved_by_admin) {
            return back()->with('info', 'User ini sudah disetujui sebelumnya.');
        }

        try {
            // Approve via profile
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['is_approved_by_admin' => true, 'approved_by_admin_at' => now()]
            );

            if (!$user->hasVerifiedEmail()) {
                $user->email_verified_at = now();
                $user->save();
            }

            // Log approval action
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'approved_pengusul_desa',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => [
                    'email' => $user->email,
                    'approval_status' => 'approved',
                    'approved_at' => now()
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Send approval notification email to user
            Mail::to($user->email)->send(new PenguslDesaApprovedNotification($user));

            return back()->with('success', 'Pengusul desa berhasil disetujui. Email konfirmasi telah dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui pengusul desa: ' . $e->getMessage());
        }
    }
}
