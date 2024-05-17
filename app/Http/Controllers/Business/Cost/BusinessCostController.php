<?php

namespace App\Http\Controllers\Business\Cost;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cost\CostAddRequest;
use App\Http\Resources\Cost\CostCategoryListResource;
use App\Http\Resources\Cost\CostListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Models\BusinessCost;
use App\Models\CostCategory;
use Yajra\DataTables\DataTables;

/**
 * @group Masraflar
 *
 */
class BusinessCostController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(['permission:cost.view']);
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }
    /**
     * Masraflar Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $this->business->costs
        $personels = $this->business->personels;
        $costCategories = CostCategory::all();
        $paymentTypes = BusinessCost::PAYMENT_TYPES;
        return view('business.cost.index', compact('costCategories', 'personels', 'paymentTypes'));
    }

    /**
     * Masraf Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CostAddRequest $request)
    {
        $businessCost = new BusinessCost();
        $this->extracted($businessCost, $request);

        if ($businessCost->save()){
            return response()->json([
               'status' => "success",
               'message' => "Masraf Başarılı Bir Şekilde Eklendi",
            ]);
        }
    }

    /**
     * Masraf Düzenleme
     *
     * @param  \App\Models\BusinessCost  $cost
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(BusinessCost $cost)
    {
        $personels = $this->business->personels;
        $costCategories = CostCategory::all();
        $paymentTypes = BusinessCost::PAYMENT_TYPES;
        return view('business.cost.detail.show', compact('costCategories', 'personels', 'paymentTypes', 'cost'));
    }

    /**
     * Masraf Güncelleme
     *
     * @param  CostAddRequest  $request
     * @param  BusinessCost  $cost
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CostAddRequest $request, BusinessCost $cost)
    {
        $this->extracted($cost, $request);

        if ($cost->save()){
            return response()->json([
                'status' => "success",
                'message' => "Masraf Başarılı Bir Şekilde Güncellendi",
            ]);
        }
    }

    /**
     * Masraf Silme
     *
     * @param  \App\Models\BusinessCost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessCost $cost)
    {
        if ($cost->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Masraf Başarılı Bir Şekilde Silindi",
            ]);
        }
    }

    /**
     * @param BusinessCost $cost
     * @param CostAddRequest $request
     * @return void
     */
    public function extracted(BusinessCost $cost, CostAddRequest $request): void
    {
        $cost->business_id = $this->business->id;
        $cost->cost_category_id = $request->costCategoryId;
        $cost->personel_id = $request->personelId;
        $cost->payment_type_id = $request->paymentTypeId;
        $cost->price = $request->price;
        $cost->operation_date = $request->operationDate;
        $cost->description = $request->description;
        $cost->note = $request->note;
    }

    public function datatable()
    {
        $officials = $this->business->costs;
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessCost', 'Seçtiğiniz masraf ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('cost_category_id', function ($q) {
                return $q->category->name;
            })
            ->editColumn('personel_id', function ($q) {
                return createName(route('business.personel.edit', $q->personel_id), $q->personel->name);
            })
            ->addColumn('payment_type_id', function ($q) {
                return $q->type("name");
            })
            ->editColumn('operation_date', function ($q) {
                return $q->operation_date->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.cost.edit', $q->id));
                $html .= create_delete_button('BusinessCost', $q->id, 'Masraf', 'Masraf Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
