<?php

namespace App\Http\Controllers\Personel\StayOffDay;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonelStayOffDayAddRequest;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Personel\PersonelStayOffDayListResource;
use App\Models\PersonelStayOffDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

/**
 * @group Personel İzin
 *
 */
class PersonelStayOffDayController extends Controller
{
    private $personel;
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->personel = auth()->user();
            $this->business = $this->personel->business;
            return $next($request);
        });
    }

    /**
     * İzin Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $personels = $this->business->personels;

        return view('personel.permission.index', compact('personels'));
    }


    /**
     * İzin Ekleme
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonelStayOffDayAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $stayOffDays = $business->personelStayOffDays()->pluck('personel_id')->toArray();

        foreach (explode(',', $request->personels) as $personelId) {

            if ($this->checkDayControl($personelId, $request->start_time, $request->end_time)) {
                $personel = $this->business->personels()->find($personelId);
                return response()->json([
                    'status' => "error",
                    'message' => "Bu Tarihlerde " . $personel->name . " Personeline İzin Eklediniz. Personeli Listeden Çıkarıp Sonradan Sadece Bu Personeli Seçerek Ekleyebilirsiniz.",
                ]);
            }

            $personelStayOffDay = new PersonelStayOffDay();
            $personelStayOffDay->business_id = $business->id;
            $personelStayOffDay->personel_id = $personelId;
            $personelStayOffDay->start_time = $request->start_time;
            $personelStayOffDay->end_time = $request->end_time;
            $personelStayOffDay->save();
        }

        return response()->json([
            'status' => "success",
            'message' => "İzin Eklendi",
        ]);
    }

    public function destroy(PersonelStayOffDay $personelStayOffDay)
    {
        if ($personelStayOffDay->delete()){
            return response()->json([
                'status' => "success",
                'message' => "İzin Silindi",
            ]);
        }
    }
    public function checkDayControl($personel_id, $secilen_tarih_baslangic, $secilen_tarih_bitis)
    {
        return PersonelStayOffDay::where('personel_id', $personel_id)
            ->where(function($query) use ($secilen_tarih_baslangic, $secilen_tarih_bitis) {
                $query->whereBetween('start_time', [$secilen_tarih_baslangic, $secilen_tarih_bitis])
                    ->orWhereBetween('end_time', [$secilen_tarih_baslangic, $secilen_tarih_bitis]);
            })
            ->exists();
    }
    public function datatable(Request $request)
    {
        $officials = $this->personel->stayOffDays()->when($request->filled('listType'), function ($q) use ($request) {
                $q->whereDate('start_time', '<=', $request->input('listType'))
                ->whereDate('end_time', '>=', $request->input('listType'));
        });
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'PersonelStayOffDay', 'Seçtiğiniz borç ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('personel_id', function ($q) {
                return createName(route('business.personel.edit', $q->personel_id), $q->personel->name);
            })
            ->editColumn('start_time', function ($q) {
                return $q->start_time->format('d.m.Y H:i');
            })
            ->editColumn('end_time', function ($q) {
                return $q->end_time->format('d.m.Y H:i');
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('remainingDate', function ($q) {
                $remainingDate = $q->start_time->diffInDays($q->end_time);
                if ($remainingDate < 0) {
                    return "İzin Bitti";
                } else{
                    return $remainingDate." Gün Kaldı";
                }
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_delete_button('PersonelStayOffDay', $q->id, 'İzin', 'İzin Kaydını Silmek İstediğinize Eminmisiniz? İzin Sadece Sizden Silinecektir', 'false', '/personel/personel-stay-off-day/'.$q->id);

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
