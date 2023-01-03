<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function generate($content, $user_id) {
        $notification = new Notification();

        $notification->content = $content;
        $notification->user_id = $user_id;
        $notification->save();

        return $notification;
    }

    public function delete($id) {
        $notification = Notification::find($id);
        $notification->delete();

        return $notification;
    }
}