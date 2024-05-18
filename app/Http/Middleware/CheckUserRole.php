<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = authUser();
        $business = $user->business;
        $package = $business->package_id;

        if (isset($package)){
            $role = Role::findById($package);
            $this->setUserPermission($role, $user);
        } else{
            $role = Role::findByName('packet_advanced_month');
            $this->setUserPermission($role, $user);
        }
        return $next($request);
    }

    public function setUserPermission($role, $user)
    {
        $permissions = $user->permissions;
        foreach ($permissions as $permission){
            $user->revokePermissionTo($permission->name);
        }
        $rolePermissions = $role->permissions;
        foreach ($rolePermissions as $permission){
            $user->givePermissionTo($permission->name);
        }

        // Kullanıcının tüm izinlerini al
        /*$currentPermissions = $user->permissions;
        // Role ait izinleri al
        $rolePermissions = $role->permissions;

        // Kullanıcının doğrudan atanmış izinlerini bul
        $directPermissions = $currentPermissions->filter(function($permission) use ($rolePermissions) {
            return !$rolePermissions->contains('name', $permission->name);
        });

        // Role ait izinlerin isimlerini al
        $rolePermissionNames = $rolePermissions->pluck('name')->toArray();

        // Kullanıcının sahip olduğu ama role ait olmayan izinleri bul (doğrudan atanmış izinler hariç)
        $permissionsToRevoke = $currentPermissions->filter(function($permission) use ($rolePermissionNames, $directPermissions) {
            return !in_array($permission->name, $rolePermissionNames) && !$directPermissions->contains('name', $permission->name);
        });

        // Bu izinleri kullanıcının üzerinden kaldır
        foreach ($permissionsToRevoke as $permission) {
            $user->revokePermissionTo($permission->name);
        }

        // Role ait izinleri kullanıcıya ver
        foreach ($rolePermissions as $permission) {
            if (!$user->hasPermissionTo($permission->name)) {
                $user->givePermissionTo($permission->name);
            }
        }*/
    }
}
