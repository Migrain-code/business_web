<?php

namespace App\Http\Controllers\Business\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationPermission\PermissionUpdateRequest;
use App\Http\Resources\NotificationPermission\NotificationPermissionListResource;
use App\Models\BusinessNotificationPermission;
use App\Models\BusinessOfficial;

/**
 * @group NotificationPermission
 *
 */
class BusinessNotificationPermissionController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            $this->user = auth()->user();
            return $next($request);
        });
    }
    /**
     * Bildirim İzinleri
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $off = BusinessOfficial::all();
        foreach ($off as $item){
            $n = new BusinessNotificationPermission();
            $n->business_id = $item->id;
            $n->save();
        }
        $permissions = $this->user->permission;
        return view('business.notification-permission.index', compact('permissions'));
    }

    /**
     * Bildirim Güncelle
     *
     * Bildirim izinleri listesindeki response dönen verilerden is_email,is_sms,is_phone,is_notification örnek gönderim ({"column": "is_email"})
     *
     * @param  PermissionUpdateRequest  $request
     * @param  BusinessNotificationPermission $notificationPermission
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionUpdateRequest $request)
    {
        $notificationPermission = $this->user->permission;
        $notificationPermission->{$request->column} = !$notificationPermission->{$request->column};
        if ($notificationPermission->save()){
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Ayarlarınız Güncellendi",
            ]);
        }
    }

}
