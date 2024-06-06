<?php

namespace App\Http\Controllers;

use App\Models\PersonelWorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class PersonelWorkTimeController extends Controller
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
        $personels = $this->business->personels;
        return view('business.personel-custom-work-time.index', compact('personels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach ($request->personels as $personelId){
            $personelCustomWorkTime = new PersonelWorkTime();
            $personelCustomWorkTime->personel_id = $personelId;
            $personelCustomWorkTime->business_id = $this->business->id;
            $personelCustomWorkTime->start_date = $request->start_date;
            $personelCustomWorkTime->end_date = $request->end_date;
            $personelCustomWorkTime->start_time = $request->start_time;
            $personelCustomWorkTime->end_time = $request->end_time;
            $personelCustomWorkTime->save();
        }

        return response()->json([
            "status" => "success",
            "message" => "Personellere özel çalışma saatleri eklendi"
        ], 200);
    }

    public function datatable(Request $request)
    {
        $workTimes = $this->business->customWorkTimes;
        return DataTables::of($workTimes)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'PersonelWorkTime', 'Seçtiğiniz borç ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('personel_id', function ($q) {
                return $q->personel->name;
            })
            ->editColumn('start_date', function ($q) {
                return $q->start_date->format('d.m.Y');
            })
            ->editColumn('end_date', function ($q) {
                return $q->end_date->format('d.m.Y');
            })
            ->addColumn('time_range', function ($q) {
                return Carbon::parse($q->start_time)->format('H:i'). " - ".Carbon::parse($q->end_time)->format('H:i');
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'PersonelWorkTime', 'status');
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_delete_button('PersonelWorkTime', $q->id, 'Özel Çalışma', 'Özel Çalışma Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }
}
