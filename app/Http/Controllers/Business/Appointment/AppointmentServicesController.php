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
        $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->start_time);
        $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->end_time);
        $appointmentRange = $personel->appointmentRange->time; // Assuming this is in minutes

        // Get all appointments for the given date
        $appointments = $personel->appointments()
            ->whereDate('start_time', $getDate)
            ->get();

        $i = $startTime;

        while ($i < $endTime) {
            $slotStart = $i->copy();
            $slotEnd = $i->copy()->addMinutes($appointmentRange);

            // Check if the current slot overlaps with any appointment
            $isBooked = false;
            $appointmentDetails = null;

            foreach ($appointments as $appointment) {
                $appointmentStart = Carbon::parse($appointment->start_time);
                $appointmentEnd = Carbon::parse($appointment->end_time);

                // Check if the slotStart or slotEnd falls within an appointment range
                if (
                    ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                    ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                    ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                ) {
                    $isBooked = true;
                    $appointmentDetails = $appointment;
                    break;
                }
            }

            $clocks[] = [
                'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                'status' => $isBooked,
                'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
            ];

            // Move to the next slot
            $i->addMinutes($appointmentRange);
        }

        return $clocks;
    }
    public function findTimes($personel)
    {
        $disableds = [];

        // personelin dolu randevu saatlerini al iptal edilmişleri de dahil et
        $appointments = $personel->appointments()->whereNotIn('status', [3])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime <= $endDateTime) {

                $disableds[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }

        // randevu almaya 30 dk öncesine kadar izin ver
        $startTime = Carbon::parse($personel->start_time);
        $endTime = Carbon::parse($personel->end_time);
        for ($i=$startTime;  $i < $endTime; $i->addMinutes(intval($personel->appointmentRange->time))){
            if ($i < now()->addMinutes(5)){
                $disableds[] = $i->format('d.m.Y H:i');
            }
        }

        return $disableds;
    }
}
