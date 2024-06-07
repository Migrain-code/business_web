<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessNotificationPermission;
use App\Models\BusinessOfficial;
use App\Models\BusinessPromossion;
use App\Models\SendedSms;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TwoFactorVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function show()
    {
        return view('business.auth.two-factor.verification');
    }

    /**
     * Telefon numarasını doğrulayıp kayıt al
     */
    public function verify(Request $request)
    {
        $request->validate([
            'digit_code' => "required|array|size:6",
            'digit_code.*' => 'required|numeric'
        ], [], [
            'digit_code' => "Doğrulama Kodunu Giriniz",
            'digit_code.*' => 'Doğrulama kodu',
            'digit_code.*.numeric' => 'Doğrulama kodunun tüm rakamları sayı olmalıdır.',
        ]);
        $mergedCode = implode($request->digit_code);
        $code = SmsConfirmation::where("code", $mergedCode)->where('action', 'OFFICIAL-TWO-FACTOR')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);

                return back()->with('response',[
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {
                $user = BusinessOfficial::wherePhone($code->phone)->first();
                $user->is_verify = 1;
                $user->save();
                $code->delete();
                return to_route('business.home')->with('response', [
                    'status' => "success",
                    'message' => $user->name. " Tekrar Hoşgeldiniz",
                ]);
            }

        } else {
            return back()->with('response',[
                'status' => "error",
                'message' => "Doğrulama Kodu Hatalı."
            ]);
        }

    }

    /**
     * Telefon numarasını doğrulayıp kayıt al
     */
    public function resendCode()
    {
        $phone = clearPhone(session('phone'));
        $code = SmsConfirmation::where("phone", $phone)->where('action', 'OFFICIAL-TWO-FACTOR')->first();
        if ($code) {
            $sendedSms = SendedSms::wherePhone($phone)->latest()->first();

            if (isset($sendedSms) && now()->subMinutes(3) < $sendedSms->created_at){

                return back()->with('response', [
                    'status' => "warning",
                    'message' => "Yeni Sms Gönderimi İçin 3 Dakika Beklemeniz Gerekmektedir"
                ]);
            } else{
                $code->delete();

                $this->createVerifyCode($phone);
                return back()->with('response', [
                    'status' => "success",
                    'message' => "Doğrulama Kodu Tekrar Gönderildi"
                ]);
            }
        } else{
            auth('official')->logout();
            return to_route('business.login')->with('response', [
                'status' => "error",
                'message' => "Daha önce gönderilen kod bulunamadığı için sistemnden atıldınız"
            ]);
        }

    }

    /**
     * doğrulama kodu oluştur
     */
    function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "OFFICIAL-TWO-FACTOR";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send(clearPhone($phone), setting('business_title') . " Sistemine kayıt için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }
    /**
     * yeniden kodu oluştur
     */
    function resetVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "OFFICIAL-TWO-FACTOR";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('business_title') . " Şifre yenileme için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }
}
