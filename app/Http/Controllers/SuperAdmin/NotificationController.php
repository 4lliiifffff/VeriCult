<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function store(Request $request, User $user)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::to($user)->send(new AdminNotification(
                $user, 
                $request->subject, 
                $request->message
            ));

            // Log action
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'sent_notification',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['subject' => $request->subject],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return back()->with('success', 'Notification sent successfully to ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
            return back()->with('error', 'Failed to send notification. Please check mail configuration.');
        }
    }
}
