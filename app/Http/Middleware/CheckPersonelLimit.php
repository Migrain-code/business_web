<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckPersonelLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $business = $user->business;
        $personelCount = $business->personels->count();
        $permissionNames = [
            "personelCount.1",
        ];

        foreach ($permissionNames as $name) {
            if ($user->hasPermissionTo($name)) {
                $permissionPersonelCount = explode('.', $name)[1];
                if ($personelCount == $permissionPersonelCount || $personelCount > $permissionPersonelCount) {
                    Session::put('personelCount', $permissionPersonelCount);
                }
            } else{
                if (Session::has('personelCount')){
                    Session::forget('personelCount');
                }
            }
        }

        return $next($request);
    }
}
