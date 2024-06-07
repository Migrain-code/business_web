<?php

namespace App\Http\Middleware;

use App\Models\SendedSms;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckTwoFactorVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user->two_factor_verification){ // iki faktörlü doğrulama aktifse
            if ($user && $user->is_verify){
                return $next($request);
            } else{
                if (!request()->routeIs('business.twoFactorVerification.show')){
                    Session::put('phone', $user->phone);
                    $this->createVerifyCode($user->phone);
                    return to_route('business.twoFactorVerification.show');
                }
            }
        } else{
            return $next($request);
        }


    }

    function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "OFFICIAL-TWO-FACTOR";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send(clearPhone($phone), setting('business_title') . " Sistemine giriş için, doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }

}
