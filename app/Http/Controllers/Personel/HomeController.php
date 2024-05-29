<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $personel = authUser();
        $appointments = $personel->appointments()->whereDate('start_time', now())->get();
        $packageSales = $personel->packages()->whereDate('seller_date', now()->toDateString())->get();
        $productSales = $personel->sales()->whereDate('created_at', now()->toDateString())->get();
        $dates = $this->getDate();
        return view('personel.dashboard.index', compact('personel', 'appointments', 'packageSales', 'productSales', 'dates'));
    }

    public function calendar()
    {
        $appointments = $this->personel->appointments()->whereDate('start_time', now())->get();
        return view('personel.appointment.calender', compact('appointments'));
    }

    public function updateAppointment(Request $request)
    {
        $findAppointment = AppointmentServices::find($request->appointment_id);
        $findAppointment->start_time = Carbon::parse($request->start_time);
        $findAppointment->end_time = Carbon::parse($request->end_time);
        if ($findAppointment->save()){
            return response()->json([
               'status' => "success",
               'message' => "Randevu Başarılı Bir Şekilde ". $findAppointment->start_time->format('d.m.Y H:i'). " Saatine Taşındı"
            ]);
        }
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
                    'value' => $date,
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'value' => $date,
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date,
                ];
            }
        }

        return $dates;
    }
    public function getClock(Request $request)
    {
        $personel = $this->personel;
        $clocks = [];
        $getDate = Carbon::parse($request->appointment_date);
        $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->start_time);
        $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->end_time);
        $appointmentRange = $personel->appointmentRange->time; // Assuming this is in minutes

        // Get all appointments for the given date
        $appointments = $personel->appointments()
            ->whereDate('start_time', $getDate)
            //->whereNotIn('status', [3])
            ->orderBy('start_time')
            ->get();

        $i = $startTime;
        $lastAppointment = null;

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
                    'route' => $isBooked ? route('personel.appointment.show', $appointmentDetails->appointment_id) : '',
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

        // clock_start alanını kaldırın çünkü bu yalnızca dahili kullanım içindir
        foreach ($clocks as &$clock) {
            unset($clock['clock_start']);
        }

        return $clocks;
    }


    public function appointment()
    {
        $personel = authUser();
        return view('personel.appointment.index', compact('personel'));
    }

    public function appointmentDetail(Appointment $appointment)
    {
        $appointmentServiceIds = $appointment->services()->pluck('service_id')->toArray();
        //Randevudaki personeller listeye eklenecek
        $personels = $this->business->personels;
        $services = $this->business->services()->whereNotIn('id', $appointmentServiceIds)->get();
        return view('personel.appointment.edit.index', compact('appointment', 'personels', 'services'));
    }

    public function case(Request $request)
    {
        $personel = $this->personel;


        $totalCiro = $personel->totalCiro($request);
        $progressPayment = $personel->totalBalance($request);
        $balancePayed = $personel->calculatePayedBalance()->sum('price');
        $insideBalance = $personel->insideBalance();

        return view('personel.case.index', compact('personel', 'totalCiro', 'progressPayment', 'balancePayed', 'insideBalance'));

    }
    public function prim(Request $request)
    {
        $personel = $this->personel;
        return view('personel.prim.index', compact('personel'));

    }
}
