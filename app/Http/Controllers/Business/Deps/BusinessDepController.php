<?php

namespace App\Http\Controllers\Business\Deps;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessDep\DepListAddRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Dept\DeptResource;
use App\Models\BusinessDep;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * @group Borçlar
 *
 */
class BusinessDepController extends Controller
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
     * Borç Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // $this->business->depts
        $customers = $this->business->customers;
        return view('business.dep.index', compact('customers'));
    }

    /**
     * Borç Ekleme
     *
     * @param DepListAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepListAddRequest $request)
    {
        $businessDep = new BusinessDep();
        $this->extracted($businessDep, $request);
        return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Eklendi"
        ]);
    }

    /**
     * Borç Düzenleme
     *
     * @param \App\Models\BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(BusinessDep $dep)
    {
        $customers = $this->business->customers;
        return view('business.dep.detail.show', compact('customers', 'dep'));
    }

    /**
     * Borç Güncelleme
     *
     * @param DepListAddRequest $request
     * @param BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepListAddRequest $request, BusinessDep $dep)
    {
        $this->extracted($dep, $request);
        return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    /**
     * Borç Silme
     *
     * @param \App\Models\BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessDep $dep)
    {
        if ($dep->delete()) return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Silindi"
        ]);
    }

    public function extracted($businessDep, $request): void
    {
        $businessDep->business_id = $this->business->id;
        $businessDep->customer_id = $request->customerId;
        $businessDep->payment_date = $request->paymentDate;
        $businessDep->price = $request->price;
        $businessDep->note = $request->note;
        $businessDep->save();
    }

    public function datatable(Request $request)
    {
        $officials = $this->business->depts()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('payment_date', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('payment_date', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('payment_date', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('payment_date', now()->toDateString());
            }
        });
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessDep', 'Seçtiğiniz borç ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('customer_id', function ($q) {
                return createName(route('business.customer.edit', $q->customer->id), $q->customer->name);
            })
            ->editColumn('payment_date', function ($q) {
                return $q->payment_date->format('d.m.Y');
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('remainingDate', function ($q){
                return $q->payment_date < now() ? now()->diffInDays($q->payment_date) . " Gün Geçti" : ($q->status == 1 ? "Ödendi" : now()->diffInDays($q->payment_date) . " Gün Kaldı");
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.dep.edit', $q->id));
                $html .= create_delete_button('BusinessDep', $q->id, 'Borç', 'Borç Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }


}
