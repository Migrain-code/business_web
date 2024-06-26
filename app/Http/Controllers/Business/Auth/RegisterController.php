<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Business;
use App\Models\BusinessNotificationPermission;
use App\Models\BusinessOfficial;
use App\Models\SmsConfirmation;
use App\Models\User;
use App\Services\Sms;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('business.auth.register');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data["phone"] = clearPhone($data["phone"]);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:business_officials'],
            'business_name' => ['required', 'string', 'max:255'],
            'terms_and_contitions' => ['accepted'],
            'privacy_terms' => ['accepted'],
            'clarification' => ['accepted'],
        ], [], [
            'name' => "Yetkili Adı",
            'phone' => "Telefon Numarası",
            'business_name' => "İşletme adı",
            'terms_and_contitions' => "Şartlar ve Koşullar",
            'privacy_terms' => "Gizlilik Koşulları",
            'clarification' => "Aydınlatma Metni",
        ]);
    }

    /**
     * Bilgileri al ve kayıt için Doğrulamaya gönder
     */
    public function register(RegisterRequest $request)
    {
        if ($this->existPhone(clearPhone($request->phone))) {
            return back()->with('response',[
                'status' => "warning",
                'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunmakta."
            ]);
        } else {
            Session::put('userInfo', $request->all());

            $this->createVerifyCode($request->phone);

            return to_route('business.showVerify')->with('response',[
                'status' => "success",
                'message' => "Telefon numaranıza bir doğrulama kodu gönderdik. Lütfen açılan kutuya 6 haneli doğrulama kodunuz giriniz",
            ]);
        }
    }




    /**
     * kayıtlı varmı kontrol et
     */
    public function existPhone($phone)
    {
        $existPhone = BusinessOfficial::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    /**
     * izinleri tanımla
     */
    function addPermission($id)
    {
        $businessPermission = new BusinessNotificationPermission();
        $businessPermission->business_id = $id;
        $businessPermission->save();
        return true;
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


}
