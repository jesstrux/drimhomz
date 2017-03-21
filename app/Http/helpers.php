<?php


use App\Message;
use App\Libraries\Karibusms;

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
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    if (Message::where('verification_code', '=', $randomString)->exists())
        generateVerificationCode($length);
    else
    return $randomString;
}


//Send Saved messages every minute
function sendMessages($messages){
    $karibuSMS = new Karibusms();

    //set a custom name to be used in sending SMS
    $karibuSMS->set_name("DREAMHOMZ");
    foreach ($messages as $message) {
        $status = $karibuSMS->send_sms($message->phone, $message->body);
        if ($status)
            Message::where('verification_code','=', $message->verification_code)->update(['status' => '1']);
        else
            return back();
    }
}