<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentServiceAddRequest;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\BusinessService;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * @group Appointment
 *
 */
class AppointmentServicesController extends Controller
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
     * Randevuya Hizmet Ekleme
     *
     * @param Request $request
     * @return Response
     */
    public function store(AppointmentServiceAddRequest $request, Appointment $appointment)
    {
        $lastService = $appointment->services()->latest('start_time')->first();
        $endTime = $lastService->end_time;
        $findService = BusinessService::find($request->service_id);

        $appointmentService = new AppointmentServices();
        $appointmentService->appointment_id = $appointment->id;
        $appointmentService->personel_id = $request->personel_id;
        $appointmentService->service_id = $request->service_id;
        $appointmentService->start_time = $endTime;
        $appointmentService->end_time = Carbon::parse($endTime)->addMinutes($findService->time);
        $appointmentService->save();

        return back()->with('response',[
            'status' => "success",
            'message' => "Randevuya Hizmet Eklendi"
        ]);
    }

    public function saveService(Request $request, Appointment $appointment)
    {
        foreach ($request->prices as $key => $price){
            $findService = $appointment->services()->find($key);
            if ($findService){
                $findService->total = $price;
                $findService->save();
            }
        }
        return back()->with('response',[
            'status' => "success",
            'message' => "Randevu Hizmet Fiyatı Güncellendi"
        ]);
    }
    /**
     * Randevudan Hizmet Silme
     *
     * Burada dikkat etmen gereken randevudaki hizmetin id sini göndermeniz olacaktır url'de
     *
     */
    public function destroy(AppointmentServices $appointmentServices)
    {
        $serviceCount = $appointmentServices->appointment->services->count();
        if($serviceCount > 1){
            $appointmentServices->delete();
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Bu Randevudan Kaldırıldı"
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Randevudaki Son Hizmeti Kaldıramazsınız"
        ]);
    }
    public function getDate()
    {
        $remainingDays = Carbon::now()->subDays(1)->diffInDays(Carbon::now()->copy()->endOfMonth());
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $llop = 0;
        $currentDate = clone $startOfMonth; // Klonlama işlemi ile orijinal nesneyi değiştirmeyiz

        while ($currentDate <= $endOfMonth) {
            $remainingDate[] = clone $currentDate; // Klonlanmış nesneyi diziye ekleriz
            $currentDate->addDays(1); // Orijinal nesneyi güncelleme yerine yeni bir nesne oluştururuz
        }
        foreach ($remainingDate as $date) {
            $dateStartOfDay = clone $date;
            $dateStartOfDay->startOfDay();

            $today = Carbon::now()->startOfDay();
            $tomorrow = Carbon::now()->addDays(1)->startOfDay();

            if ($dateStartOfDay->eq($today)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Bugün",
                    'text' => "Bugün",
                    'value' => $date->format('Y-m-d'),
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'value' => $date->format('Y-m-d'),
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date->format('Y-m-d'),
                ];
            }
        }

        return $dates;
    }
    public function personelAppointment()
    {
        $dates = $this->getDate();
        $personels = $this->business->personels;
        return view('business.appointment.personel.index', compact('dates', 'personels'));
    }
    public function getClock(Request $request, Personel $personel)
    {
        $clocks = [];
        $getDate = Carbon::parse($request->appointment_date);
        $i = Carbon::parse($getDate->format('Y-m-d').' '.$personel->start_time);
        $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->end_time);

        while ($i < $endTime){

            $getAppointment = $personel->appointments()->where('start_time', $i->toDateTime())->first();
            $clocks[] = [
                'clock' => $i->format('H:i'). "-". $i->addMinute($personel->appointmentRange->time)->format('H:i'),
                'title' =>isset($getAppointment) ? $getAppointment->service->subCategory->name : '',
                'customer' =>isset($getAppointment) ? CustomerDetailResource::make($getAppointment->appointment->customer) : "",
                'route' =>isset($getAppointment) ? route('business.appointment.show', $getAppointment->appointment_id) : '',
                'status' => isset($getAppointment),
                'color_code' =>  isset($getAppointment) ? $getAppointment->status('color_code') : 'primary',
            ];
        }

        return $clocks;
    }

}
