<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

/**
 * @group Appointment
 *
 */
class AppointmentController extends Controller
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
     * Tüm Randevular
     *
     *
     * listType = thisDay
     * listType = thisWeek
     * listType = thisMonth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        //$reqDate = Carbon::parse($request->date)->format('Y-m-d');
        //$appoinments = $business->appointments()->whereDate('start_time', $reqDate)->orderBy('start_time', 'asc')->get();
        $appoinments = $business->appointments()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('start_time', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('start_time', now()->toDateString());
            }
        })->get();
        return view('business.appointment.index', compact('appoinments'));
    }

    /**
     * Randevu Detayı
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $appointment)
    {
        //Randevudaki hizmetler bu listede bulunmayacaktır
        $appointmentServiceIds = $appointment->services()->pluck('service_id')->toArray();
        //Randevudaki personeller listeye eklenecek
        $personels = $this->business->personels;
        $services = $this->business->services()->whereNotIn('id', $appointmentServiceIds)->get();
        return view('business.appointment.edit.index', compact('appointment', 'personels', 'services'));
    }

    /**
     * Randevu Tamamla
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $appointment->status = 2;
        $appointment->save();

        return to_route('business.appointment.show', $appointment->id)->with('response', [
            'status' => "success",
            'message' => "Randevuya Durumu Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    /**
     * Randevu Onayla
     *
     * Body içerisinde
     * note olarak göndermeniz yeterlidir.
     * @param \Illuminate\Http\Request $request
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->status = 1;
        $appointment->save();

        return to_route('business.appointment.show', $appointment->id)->with('response', [
            'status' => "success",
            'message' => "Randevuya Durumu Başarılı Bir Şekilde Onaylandı"
        ]);
    }

    /**
     * Randevu İptal Et
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->status = 3;
        $appointment->save();

        return to_route('business.appointment.show', $appointment->id)->with('response', [
            'status' => "success",
            'message' => "Randevu İptal Edildi"
        ]);
    }

    public function datatable(Request $request)
    {
        $business = $this->business;
        $appointments = $business->appointments()->whereNotIn('status', [4,5,6])->get();

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
                return create_show_button(route('business.appointment.show', $q->id), 'text-white');
            })
            ->rawColumns(['id', 'action', 'customerName', 'customerPhone', 'status'])
            ->make(true);
    }
}