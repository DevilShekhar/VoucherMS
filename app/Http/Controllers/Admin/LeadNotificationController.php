<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LeadNotificationController extends Controller
{
    public function latest()
    {
        $notifications = LeadNotification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function markRead($id)
    {
        LeadNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'is_read' => 1
            ]);

        return response()->json([
            'success' => true
        ]);
    }
}