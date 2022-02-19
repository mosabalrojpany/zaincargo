<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = authClient()->user()->notifications()->paginate(25);

        if ($notifications->count()) {
            authClient()->user()->unReadNotifications()->update(['read_at' => now()]);
        }

        return view('Client.notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function markAllAsRead()
    {
        authClient()->user()->unReadNotifications()->update(['read_at' => now()]);
        return response()->json([], 200);
    }

}
