<?php


use App\Message;
use App\Libraries\Karibusms;
use App\User;
use Illuminate\Support\Facades\Auth;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateVerificationCode($length = 4) {
    $characters = '0123456789ABCDEFGHJK';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    if (User::where('verification_code', '=', $randomString)->exists())
        generateVerificationCode($length);
    else
    return $randomString;
}


//Send Saved messages every minute
function sendMessages($messages){
    $karibuSMS = new Karibusms();

    //set a custom name to be used in sending SMS
    $karibuSMS->set_name("DREAMHOMZ");
    if (!$messages->isEmpty()) {
    foreach ($messages as $message) {
        $status = $karibuSMS->send_sms($message->phone, $message->body);
        Message::where('user_id', '=', $message->user_id)->where('status', '>=', '0')->where('type', '=', $message->type)->increment('status');
    }
    }
}