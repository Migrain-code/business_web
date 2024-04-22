<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetupControlMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('official')->check()) {
            $authUser = auth('official')->user();
            $user = $authUser->business;
            if ($user->setup_status == 0) {
                // Kullanıcı setup yapılmamışsa
                if ($request->routeIs('business.setup.*') || $request->routeIs('business.payment.*') || $request->routeIs('business.ajax.*')) {
                    // Kullanıcı setup sayfalarına veya ödeme sayfalarına erişmeye çalışıyorsa
                    return $next($request);
                } else {
                    // Kullanıcı setup yapmamışsa ve diğer sayfalara erişmeye çalışıyorsa
                    /*if ($user->is_registired == 1){
                        return redirect()->route('business.setup.step4');

                    } else{
                    }*/
                    return redirect()->route('business.setup.step1');

                }
            } else {
                // Kullanıcı setup yapmışsa
                if ($request->routeIs('business.setup.*') || $request->routeIs('business.payment.*')) {
                    // Kullanıcı setup sayfalarına veya ödeme sayfalarına erişmeye çalışıyorsa
                    return redirect()->route('business.home');
                } else {
                    // Kullanıcı setup yapmışsa ve diğer sayfalara erişmeye çalışıyorsa
                    return $next($request);
                }
            }
        } else {
            // Kullanıcı giriş yapmamışsa
            return redirect()->route('business.login');
        }
    }
}
