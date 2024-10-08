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
        $this->middleware(['permission:appointment.calendar.personel'])->only('personelAppointment');
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
        $i = 0;
        $remainingDate = [];

        while ($i <= 30) {
            $remainingDate[] = Carbon::now()->addDays($i);
            $i++;
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
                    'value' => $date->toDateString(),
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'value' => $date->toDateString(),
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date->toDateString(),
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
        $checkCustomWorkTime = $personel->isCustomWorkTime($request->appointment_date);
        $appointmentRange = $personel->appointmentRange->time; // Assuming this is in minutes

        $startOfDay = $getDate->copy()->startOfDay(); // 2024-06-14 00:00:00
        $endOfNextDay = $getDate->copy()->addDays(1)->endOfDay(); // 2024-06-15 23:59:59
        // Get all appointments for the given date
        $appointments = $personel->appointments()
            //->whereDate('start_time', $getDate)
            ->whereBetween('start_time', [$startOfDay, $endOfNextDay])
            ->whereNotIn('status', [3])
            ->orderBy('start_time')
            ->get();

        $lastAppointment = null;
        if (isset($checkCustomWorkTime)) { // özel saat aralığı verilmişmi kontrol et

            $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$checkCustomWorkTime->start_time);
            $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$checkCustomWorkTime->end_time);
            $i = $startTime;
            if ($endTime < $i){ // verilmişse  ve bitiş tarihi başlangıç saatinden küçükse örneğin bitiş 03:00 başlangıç 09:00
                while ($i < $endTime->endOfDay()) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
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

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = [
                            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                            'clock_start' => $slotStart->format('H:i'), // Başlangıç saatini saklayın
                            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                            'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                            'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                            'status' => $isBooked,
                            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
                            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
                            'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
                        ];
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
                $i = $startTime->startOfDay();

                $endTime = Carbon::parse($getDate->addDays(1)->format('Y-m-d').' '.$checkCustomWorkTime->end_time);
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
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

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = [
                            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                            'clock_start' => $slotStart->format('H:i'), // Başlangıç saatini saklayın
                            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                            'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                            'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                            'status' => $isBooked,
                            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
                            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
                            'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
                        ];
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            } else{ // özel aralığa normal saat aralığı verilmişse
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
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

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = [
                            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                            'clock_start' => $slotStart->format('H:i'), // Başlangıç saatini saklayın
                            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                            'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                            'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                            'status' => $isBooked,
                            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
                            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
                            'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
                        ];
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            }

        } else{ // özel saat aralığı yoksa. sadece personel kendi saatleri varsa
            $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->start_time);
            $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->end_time);
            $i = $startTime;
            if ($endTime < $i){ // kendi saatlerine ve bitiş tarihi başlangıç saatinden küçükse örneğin bitiş 03:00 başlangıç 09:00
                while ($i < $endTime->endOfDay()) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
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

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = [
                            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                            'clock_start' => $slotStart->format('H:i'), // Başlangıç saatini saklayın
                            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                            'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                            'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                            'status' => $isBooked,
                            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
                            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
                            'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
                        ];
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
                $i = $startTime->startOfDay();

                $endTime = Carbon::parse($getDate->addDays(1)->format('Y-m-d').' '.$checkCustomWorkTime->end_time);
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
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

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = [
                            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                            'clock_start' => $slotStart->format('H:i'), // Başlangıç saatini saklayın
                            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                            'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                            'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                            'status' => $isBooked,
                            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
                            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
                            'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
                        ];
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            } else{ // kendi saatine normal saat aralığı verilmişse
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
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

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = [
                            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
                            'clock_start' => $slotStart->format('H:i'), // Başlangıç saatini saklayın
                            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
                            'customer' => $isBooked ? CustomerDetailResource::make($appointmentDetails->appointment->customer) : "",
                            'route' => $isBooked ? route('business.appointment.show', $appointmentDetails->appointment_id) : '',
                            'status' => $isBooked,
                            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
                            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
                            'color_code' => $isBooked ? $appointmentDetails->status('color_code') : 'primary',
                        ];
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            }
        }
        return $clocks;
    }

}
