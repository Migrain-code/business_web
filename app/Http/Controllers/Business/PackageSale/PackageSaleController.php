<?php

namespace App\Http\Controllers\Business\PackageSale;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageSale\PackageSaleAddRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\PackageSale\PackageSaleDetailResource;
use App\Http\Resources\PackageSale\PackageSaleListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Models\PackageSale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

/**
 * @group PackageSale
 *
 */
class PackageSaleController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }
    /**
     * Paket Satış Listesi
     *
     */
    public function index()
    {
        return view('business.package-sale.index');
    }

    /**
     * Paket Satış Oluşturma
     *
     * @param Request $request
     * @return Response
     */
    public function store(PackageSaleAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $packageSale = new PackageSale();
        $packageSale->business_id = $business->id;
        $packageSale->seller_date = $request->seller_date;
        $packageSale->customer_id = $request->input('customer_id');
        $packageSale->service_id = $request->input('service_id');
        $packageSale->type = $request->input('type_id');
        $packageSale->personel_id = $request->input('personel_id');
        $packageSale->amount = $request->input('amount');
        $packageSale->total = $request->price;
        if ($packageSale->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Paket Satışı Kayıt Edildi"
            ]);
        }
    }

    /**
     * Paket Satışı Düzenleme
     *
     * @param PackageSale $packageSale
     * @return Response
     */
    public function edit(PackageSale $packageSale)
    {
        return view('business.package-sale.edit.index', compact('packageSale'));
    }

    /**
     * Packet Satışı Güncelleme
     *
     * @param Request $request
     * @param PackageSale $packageSale
     * @return Response
     */
    public function update(PackageSaleAddRequest $request, PackageSale $packageSale)
    {
        $user = $request->user();
        $business = $user->business;

        $packageSale->business_id = $business->id;
        $packageSale->seller_date = $request->seller_date;
        $packageSale->customer_id = $request->input('customer_id');
        $packageSale->service_id = $request->input('service_id');
        $packageSale->type = $request->input('type_id');
        $packageSale->personel_id = $request->input('personel_id');
        $packageSale->amount = $request->input('amount');
        $packageSale->total = $request->price;
        if ($packageSale->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Satış Yapma İşlemi Güncellendi"
            ]);
        }
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function datatable(Request $request)
    {
        $sales = $this->business->packages()
            ->when($request->filled('listType'), function ($q) use ($request) {
                if ($request->listType == "thisWeek") {
                    $startOfWeek = now()->startOfWeek();
                    $endOfWeek = now()->endOfWeek();
                    $q->whereBetween('seller_date', [$startOfWeek, $endOfWeek]);
                } elseif ($request->listType == "thisMonth") {
                    $startOfMonth = now()->startOfMonth();
                    $endOfMonth = now()->endOfMonth();
                    $q->whereBetween('seller_date', [$startOfMonth, $endOfMonth]);
                } elseif ($request->listType == "thisYear") {
                    $startOfYear = now()->startOfYear();
                    $endOfYear = now()->endOfYear();
                    $q->whereBetween('seller_date', [$startOfYear, $endOfYear]);
                } elseif($request->listType == "thisDay") {
                    $q->whereDate('seller_date', now()->toDateString());
                }
            })->latest();
        return DataTables::of($sales)
            ->editColumn('created_at', function ($q) {
                return Carbon::parse($q->seller_date)->format('d.m.Y H:i');
            })
            ->editColumn('type', function ($q) {
                return $q->packageType('name');
            })
            ->addColumn('customerName', function ($q) {
                return createName(route('business.customer.edit', $q->customer_id), $q->customer?->name);
            })
            ->addColumn('serviceName', function ($q) {
                return createName(route('business.customer.edit', $q->service_id), $q->service->subCategory->name);
            })
            ->addColumn('personelName', function ($q) {
                return createName(route('business.customer.edit', $q->personel_id), $q->personel?->name);
            })
            ->editColumn('total', function ($q) {
                return formatPrice($q->total);
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.package-sale.edit', $q->id));
                $html .= create_delete_button('PackageSale', $q->id, 'Paket Satışı', 'Paket Satışı Kaydınız Silmek İstediğinize Eminmisiniz? Bu paketle ilgili tüm tahsilat ve kullanım kayıtları silinecektir');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
