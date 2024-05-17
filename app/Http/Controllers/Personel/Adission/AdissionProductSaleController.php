<?php

namespace App\Http\Controllers\Personel\Adission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adission\ProductSaleAddRequest;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Appointment;
use App\Models\Product;
use App\Models\ProductSales;
use Yajra\DataTables\DataTables;

/**
 * @group Adisyonlar
 *
 */
class AdissionProductSaleController extends Controller
{
    private $business;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }
    /**
     * Adisyon Ürün Satışı Listesi
     *
     * @param  Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Appointment $adission)
    {
        $sales = $adission->sales;
        return DataTables::of($sales)
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('customerName', function ($q) {
                return createName(route('business.customer.edit', $q->customer_id), $q->customer->name);
            })
            ->addColumn('productName', function ($q) {
                return createName(route('business.customer.edit', $q->product_id), $q->product->name);
            })
            ->addColumn('personelName', function ($q) {
                return createName(route('business.customer.edit', $q->personel_id), $q->personel->name);
            })
            ->editColumn('total', function ($q) {
                return formatPrice($q->total);
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_delete_button('ProductSales', $q->id, 'Ürün Satışı', 'Ürün Satışı Kaydınız Silmek İstediğinize Eminmisiniz?', 'false','/isletme/sale/' . $q->id);

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

    /**
     * Adisyon Ürün Satışı Oluşturma
     *
     * Adisyonda ürün satışı yapılabilmesi için gerekli bilgileri döndürür
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $paymentTypes = ProductSales::PAYMENT_TYPES;

        return response()->json([
            'products' => ProductResource::collection($this->business->products),
            'personels' => PersonelListResource::collection($this->business->personels),
            'paymentTypes' => $paymentTypes,
        ]);
    }

    /**
     * Adisyona Ürün Satışı Ekleme
     *
     * @requires product_id
     * @requires personel_id
     * @requires payment_type_id
     * @requires amount
     * @requires price
     * @param  \Illuminate\Http\Request  $request
     * @param  Appointment $adission
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(ProductSaleAddRequest $request, Appointment $adission)
    {
        $productFind = Product::find($request->input('product_id'));
        $newAmount = $productFind->piece - $request->input('amount');
        if($newAmount < 0){
            return back()->with('response',[
                'status' => "error",
                'message' => "Satışını Yapmaya Çalıştığınız Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ]);
        }

        $productSale = new ProductSales();
        $productSale->appointment_id = $adission->id;
        $productSale->business_id = $this->business->id;
        $productSale->customer_id = $adission->customer_id;
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type_id');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        $productSale->note = $request->input('note');
        $productSale->created_at = $adission->start_time;
        if ($productSale->save()) {
            $productFind->piece = $productFind->piece - $productSale->piece;
            $productFind->save();
            return back()->with('response',[
                'status' => "success",
                'message' => "Ürün Satışı Yapıldı"
            ]);
        }
    }

    function sayiDuzenle($sayi){
        $sayi = str_replace('.','',$sayi);
        $sayi = str_replace(',','.',$sayi);
        $sonuc = floatval($sayi);
        return $sonuc;
    }
}
