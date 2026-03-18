<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);
        
        $view = 'dashboard';
        if ($user->hasRole('super-admin')) {
            $view = 'super-admin.notifications.index';
        } elseif ($user->hasRole('validator')) {
            $view = 'validator.notifications.index';
        } elseif ($user->hasRole('pengusul')) {
            $view = 'pengusul.notifications.index';
        } elseif ($user->hasRole('pengusul-desa')) {
            $view = 'pengusul-desa.notifications.index';
        }

        return view($view, compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark a notification as read and redirect to the appropriate resource.
     */
    public function readAndRedirect($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        
        $notification->markAsRead();

        $data = $notification->data;
        $url = $data['url'] ?? null;
        $submissionId = $data['submission_id'] ?? null;

        if ($submissionId) {
            $submission = \App\Models\CulturalSubmission::find($submissionId);
            
            // Intelligent role-based redirection
            if ($user->hasRole('super-admin')) {
                return redirect()->route('super-admin.cultural-submissions.show', $submissionId);
            } elseif ($user->hasRole('validator')) {
                // If validator owns the submission, send to their workspace, otherwise to review workspace
                if ($submission && $submission->user_id === $user->id) {
                    return redirect()->route('validator.cultural.show', $submissionId);
                }
                return redirect()->route('validator.submissions.show', $submissionId);
            } elseif ($user->hasRole('pengusul')) {
                return redirect()->route('pengusul.submissions.show', $submissionId);
            } elseif ($user->hasRole('pengusul-desa')) {
                return redirect()->route('pengusul-desa.submissions.show', $submissionId);
            }
        }

        // Fallback logic
        if ($user->hasRole('validator') && $url && str_contains($url, '/pengusul/')) {
             return redirect()->route('validator.submissions.index');
        }

        return redirect($url ?? route('dashboard'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai terbaca.');
    }
}
