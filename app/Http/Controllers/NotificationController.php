<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->notifications();

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('data->title', 'like', "%{$search}%")
                  ->orWhere('data->message', 'like', "%{$search}%");
            });
        }

        // Date Filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Status Filter
        if ($request->filled('filter')) {
            if ($request->filter === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->filter === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        $notifications = $query->latest()->paginate(20)->withQueryString();

        $view = 'dashboard';
        if ($user->hasRole('super-admin')) {
            $view = 'super-admin.notifications.index';
        } elseif ($user->hasRole('admin')) {
            $view = 'admin.notifications.index';
        } elseif ($user->hasRole('validator')) {
            $view = 'validator.notifications.index';
        } elseif ($user->hasRole('pengusul')) {
            $view = 'pengusul.notifications.index';
        } elseif ($user->hasRole('pengusul-desa')) {
            $view = 'pengusul-desa.notifications.index';
        }

        if ($request->ajax()) {
            return view('notifications._list', compact('notifications'))->render();
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
        $submissionId = $data['submission_id'] ?? null;
        $newUserId = $data['new_user_id'] ?? null;

        // Handle submission notifications
        if ($submissionId) {
            $submission = \App\Models\CulturalSubmission::find($submissionId);

            // Role-based redirection using submission_type
            if ($user->hasRole('super-admin')) {
                return redirect()->route('super-admin.cultural-submissions.show', $submissionId);
            } elseif ($user->hasRole('admin')) {
                // Route admin to appropriate submission view based on type
                if ($submission) {
                    if ($submission->submission_type === 'opk') {
                        return redirect()->route('admin.opk-submissions.show', $submissionId);
                    }
                    // For other types, let them view in super-admin or use default
                }
                return redirect()->route('admin.user-approvals.index');
            } elseif ($user->hasRole('validator')) {
                return redirect()->route('validator.submissions.show', $submissionId);
            } elseif ($user->hasRole('pengusul')) {
                return redirect()->route('pengusul.submissions.show', $submissionId);
            } elseif ($user->hasRole('pengusul-desa')) {
                return redirect()->route('pengusul-desa.submissions.show', $submissionId);
            }
        }

        // Handle user registration notifications (new pengusul-desa)
        if ($newUserId) {
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.user-approvals.index');
            } elseif ($user->hasRole('super-admin')) {
                return redirect()->route('super-admin.users.pengusul-desa');
            }
        }

        // Fallback
        return redirect()->route('dashboard');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai terbaca.');
    }

    /**
     * Delete all notifications.
     */
    public function deleteAll()
    {
        Auth::user()->notifications()->delete();

        return back()->with('success', 'Semua notifikasi telah dihapus.');
    }
}
