<?php

namespace App\Http\Controllers;

use App\Models\BusinessCloseDate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class BusinessCloseDateController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('business.close-day.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $closeDate = new BusinessCloseDate();
        $closeDate->start_time = $request->input('start_time');
        $closeDate->end_time = $request->input('end_time');
        $closeDate->business_id = $this->business->id;
        if ($closeDate->save()){
            return response()->json([
               'status' => "success",
               'message' => "Kapalı Gün Eklendi"
            ]);
        }
    }

    public function datatable(Request $request)
    {
        $closeDays = $this->business->closeDays;
        return DataTables::of($closeDays)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessCloseDate', 'Seçtiğiniz borç ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('start_time', function ($q) {
                return $q->start_time->format('d.m.Y');
            })
            ->editColumn('end_time', function ($q) {
                return $q->end_time->format('d.m.Y');
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessCloseDate', 'status');
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_delete_button('BusinessCloseDate', $q->id, 'İzin', 'İzin Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
