<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    
    public function index()
    {
        // Assuming you have a notifications relation in your User model
        $notifications = Auth::user()->notifications;

        return view('notifications.index', compact('notifications'));
    }
}
