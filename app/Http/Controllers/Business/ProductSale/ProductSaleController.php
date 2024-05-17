<?php

namespace App\Http\Controllers\Business\ProductSale;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSale\ProductSaleAddRequest;
use App\Http\Requests\ProductSale\ProductSaleUpdateRequest;
use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class ProductSaleController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(['permission:productSale.view']);
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('business.product-sale.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentMethods = ProductSales::PAYMENT_TYPES;
        $personels = $this->business->personels()->select('id', 'name')->get();
        $customers = $this->business->customers()->select('id', 'customer_id')->get();
        $products = $this->business->products()->where('piece', '>', 0)->get();

        return view('business.product-sale.create.index', compact('paymentMethods', 'personels', 'customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSaleAddRequest $request)
    {
        $productFind = Product::find($request->product_id);
        $newAmount = $productFind->piece - $request->amount;
        if ($newAmount < 0) {
            return response()->json([
                'status' => "error",
                'message' => "Satışını Yapmaya Çalıştığınız Bir Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ]);
        }
        $productFind = Product::find($request->product_id);
        $productSale = new ProductSales();
        $productSale->business_id = $this->business->id;
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->product_id;
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type');
        $productSale->piece = $request->amount;
        $productSale->total = $request->price;
        $productSale->note = $request->input('note');
        $productSale->created_at = Carbon::parse($request->input('seller_date'));
        $productSale->save();

        $productFind->piece = $productFind->piece - $productSale->piece;
        $productFind->save();
        return response()->json([
            'status' => "success",
            'message' => "Ürünün Satışı Başarılı Bir Şekilde Yapıldı"
        ]);
    }

    public function checkAmount($request)
    {
        $checkStock = [];

        $productFind = Product::find($request->product_id);
        $newAmount = $productFind->piece - $request->amount;
        if ($newAmount < 0) {
            $checkStock[] = false;
        } else {
            $checkStock[] = true;
        }


        return $checkStock;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSales $sale)
    {
        $paymentMethods = ProductSales::PAYMENT_TYPES;
        $personels = $this->business->personels()->select('id', 'name')->get();
        $customers = $this->business->customers()->select('id', 'customer_id')->get();
        $products = $this->business->products;
        return view('business.product-sale.edit.index', compact('sale', 'personels', 'customers', 'products', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductSaleUpdateRequest $request, ProductSales $sale)
    {
        $this->updateLatestProductPrice($sale);

        $productFind = Product::find($request->product_id);
        $newAmount = $productFind->piece - $request->amount;
        if ($newAmount < 0) {
            return response()->json([
                'status' => "error",
                'message' => "Satışını Yapmaya Çalıştığınız Bir Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ]);
        }

        $sale->customer_id = $request->input('customer_id');
        $sale->product_id = $request->product_id;
        $sale->personel_id = $request->input('personel_id');
        $sale->payment_type = $request->input('payment_type');
        $sale->piece = $request->amount;
        $sale->total = $request->price;
        $sale->note = $request->input('note');
        $sale->created_at = Carbon::parse($request->input('seller_date'));
        $sale->save();

        $productFind->piece = $productFind->piece - $sale->piece;
        $productFind->save();
        return response()->json([
            'status' => "success",
            'message' => "Ürünün Satışı Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    public function updateLatestProductPrice($sale)
    {
        $product = Product::find($sale->product_id);
        $product->piece += $sale->piece;
        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSales $sale)
    {
        $productFind = Product::find($sale->product_id);
        $productFind->piece = $productFind->piece + $sale->piece;
        $productFind->save();

        if ($sale->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Ürün Satışı Silindi. Satılan Ürün Adedi Ürün Stoğuna Geri Eklendi"
            ]);
        }
    }

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function datatable(Request $request)
    {
        $sales = $this->business->sales()
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
            })->get();
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
                $html .= create_edit_button(route('business.sale.edit', $q->id));
                $html .= create_delete_button('ProductSales', $q->id, 'Ürün Satışı', 'Ürün Satışı Kaydınız Silmek İstediğinize Eminmisiniz?', '/isletme/sale/' . $q->id);

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }


}
