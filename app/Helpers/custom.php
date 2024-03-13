<?php

function storage($path): string
{
    return asset('storage/' . $path);
}
function image($path)
{
    return env('IMAGE_URL').$path;
}
function setting($key){
    return config('settings.'.$key);
}

function authUser(){
    if (auth('official')->check()){
        return auth('official')->user();
    }
    /*else{

        return auth('admin')->user(); personel olacak
    }*/
}
function clearPhone($phoneNumber){
    $newPhoneNumber = str_replace([' ', '(', ')', '-'], '', $phoneNumber);
    $newPhoneNumber = substr($newPhoneNumber, 1);
    return $newPhoneNumber;

}

function sendNotification($title, $message, $link = null){
    $oneSignalService = new \App\Services\OneSignalNotification();
    $result = $oneSignalService->sendNotification('Test Başlık', 'Test Mesaj');

    return $result;
}
