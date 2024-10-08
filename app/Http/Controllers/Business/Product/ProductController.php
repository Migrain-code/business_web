<?php

namespace App\Http\Controllers\Business\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductAddRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

/**
 * @group Product
 *
 */
class ProductController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(['permission:product.list'])->only('index');
        $this->middleware(['permission:product.edit'])->only('edit');
        //$this->middleware(['permission:product.update'])->only('update');

        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }
    /**
     * Ürün listesi
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $business = $this->business;
        return view('business.product.index', compact('business'));
    }

    /**
     * Ürün oluşturma
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(ProductAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $product = new Product();
        $product->business_id = $business->id;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->piece = $request->input('amount');
        $product->barcode = $request->input('barcode');
        if ($product->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Ürün Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Ürün bilgileri alma
     *
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        return view('business.product.edit.index', compact('product'));
    }

    /**
     * Ürün güncelleme
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->piece = $request->input('amount');
        $product->barcode = $request->input('barcode');
        if ($product->save()) {
            return to_route('business.product.index')->with('response',[
                'status' => "success",
                'message' => "Ürün Başarılı Bir Şekilde Güncellendi"
            ]);
        }
    }

    /**
     * Ürün silme
     *
     * @param Product $product
     * @return Response
     */
    /*public function destroy(Product $product)
    {
        if ($product->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Ürün Başarılı Bir Şekilde Silindi"
            ]);
        }
    }*/

    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function datatable(Request $request)
    {
        if ($this->business->lowStockProducts->count() > 0){
            $sales = $this->business->products()
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
                        $q->where('piece', 0);
                    } elseif ($request->stockType == "midStock"){
                        $q->whereBetween('piece', [1, $this->business->stock_count]);
                    }
                    elseif ($request->stockType == "inStock"){
                        $q->where('piece','>', $this->business->stock_count);
                    }
                    else{
                        $q->where('piece', '>=', 0);
                    }
                })->orderBy('piece', 'asc')
                ->get();
        } else{
            $sales = $this->business->products()
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
                        $q->where('piece', 0);
                    } elseif ($request->stockType == "midStock"){
                        $q->whereBetween('piece', [1, $this->business->stock_count]);
                    }
                    elseif ($request->stockType == "inStock"){
                        $q->where('piece','>', $this->business->stock_count);
                    }
                    else{
                        $q->where('piece', '>=', 0);
                    }
                })
                ->get();
        }

        return DataTables::of($sales)
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->editColumn('price', function ($q) {
                return formatPrice($q->price);
            })
            ->addColumn('total', function ($q) {
                return $q->sales->sum('piece');
            })
            ->addColumn('status', function ($q){
                if ($q->piece == 0){
                    return html()->span()->class('badge badge-light-danger')->text("Stok Tükendi");
                } elseif ($q->piece  > 0 && $q->piece <= $this->business->stock_count){
                    return html()->span()->class('badge badge-light-warning')->style('color: #967709')->text("Stoğu Azaldı");
                } else{
                    return html()->span()->class('badge badge-light-primary')->text("Stokta");
                }
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.product.edit', $q->id));
                if (authUser()->hasPermissionTo('product.delete')){
                    $html .= create_delete_button('Product', $q->id, 'Ürünü', 'Ürün Kaydını Silmek İstediğinize Eminmisiniz?');
                }

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }
}
