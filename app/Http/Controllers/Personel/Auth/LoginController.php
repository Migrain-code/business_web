<?php

namespace App\Http\Controllers\Personel\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Business\BusinessOfficialResource;
use App\Models\BusinessOfficial;
use App\Models\Personel;
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
    protected $redirectTo = '/home';

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
        return view('personel.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $phone = clearPhone($request->phone);
        $user = Personel::where('phone', $phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return to_route('personel.login')->with('response', [
                'status' => "error",
                'message' => "Telefon Numaranız Veya Şifreniz Hatalı",
            ]);
        }
        $remember = $request->has('remember');

        Auth::guard('personel')->loginUsingId($user->id, $remember);

        return to_route('personel.home')->with('response', [
            'status' => "success",
            'message' => $user->name. " Tekrar Hoşgeldiniz",
        ]);
    }
    public function username()
    {
        return 'phone';
    }

    public function logout()
    {
        \auth('personel')->logout();
        return to_route('loginTypes');
    }
}
