<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\TransactionNotification;
use Illuminate\Notifications\Notification;
use App\Models\TabelNotification;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{


    public function index()

      {
           // Ambil notifikasi sesuai dengan notifiable_id yang sesuai
    $notifications = auth()->user()->unreadNotifications;

    // Ubah format data notifikasi sesuai dengan yang diharapkan dalam view
    $formattedNotifications = $notifications->map(function ($notification) {
        return [
            'id' => $notification->id,
            'data' => is_array($notification->data) ? json_encode($notification->data) : $notification->data,
        ];
    });

    return view('notifications.index', compact('formattedNotifications'));
        }


        public function show($id)
        {
            $notification = DB::table('notifications')->where('id', $id)->first();

    if (!$notification) {
        abort(404); // Handle case where notification is not found
    }

    // Parse the notification data if it's in JSON format
    $notificationData = json_decode($notification->data);

    // Prepare the message based on notification type
    $message = $notificationData->type . ' of ' . $notificationData->data . ' was successful.';

    return view('notifications.show', compact('notification', 'message'));
        }

}
