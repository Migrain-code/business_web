<?php

namespace App\Http\Controllers\Business\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationListResource;
use App\Models\BusinessNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * @group Notifications
 *
 */
class NotificationController extends Controller
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
     * Bildirimler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return view('business.notification.index');
    }


    /**
     * Bildirim Detayı
     *
     * @param BusinessNotification $notification
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessNotification $notification)
    {
        $notification->status = 1;
        $notification->save();
        return view('business.notification.show', compact('notification'));
    }

    /**
     * Bildirim Sil
     *
     * @param BusinessNotification $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessNotification $notification)
    {
        if ($notification->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Silindi"
            ]);
        }
    }

    public function datatable(Request $request)
    {
        $sales =  $this->user->notifications()
            ->when($request->filled('listType'), function ($q) use ($request) {
                if ($request->listType == "thisWeek") {
                    $startOfWeek = now()->startOfWeek();
                    $endOfWeek = now()->endOfWeek();
                    $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                } elseif ($request->listType == "thisMonth") {
                    $startOfMonth = now()->startOfMonth();
                    $endOfMonth = now()->endOfMonth();
                    $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                } elseif ($request->listType == "thisYear") {
                    $startOfYear = now()->startOfYear();
                    $endOfYear = now()->endOfYear();
                    $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
                } elseif ($request->listType == "thisDay") {
                    $q->whereDate('created_at', now()->toDateString());
                }
            })
            ->when($request->filled('stockType'), function ($q) use ($request){
                if ($request->stockType == "outStock"){
                    $q->where('status', 0);
                } elseif ($request->stockType == "midStock"){
                    $q->where('status', 1);
                }
                else{
                    $q->whereIn('status', [0,1]);
                }
            })
            ->get();
        return DataTables::of($sales)
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('status', function ($q){
                if ($q->status == 0){
                    return html()->span()->class('badge badge-light-warning')->text("İletildi");
                } else{
                    return html()->span()->class('badge badge-light-primary')->text("Okundu");
                }
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_show_button(route('business.notifications.show', $q->id));
                $html .= create_delete_button('BusinessNotification', $q->id, 'Bildirim', 'Bildirimi Silmek İstediğinize Eminmisiniz?');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }
}
