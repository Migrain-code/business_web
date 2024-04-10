<?php

namespace App\Http\Controllers\Business\Receivable;

use App\Http\Controllers\Controller;
use App\Http\Requests\Receivable\ReceivableListAddRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Receivable\ReceivableDetailResource;
use App\Http\Resources\Receivable\ReceivableListResource;
use App\Models\AppointmentReceivable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * @group Alacaklar
 *
 */
class AppointmentReceivableController extends Controller
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
     * Alacaklar Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->business->customers;
        return view('business.receivable.index', compact('customers'));
    }

    /**
     * Alacak Ekle
     *
     * @param  ReceivableListAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReceivableListAddRequest $request)
    {
        $appointmentReceivable = new AppointmentReceivable();
        $this->extracted($appointmentReceivable, $request);
        return response()->json([
            'status' => "success",
            'message' => "Alacak Başarılı Bir Şekilde Eklendi"
        ]);
    }

    /**
     * Alacak Düzenleme
     *
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(AppointmentReceivable $receivable)
    {
        $customers = $this->business->customers;

        return view('business.receivable.detail.show', compact('customers', 'receivable'));
    }

    /**
     * Alacak Güncelleme
     *
     * @param  ReceivableListAddRequest $request
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AppointmentReceivable $receivable)
    {
        $this->extracted($receivable, $request);
        return response()->json([
            'status' => "success",
            'message' => "Alacak Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    /**
     *  Alacak Silme
     *
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AppointmentReceivable $receivable)
    {
        if ($receivable->delete()) return response()->json([
            'status' => "success",
            'message' => "Alacak Başarılı Bir Şekilde Silindi"
        ]);
    }

    public function extracted($appointmentReceivable, $request):void
    {
        $appointmentReceivable->business_id = $this->business->id;
        $appointmentReceivable->customer_id = $request->customerId;
        $appointmentReceivable->payment_date = $request->paymentDate;
        $appointmentReceivable->price = $request->price;
        $appointmentReceivable->note = $request->note;
        $appointmentReceivable->save();
    }

    public function datatable()
    {
        $officials = $this->business->receivables;
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'AppointmentReceivable', 'Seçtiğiniz alacak ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
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
                $html .= create_edit_button(route('business.receivable.edit', $q->id));
                $html .= create_delete_button('AppointmentReceivable', $q->id, 'Alacak', 'Alacak Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }
}
