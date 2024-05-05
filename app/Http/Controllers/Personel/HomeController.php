<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
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
    public function getClock(Request $request)
    {
        $personel = $this->personel;
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
                'route' =>isset($getAppointment) ? route('personel.appointment.detail', $getAppointment->appointment_id) : '',
                'status' => isset($getAppointment),
                'color_code' =>  isset($getAppointment) ? $getAppointment->status('color_code') : 'primary',
            ];
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
