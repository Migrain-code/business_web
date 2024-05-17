<?php

namespace App\Http\Controllers\Personel\Adission;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

/**
 * @group Adisyonlar
 *
 */
class AdissionController extends Controller
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
     * Adisyonlar Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('personel.adission.index');
    }

    /**
     * Adisyon Detayı
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $adission)
    {
        $appointment = $adission;
        //Adisyondaki hizmetler bu listede bulunmayacaktır
        $appointmentServiceIds = $appointment->services()->pluck('service_id')->toArray();
        //Adisyondaki personeller listeye eklenecek
        $appointmentPersonelIds = $appointment->services()->pluck('personel_id')->toArray();
        // aynı olan id leri ele
        $personelIds = array_unique($appointmentPersonelIds);
        // collection olarak personelleri al
        $personels = Personel::whereIn('id', $personelIds)->get();
        // collection olarak hizmetleri al
        $services = $this->business->services()->whereNotIn('id', $appointmentServiceIds)->get();

        return view('personel.adission.edit.index', compact('appointment', 'personels', 'services'));

    }

    /**
     * Adisyon gelmedi
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $adission)
    {
        $adission->status = 4;
        $adission->save();

        return back()->with('response',[
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    /**
     * Adisyon Geldi
     *
     * @param \Illuminate\Http\Request $request
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $adission)
    {
        $adission->status = 5;
        $adission->save();

        return back()->with('response',[
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    /**
     * Adisyon İptal Et
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $adission)
    {
        $adission->status = 3;
        $adission->save();
        return back()->with('response',[
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    public function datatable(Request $request)
    {
        $business = $this->business;
        $appointments = $business->appointments()->whereNotIn('status', [0,1])
                ->when($request->filled('listType'), function ($q) use ($request) {
                    if ($request->listType == "open") {
                        $q->where('status', 2);
                    } elseif ($request->listType == "closed") {
                        $q->whereIn('status', [5, 6]);
                    } elseif ($request->listType == "canceled") {
                        $q->whereIn('status', [3, 4]);
                    } else {
                        $q->whereNotIn('status', [0,1]);
                    }
                });

        return DataTables::of($appointments)
            ->addColumn('customerName', function ($q) use ($business) {
                return $q->customer->name;
            })
            ->addColumn('customerPhone', function ($q) use ($business) {
                return createPhone($q->customer->phone, formatPhone($q->customer->phone));
            })
            ->addColumn('services', function ($q) use ($business) {
                if ($q->services->count() > 0){
                    return $q->services->first()->service->subCategory->name . ($q->services->count() > 1 ? " +".$q->services->count()-1 : "");
                }
                else{
                    return "Hizmet Seçilmemiş";
                }
            })
            ->editColumn('start_time', function ($q) {
                return Carbon::parse($q->start_time)->format('d.m.Y');
            })
            ->addColumn('clock', function ($q) use ($business) {
                return Carbon::parse($q->start_time)->format('H:i');
            })
            ->addColumn('servicePrice', function ($q) use ($business) {
                return $q->calculateTotal(). "₺";
            })
            ->editColumn('status', function ($q) {
                return $q->status('html');
            })

            ->addColumn('action', function ($q) {
                return create_show_button(route('personel.adission.show', $q->id), 'text-white');
            })
            ->rawColumns(['id', 'action', 'customerName', 'customerPhone', 'status'])
            ->make(true);
    }


}
