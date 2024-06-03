<?php

namespace App\Http\Controllers\Personel\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use mysql_xdevapi\Exception;
use Yajra\DataTables\DataTables;

/**
 * @group Appointment
 *
 */
class AppointmentController extends Controller
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
        $personel = $this->personel;

        return view('personel.appointment.index', compact('appoinments', 'personel'));
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

        return view('personel.appointment.edit.index', compact('appointment', 'personels', 'services'));
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
        foreach ($appointment->services as $service){
            $service->status = 2;
            $service->save();
        }
        return to_route('personel.appointment.show', $appointment->id)->with('response', [
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
        foreach ($appointment->services as $service){
            $service->status = 1;
            $service->save();
        }
        return to_route('personel.appointment.show', $appointment->id)->with('response', [
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
        foreach ($appointment->services as $service){
            $service->status = 3;
            $service->save();
        }
        return to_route('personel.appointment.show', $appointment->id)->with('response', [
            'status' => "success",
            'message' => "Randevu İptal Edildi"
        ]);
    }

    public function datatable(Request $request)
    {
        $business = $this->business;
        $personel = $this->personel;
        $appointments = $business->appointments()->whereNotIn('status', [4,5,6])
            ->whereHas('services', function ($q) use ($personel){
                $q->where('personel_id', $personel->id);
            })
            ->get();

        return DataTables::of($appointments)
            //->setTotalRecords($appointments->count())

            ->addColumn('customerName', function ($q) use ($business) {
                return $q->customer->name;
            })
            ->editColumn('room_id', function ($q) {
                return '<span style="color:'. ($q->room->color ?? "#7E8299"). ';">'. ($q->room->name?? "Salon"). '</span>';
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
                $total = $q->calculateTotal();
                return is_numeric($total) ? formatPrice($total) : "Hesaplanacak";
            })
            ->editColumn('status', function ($q) {
                return $q->status('html');
            })
            ->addColumn('action', function ($q) {
                return create_show_button(route('personel.appointment.show', $q->id), 'text-white');
            })
            ->rawColumns(['id', 'action', 'customerName', 'room_id', 'status'])
            ->make(true);
    }
}
