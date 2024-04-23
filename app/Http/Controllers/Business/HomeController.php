<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;

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
        $saleTotal = $this->calculateSale()["saleTotal"];
        $monthlySaleTotal = $this->calculateSale()["monthlySaleTotal"];
        $monthlyPackageSaleTotal = $this->calculateSale()["monthlyPackageSales"];
        $serviceTotal = $this->calculateService();
        $customerTotal = $this->business->customers->count();

        return view('business.dashboard.index', compact('saleTotal', 'monthlySaleTotal', 'serviceTotal', 'customerTotal', 'monthlyPackageSaleTotal'));
    }

    public function calculateSale()
    {
        $business = $this->business;

        $saleTotal = $business->sales()->sum('total');
        $saleTotal += $business->packages()->sum('total');
        $monthlySales = [];
        $monthlyPackageSales = [];
        for ($i = 0; $i < 12; $i++) {
            $monthlySaleTotal = $business->sales()->whereMonth('created_at', $i+1)->sum('total');
            $monthlyPackageSaleTotal = $business->packages()->whereMonth('seller_date', $i+1)->sum('total');
            $monthlySales[] = $monthlySaleTotal;
            $monthlyPackageSales[] = $monthlyPackageSaleTotal;
        }

        return [
            'saleTotal' => $saleTotal,
            'monthlySaleTotal' => $monthlySales,
            'monthlyPackageSales' => $monthlyPackageSales,
        ];
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
