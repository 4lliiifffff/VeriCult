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
            ->with(['pengusulDesaProfile', 'pengusulDesaProfile.village'])
            ->whereHas('pengusulDesaProfile', fn($q) => $q->where('is_approved_by_admin', false))
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

        if ($user->is_approved_by_admin) {
            return back()->with('info', 'User ini sudah disetujui sebelumnya.');
        }

        try {
            // Approve via specialized profile
            $user->pengusulDesaProfile()->updateOrCreate(
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

    /**
     * Reject a pengusul-desa user
     */
    public function reject(Request $request, User $user)
    {
        if (!$user->hasRole('pengusul-desa')) {
            return back()->with('error', 'User ini bukan pengusul desa.');
        }

        if ($user->pengusulDesaProfile?->is_approved_by_admin) {
            return back()->with('info', 'User yang sudah disetujui tidak dapat ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            // Capture data before deletion for audit log and email
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            // Send rejection notification email BEFORE deleting
            Mail::to($userData['email'])->send(
                new \App\Mail\PenguslDesaRejectedNotification($user, $request->rejection_reason)
            );

            // Log rejection action before deletion
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'rejected_and_deleted_pengusul_desa',
                'model_type' => get_class($user),
                'model_id' => $userData['id'],
                'new_data' => [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'approval_status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                    'action_taken' => 'account_deleted',
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Delete the user (cascades to profile, which auto-deletes surat file)
            $user->delete();

            return back()->with('success', 'Pengusul desa ditolak dan akun telah dihapus. Email notifikasi telah dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak pengusul desa: ' . $e->getMessage());
        }
    }
}
