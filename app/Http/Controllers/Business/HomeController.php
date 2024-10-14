<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessOfficial;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        //$saleTotal = $this->calculateSale()["saleTotal"];
        $monthlyAppointmentTotal = $this->calculateAppointment()["appointmentMonthly"];
        $monthlySaleTotal = $this->calculateSale()["monthlySaleTotal"];
        $monthlyPackageSaleTotal = $this->calculateSale()["monthlyPackageSales"];
        $serviceTotal = $this->calculateService();
        $customerTotal = $this->business->customers->count();

        $todayCiro = $this->calculateToday();
        $todayCosts = $this->business->costs()->whereDate('operation_date', now()->toDateString())->sum('price');
        $todayAppointments = $this->business->appointments()->whereDate('start_time', now()->toDateString())->count();
        $newCustomerCount = $this->business->customers()->whereDate('created_at',now()->toDateString())->count();
        $totalCustomerCount = $this->business->customers->count();
        $todaySaleCount = $this->business->sales()->whereDate('created_at',now()->toDateString())->count();
        $todayPackageSaleCount = $this->business->packages()->whereDate('seller_date',now()->toDateString())->count();
        $todayAppointmentRequestCount = $this->business->requests()->whereStatus(0)->whereDate('created_at', now()->toDateString())->count();

        return view('business.dashboard.index', compact('todayAppointments','newCustomerCount','totalCustomerCount', 'todaySaleCount','todayPackageSaleCount','todayAppointmentRequestCount', 'monthlySaleTotal', 'serviceTotal', 'customerTotal', 'monthlyPackageSaleTotal', 'todayCiro', 'todayCosts', 'monthlyAppointmentTotal'));
    }

    public function calculateSale()
    {
        $business = $this->business;

        $saleTotal = $business->sales()->sum('total');
        $saleTotal += $business->packages()->sum('total');
        $monthlySales = [];
        $monthlyPackageSales = [];
        for ($i = 0; $i < 12; $i++) {
            $monthlySaleTotal = $business->sales()->whereMonth('created_at', $i + 1)->sum('total');
            $monthlyPackageSaleTotal = $business->packages()->whereMonth('seller_date', $i + 1)->sum('total');
            $monthlySales[] = $monthlySaleTotal;
            $monthlyPackageSales[] = $monthlyPackageSaleTotal;
        }

        return [
            'saleTotal' => $saleTotal,
            'monthlySaleTotal' => $monthlySales,
            'monthlyPackageSales' => $monthlyPackageSales,
        ];
    }
    public function calculateAppointment()
    {
        $business = $this->business;

        // Toplam randevu sayısı
        $saleTotal = $business->appointments->count();

        // Aylık randevu sayısı
        $monthlySales = $business->appointments()->whereNot('status', 3)
            ->selectRaw('MONTH(start_time) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Bütün ayları içermezse eksikleri 0 ile tamamla
        $monthlySales = array_replace(array_fill(1, 12, 0), $monthlySales);

        return [
            'appointmentMonthly' => array_values($monthlySales),
            'appointmentTotal' => $saleTotal,
        ];
    }
    public function calculateToday() // bugünkü toplam ürün + paket + adisyon tahsilatı
    {
        $business = $this->business;

        $saleTotal = $business->sales()->whereDate('created_at', now()->toDateString())->sum('total'); //bugünkü ürün satış
        // bugünkü paket satış ödemeleri
        foreach ($business->packages as $package) {
            $saleTotal += $package->payeds()->whereDate('created_at', now()->toDateString())->sum('price');
        }
        $appointments = $business->appointments()->whereDate('start_time', now()->toDateString())->get();
        foreach ($appointments as $appointment) {
            $saleTotal += $appointment->payments()->whereDate('created_at', now()->toDateString())->sum('price');
        }
        return $saleTotal;
    }

    public function calculateService()
    {
        $serviceTotal = 0;
        $appointments = $this->business->appointments()->whereIn('status', [5, 6])->get();
        foreach ($appointments as $appointment) {
            $serviceTotal += calculateTotal($appointment->services);
        }
        return $serviceTotal;
    }

}
