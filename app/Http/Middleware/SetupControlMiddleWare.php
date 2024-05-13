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
                    return redirect()->route('business.setup.step1');
                }
            } else {

                /*if ($user->personels->count() > 0 && $user->services->count() > 0){
                    if ($request->routeIs('business.setup.*') || $request->routeIs('business.payment.*') || $request->routeIs('business.detailSetup.*')) {
                        // Kullanıcı setup sayfalarına veya ödeme sayfalarına erişmeye çalışıyorsa
                        return redirect()->route('business.home');
                    } else {
                        // Kullanıcı setup yapmışsa ve diğer sayfalara erişmeye çalışıyorsa
                        return $next($request);
                    }
                }
                else{
                    if ($request->routeIs('business.detailSetup.*') || $request->routeIs('business.gallery.*') || $request->routeIs('business.service.*') || $request->routeIs('business.personel.*')|| $request->routeIs('business.ajax.*')) {
                        // Kullanıcı setup sayfalarına veya ödeme sayfalarına erişmeye çalışıyorsa
                        return $next($request);

                    } else {
                        // Kullanıcı setup yapmışsa ve diğer sayfalara erişmeye çalışıyorsa
                        return redirect()->route('business.detailSetup.step2');
                    }
                }*/
                //return redirect()->route('business.home');
                return $next($request);
                // Kullanıcı setup yapmışsa

            }
        } else {
            // Kullanıcı giriş yapmamışsa
            return redirect()->route('business.login');
        }
    }
}
