<?php

namespace App\Services;

use App\Mail\BasicMail;
use Illuminate\Support\Facades\Mail;

class SendMail
{
    public static function send($title, $message, $address, $code = null){
        $data = [
            'subject' => $title,
            'message' => $message,
            'code' => $code,
            'view' => 'basic',
        ];
        Mail::to($address)->send(new BasicMail($data));

        return true;
    }
}