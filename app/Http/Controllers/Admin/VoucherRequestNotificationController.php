<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VoucherRequestNotification;
use Illuminate\Support\Facades\Auth;

class VoucherRequestNotificationController extends Controller
{
    public function latest()
    {
        return response()->json(
            VoucherRequestNotification::query()->where('user_id', Auth::id())
                ->where('is_read', false)
                ->latest()
                ->get()
        );
    }

    public function markRead($id)
    {
        VoucherRequestNotification::query()->where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
