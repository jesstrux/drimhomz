<?php

namespace App\Http\Controllers;



use App\Message;

class MessageController extends Controller
{


    public function save_message(){

        $message = new Message();
        $message->save_message(request()->all());
        return response()->json(['status'=>'Success']);
    }


}