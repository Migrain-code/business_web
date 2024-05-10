<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequestForm;
use App\Models\AppointmentRequestFormQuestion;
use App\Models\AppointmentRequestFormService;
use App\Models\BusinessService;
use App\Models\RequestQuestion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AppointmentRequestFormController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }

    public function index()
    {
        $businessServices = $this->business->services;
        return view('business.appointment-request-form.index', compact('businessServices'));
    }

    public function store(Request $request)
    {
        $requestForm = new AppointmentRequestForm();
        $requestForm->business_id = $this->business->id;
        $requestForm->name = $request->input('name');
        $requestForm->is_default = 0;
        if ($requestForm->save()){
            foreach ($request->service_id as $serviceId){
                $requestFormService = new AppointmentRequestFormService();
                $requestFormService->appointment_request_form_id = $requestForm->id;
                $requestFormService->business_service_id = $serviceId;
                $requestFormService->save();
            }

            return response()->json([
                'status' => "success",
                'message' => "Talep Formunuz Eklendi. Düzenleme Alanına giderek formunuzu özelleştirebilirsiniz"
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Sistemsel Bir Hata Oluştu Lütfen Sayfayı Yenileyin"
            ]);
        }
    }
    public function show(AppointmentRequestForm $requestForm)
    {
        $this->business->forms()->update([
            'is_default' => 0,
        ]);

        $requestForm->is_default = !$requestForm->is_default;
        if($requestForm->save()){
            if ($requestForm->is_default == 0){
                return response()->json([
                    'status' => "success",
                    'message' => "Talep Formunuz Pasife Alındı"
                ]);
            }
            return response()->json([
               'status' => "success",
               'message' => "Yeni Talep Formunuz Olarak Atandı"
            ]);
        }
    }
    public function edit(AppointmentRequestForm $requestForm)
    {
        $businessServices = $this->business->services;
        $selectedBusinessServiceIds = $requestForm->services()->pluck('business_service_id')->toArray();
        $selectedBusinessServices = $requestForm->services;
        $allQuestions = RequestQuestion::all();
        return view('business.appointment-request-form.detail.show', compact('requestForm', 'businessServices', 'selectedBusinessServiceIds', 'selectedBusinessServices', 'allQuestions'));
    }
    public function update(Request $request, AppointmentRequestForm $requestForm)
    {
        $selectedBusinessServiceIds = $requestForm->services()->pluck('business_service_id')->toArray();
        $requestForm->business_id = $this->business->id;
        $requestForm->name = $request->input('name');
        $requestForm->is_default = 0;
        if ($requestForm->save()){
            foreach ($request->service_id as $serviceId){
                if (!in_array($serviceId, $selectedBusinessServiceIds)){ // var olan hizmetlerin arasında yoksa
                    $requestFormService = new AppointmentRequestFormService();
                    $requestFormService->appointment_request_form_id = $requestForm->id;
                    $requestFormService->business_service_id = $serviceId;
                    $requestFormService->save();
                }
            }

            return response()->json([
                'status' => "success",
                'message' => "Talep Formunuz Güncellendi"
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Sistemsel Bir Hata Oluştu Lütfen Sayfayı Yenileyin"
            ]);
        }
    }

    public function datatable(Request $request)
    {
        $officials = $this->business->forms;
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'AppointmentRequestForm', 'Seçtiğiniz borç ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('is_default', function ($q) {
                return create_custom_route_switch($q->id, $q->is_default == 1 ? true : false, 'AppointmentRequestForm', 'is_default', '/isletme/request-form/'. $q->id);
            })
            ->addColumn('serviceCount', function ($q) {
                return $q->services->count(). " Hizmet";
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.request-form.edit', $q->id));
                $html .= create_delete_button('AppointmentRequestForm', $q->id, 'Form', 'Form Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
