<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function clear_one_notification($id)
    {
        $notif = DB::table('notifications')
            ->where('notifications.id', $id)
            ->first();

        $user = User::find($notif->notifiable_id);
        $notification = $user->notifications()->where("id", $id)->first();
        if($notification->read())
            echo "Ishasomwa braza";
        else{
            echo "Ngoja niisome";
            $notification->update(['read_at' => Carbon::now()]);
        }

        return redirect('' . json_decode($notif -> data) -> link);

    }
}
