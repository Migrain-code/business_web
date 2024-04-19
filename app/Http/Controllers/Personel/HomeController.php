<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
}
