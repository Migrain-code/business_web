<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class CheckAppointmentLimit
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $business = $user->business;
        $appointmentCount = $business->appointments->count();
        $permissionNames = [
            "appointmentCount.100",
            "appointmentCount.200",
            "appointmentCount.300",
        ];

        foreach ($permissionNames as $name) {
            if ($user->hasPermissionTo($name)) {
                $permissionAppointmentCount = explode('.', $name)[1];
                if ($appointmentCount == $permissionAppointmentCount) {
                    abort(403);
                }
            }
        }

        return $next($request);
    }
}
