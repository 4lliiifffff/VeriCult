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
        }

        return view($view, compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
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
