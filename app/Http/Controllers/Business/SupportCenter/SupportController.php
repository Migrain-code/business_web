<?php

namespace App\Http\Controllers\Business\SupportCenter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceAddRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Service\PersonelListResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Http\Resources\Service\ServiceSubCategoryResource;
use App\Models\BusinessService;
use App\Models\BusinnessType;
use App\Models\Personel;
use App\Models\ServiceCategory;
use App\Models\SupportRequest;
use App\Models\SupportResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

/**
 * @group Services
 *
 */
class SupportController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
            return $next($request);
        });
    }

    /**
     * Hizmet Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return view('business.support-center.index');
    }

    /**
     * Destek Ekle
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $supportCenter = new SupportRequest();
        $supportCenter->user_id = $this->user->id;
        $supportCenter->why_is_it = $request->why_is_it;
        $supportCenter->due_date = Carbon::parse($request->due_date);
        $supportCenter->notifications = $request->notifications;
        $supportCenter->order_number = $request->order_number;
        //$supportCenter->description = $request->description;
        if ($supportCenter->save()){
            $supportResponse = new SupportResponse();
            $supportResponse->support_request_id = $supportCenter->id;
            $supportResponse->question = $request->description;
            $supportResponse->status = 0;
            $supportResponse->save();
            return response()->json([
                'status' => "success",
                'message' => "Destek talebiniz başarılı bir şekilde oluşturuldu",
            ]);
        }

    }

    /**
     * Yeni soru
     *
     * @param SupportRequest $supportCenter
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(SupportRequest $supportCenter, Request $request)
    {
        $supportResponse = new SupportResponse();
        $supportResponse->support_request_id = $supportCenter->id;
        $supportResponse->question = $request->description;
        $supportResponse->status = 0;
        $supportResponse->save();

        return response()->json([
            'status' => "success",
            'message' => "Sorunuz Gönderildi",
        ]);
    }

    /**
     * Soru Detayı
     *
     *  Bu apide ilgili hizmeti hangi personeller veriyor bunun listesi görüntülenecek
     * @param SupportRequest $supportCenter
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SupportRequest $supportCenter)
    {
        return view('business.support-center.show.index', compact('supportCenter'));
    }

    /**
     * Hizmet Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BusinessService $service)
    {


    }

    /**
     * Hizmet Sil
     *
     * @param BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessService $service)
    {
        $service->is_delete = 1;
        if ($service->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Silindi",
            ]);
        }
    }

    public function datatable(Request $request)
    {
        $sales = $this->user->supportRequests()
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
                    $q->where('is_closed', 0);
                } elseif ($request->stockType == "midStock"){
                    $q->where('is_closed', 1);
                }
                elseif ($request->stockType == "inStock"){
                    $q->where('is_closed', 2);
                }

            })
            ->get();
        return DataTables::of($sales)
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->editColumn('order_number', function ($q) {
                return $q->important("name");
            })
            ->editColumn('why_is_it', function ($q) {
                //destek sebebi
                return $q->why("name");
            })
            ->editColumn('due_date', function ($q) {
                //işlem tarihi
                return $q->due_date->format('d.m.Y');
            })
            ->editColumn('is_closed', function ($q){
                return $q->status("html");
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_show_button(route('business.support-center.show', $q->id));
                $html .= create_delete_button('SupportRequest', $q->id, 'Destek Talebi', 'Destek Talebilini Silmek İstediğinize Eminmisiniz?');

                return $html;
            })
            ->rawColumns(['id', 'action', 'is_closed'])
            ->make(true);
    }
}
