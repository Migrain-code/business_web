<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
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
        $this->middleware(['permission:appointment.list'])->only('index');
        $this->middleware(['permission:appointment.show'])->only('show');
        $this->middleware(['permission:appointment.calendar.show'])->only('calendar');

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
        $personels = $this->business->personels;
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
        return view('business.appointment.index', compact('appoinments', 'personels'));
    }
    public function calendar()
    {
        $appointments = $this->business->appointments()->whereIn('status', [0, 1])
            ->whereBetween('start_time', [
                now()->subDays(10)->startOfDay(),
                now()->addMonth()->endOfDay()
            ])
            ->take(6)
            ->get();

        return view('business.appointment.calender', compact('appointments'));
    }

    public function todayAppointment()
    {
        $personels = $this->business->personels()
            //->has('todayAppointments')
            ->get()
            ->sortBy('name');
        $business = $this->business;
        return view('business.appointment.today', compact('personels', 'business'));
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
       // return to_route('business.adission.show', $appointment->id);
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
        foreach ($appointment->services as $service){
            $service->status = 2;
            $service->save();
        }
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
        foreach ($appointment->services as $service){
            $service->status = 1;
            $service->save();
        }
        $message = $this->business->name. " İşletmesine ". $appointment->start_time->format('d.m.Y H:i'). " tarihindeki randevunuz işletme tarafından onaylanmıştır.";
        $appointment->customer->sendSms($message);
        $appointment->sendMessages(false);
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
        foreach ($appointment->services as $service){
            $service->status = 3;
            $service->save();
        }
        DB::table('jobs')->where('id', $appointment->job_id)->delete();
        $message = $this->business->name. " İşletmesine ". $appointment->start_time->format('d.m.Y H:i'). " tarihindeki randevunuz işletme tarafından iptal edilmiştir.";

        return to_route('business.appointment.show', $appointment->id)->with('response', [
            'status' => "success",
            'message' => "Randevu İptal Edildi"
        ]);
    }

    public function datatable(Request $request)
    {
        $business = $this->business;

        $appointments = $business->appointments()
            ->has('customer')
            ->whereNotIn('status', [4,5,6])
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
            ->editColumn('id', function ($q) {
                return '#'. $q->id;
            })
            ->addColumn('customerName', function ($q) use ($business) {
                return createName(route('business.customer.edit', $q->customer->id), $q->customer->name);
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
                return create_show_button(route('business.appointment.show', $q->id), 'text-white');
            })
            ->rawColumns(['id', 'action', 'customerName', 'room_id', 'status'])
            ->make(true);
    }
}
