<?php

namespace App\Http\Controllers\Business\Form;

use App\Http\Controllers\Controller;
use App\Models\BusinessAppointmentRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BusinessAppointmentRequestController extends Controller
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
    public function show(BusinessAppointmentRequest $businessAppointmentRequest)
    {
        //
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
    public function update(Request $request, BusinessAppointmentRequest $businessAppointmentRequest)
    {
        //
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
                return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessAppointmentRequest', 'status');
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.appointment-request.edit', $q->id));
                $html .= create_delete_button('BusinessAppointmentRequest', $q->id, 'Form', 'Form Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
