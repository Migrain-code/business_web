<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessNotificationPermission;
use App\Models\BusinessOfficial;
use App\Models\BusinessPromossion;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    public function __construct()
    {
        /* $this->middleware('auth');
         $this->middleware('signed')->only('verify');*/
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function show()
    {
        return view('business.auth.verify');
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
        $code = SmsConfirmation::where("code", $mergedCode)->where('action', 'OFFICIAL-REGISTER')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);

                return back()->with('response',[
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {
                $cashedUser = collect(Session::get('userInfo'));
                $permission = $cashedUser->get('is_permission') !== null; // izin vermiş demek

                //dd($code->);
                if ($code->phone == clearPhone($cashedUser->get('phone'))) {

                    $business = $this->createBusiness($cashedUser->get('business_name'));
                    $generatePassword = rand(100000, 999999);
                    $user = new BusinessOfficial();
                    $user->name = $cashedUser->get('name');
                    $user->phone = $code->phone;
                    $user->email = $cashedUser->get('email');
                    $user->password = Hash::make($generatePassword);
                    $user->business_id = $business->id;
                    $user->is_admin = 1;
                    $user->save();

                    $user->sendWelcomeMessage();
                    $this->setAdmin($business, $user);
                    $this->addPermission($user->id, $permission);
                    $this->addPromotion($business->id);
                    Sms::send($code->phone, setting('business_title') . " Sistemine kayıt işleminiz tamamlandı. Giriş yapmak için şifreniz ". $generatePassword . " olarak belirlendi");
                    $code->delete();
                    Auth::login($user);
                    return to_route('business.home')->with('response',[
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme otomatik giriş yapıldı. Kurulumu yaparak işletmenizi aramalarda gösterebilirsiniz."
                    ]);
                } else {
                    return back()->with('response',[
                        'status' => "error",
                        'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız."
                    ]);
                }
            }

        } else {
            return back()->with('response',[
                'status' => "error",
                'message' => "Doğrulama Kodu Hatalı."
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
        $smsConfirmation->action = "OFFICIAL-REGISTER";
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
        $smsConfirmation->action = "OFFICIAL-PASSWORD-RESET";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('business_title') . " Şifre yenileme için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }
    /**
     * işletmesini oluştur
     */
    function createBusiness($business_name)
    {
        $business = new Business();
        $business->name = $business_name;
        $business->slug = $this->checkSlug($business_name);
        $business->company_id = rand(1000000, 9999999);
        $business->package_id = 1;
        $business->save();

        return $business;
    }

    /**
     * admin yetkisi ver
     */
    function setAdmin($business, $user)
    {
        $business->admin_id = $user->id;
        $business->save();
    }

    /**
     * izinleri tanımla
     */
    function addPermission($id, $permission)
    {
        $businessPermission = new BusinessNotificationPermission();
        $businessPermission->business_id = $id;
        if (!$permission){
            $businessPermission->is_sms = 0;
            $businessPermission->is_email = 0;
            $businessPermission->is_phone = 0;
            $businessPermission->is_notification = 0;
        }
        $businessPermission->save();
        return true;
    }

    public function addPromotion($businessId) :void
    {
        $promossions = new BusinessPromossion();
        $promossions->business_id = $businessId;
        $promossions->cash = 0;
        $promossions->credit_cart = 0;
        $promossions->eft = 0;
        $promossions->use_limit = 10;
        $promossions->birthday_discount = 0;
        $promossions->save();
    }

    public function checkSlug($business_name)
    {
        $slug = Str::slug($business_name);
        $existBusinessSlug = Business::whereSlug($slug)->count();
        if ($existBusinessSlug > 0){
            $slug .= "-". $existBusinessSlug + 1;
        }

        return $slug;
    }
}
