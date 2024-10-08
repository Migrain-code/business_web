<?php

namespace App\Http\Controllers\Business\Form;

use App\Http\Controllers\Controller;
use App\Models\BusinessAppointmentRequest;
use App\Services\Sms;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BusinessAppointmentRequestController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware('permission:appointmentRequest.list')->only('index');
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
        return view('business.appointment-request.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessAppointmentRequest $appointmentRequest)
    {
        //return view('business.appointment-request.show.show', compact('appointmentRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessAppointmentRequest $appointmentRequest)
    {
        return view('business.appointment-request.detail.show', compact('appointmentRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessAppointmentRequest $appointmentRequest)
    {
        $appointmentRequest->user_name = $request->input('name');
        $appointmentRequest->call_date = $request->call_date;
        $appointmentRequest->status = $request->input('status');

        if ($appointmentRequest->save()) {
            if ($appointmentRequest->contact_type == 2 && $appointmentRequest->status != 4) {
                $message = $appointmentRequest->business->name . " İşletmesi Talebinizi Yanıtladı: " . $request->input('answer');
                if (!isset($appointmentRequest->sms_content)){
                    Sms::send(clearPhone($appointmentRequest->phone), $message);
                    $appointmentRequest->status = 4; // sms ile cevaplandı
                    $appointmentRequest->sms_content = $request->input('answer'); // cevap
                }
            } else {
                if ($appointmentRequest->status == 4) {
                    return response()->json([
                        'status' => "warning",
                        'message' => "Form Bilgileri Güncellendi, Fakat Cevabınızı daha önce ilettiğiniz için sms gönderilmedi"
                    ]);
                }
                //$appointmentRequest->status = $request->input('status');
            }
            return response()->json([
                'status' => "success",
                'message' => "Talep Bilgileri Güncellendi"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessAppointmentRequest $businessAppointmentRequest)
    {
        //
    }

    public function datatable(Request $request)
    {
        $officials = $this->business->requests;
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessAppointmentRequest', 'Seçtiğiniz borç ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('status', function ($q) {
                return $q->status("html");
                //return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessAppointmentRequest', 'status');
            })
            ->editColumn('phone', function ($q) {
                $phone = clearPhone($q->phone);
                if ($q->contact_type == 2) {
                    $phone = maskPhone($phone);
                    return $phone;
                } else {
                    return createPhone($phone, $phone);
                }
            })
            ->editColumn('created_at', function ($q) {
                if (isset($q->call_date)) {
                    return $q->call_date->format('d.m.Y H:i');
                }
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.appointment-request.edit', $q->id));
                if (authUser()->hasPermissionTo('appointmentRequest.delete')){
                    $html .= create_delete_button('BusinessAppointmentRequest', $q->id, 'Form', 'Form Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');
                }
                return $html;
            })
            ->rawColumns(['id', 'action', 'status', 'name'])
            ->make(true);
    }

}
