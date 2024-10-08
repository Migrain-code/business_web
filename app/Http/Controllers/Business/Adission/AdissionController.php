<?php

namespace App\Http\Controllers\Business\Adission;

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
        $this->middleware(['permission:adission.list'])->only('index');
        $this->middleware(['permission:adission.show'])->only('show');
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
        $personels = $this->business->personels;
        return view('business.adission.index', compact('personels'));
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

        $personels = $this->business->personels;
        // collection olarak hizmetleri al
        $services = $this->business->services()->whereNotIn('id', $appointmentServiceIds)->get();

        return view('business.adission.edit.index', compact('appointment', 'personels', 'services'));

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
        foreach ($adission->services as $service){
            $service->status = 4;
            $service->save();
        }
        return back()->with('response',[
            'status' => "success",
            'message' => "Adisyon durumu GELMEDİ olarak güncellendi"
        ]);
    }

    /**
     * Adisyon Yazdır
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function printAdission(Appointment $adission)
    {
        foreach ($adission->services as $service){
            if($service->service->price_type_id == 1 && $service->total == 0){
                return back()->with('response', [
                   'status' => "error",
                   'message' => "Adisyona net tutarı girmeden yazdıramazsınız"
                ]);
            }
        }
        return view('business.adission.edit.print.index', compact('adission'));
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
        foreach ($adission->services as $service){
            $service->status = 5;
            $service->save();
        }
        return back()->with('response',[
            'status' => "success",
            'message' => "Adisyon durumu GELDİ güncellendi"
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
        foreach ($adission->services as $service){
            $service->status = 3;
            $service->save();
        }
        return back()->with('response',[
            'status' => "success",
            'message' => "Adisyon İPTAL EDİLDİ"
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
                })
            ->has('customer')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                    // ->orWhere('phone', 'like', '%' . $name . '%');
                })->orWhere('id' ,$name);;
            })
            ->limit(100)
            ->latest();
        return DataTables::of($appointments)
            ->addColumn('customerName', function ($q) use ($business) {
                return createName(route('business.customer.edit', $q->customer->id), $q->customer->name);
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
                return create_show_button(route('business.adission.show', $q->id), 'text-white');
            })
            ->rawColumns(['id', 'action', 'customerName', 'customerPhone', 'status'])
            ->make(true);
    }


}
