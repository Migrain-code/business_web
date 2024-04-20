<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

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

        return view('personel.dashboard.index', compact('personel', 'appointments', 'packageSales', 'productSales'));
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
}
