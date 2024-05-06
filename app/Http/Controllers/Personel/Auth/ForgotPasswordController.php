<?php

namespace App\Http\Controllers\Personel\Auth;

use App\Http\Controllers\Controller;
use App\Models\BusinessOfficial;
use App\Models\Personel;
use App\Models\SendedSms;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('personel.auth.passwords.email');
    }

    public function showResetPassword()
    {
        return view('personel.auth.passwords.confirm');
    }
    public function sendResetVerifyCode(Request $request)
    {
        $phone = clearPhone($request->phone);
        $existOfficial = Personel::wherePhone($phone)->first();
        if ($existOfficial){
            Session::put('phone', $existOfficial->phone);
            $this->createVerifyCode($phone);
            return to_route('personel.verify.showResetPassword')->with('response', [
                'status' => "success",
                'message' => "Telefon numaranıza gönderdiğimiz 6 Haneli doğrulama kodunu giriniz"
            ]);
        } else{
            return back()->with('response', [
               'status' => "error",
               'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunamadı"
            ]);
        }

    }
    /**
     * şifre yenilemeden önce telefon numarasını doğrula
     */

    function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = $phone;
        $smsConfirmation->action = "PERSONEL-PASSWORD-RESET";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('business_title') . " Şifre yenileme için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }

    /**
     * şifre yenilemeden önce telefon numarasını doğrula
     */
    public function verifyResetPassword(Request $request)
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

        $code = SmsConfirmation::where("code", $mergedCode)->where('action', 'PERSONEL-PASSWORD-RESET')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);

                return back()->with('response',[
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {
                $generatePassword = rand(100000, 999999);
                $official = Personel::where('phone', $code->phone)->first();
                $official->password = Hash::make($generatePassword);
                if ($official->save()) {

                    Sms::send($code->phone, setting('business_title') . " Sistemine giriş için yeni şifreniz " . $generatePassword);
                    $code->delete();
                    return to_route('personel.login')->with('response',[
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için yeni şifreniz telefonunuza sms olarak gönderildi."
                    ]);

                }
            }
        }
        return back()->with('response',[
            'status' => "warning",
            'message' => "Doğrulama Kodunu Hatalı Veya Yanlış Tuşladınız"
        ]);

    }

    public function verifyResetRepeatPassword()
    {
        $phone = clearPhone(session('phone'));
        $code = SmsConfirmation::where("phone", $phone)->where('action', 'PERSONEL-PASSWORD-RESET')->first();
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
        }

    }
}
