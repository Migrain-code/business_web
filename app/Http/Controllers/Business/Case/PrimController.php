<?php

namespace App\Http\Controllers\Business\Case;

use App\Http\Controllers\Controller;

/**
 * @group Prim
 *
 */
class PrimController extends Controller
{
    private $business;

    private $case;

    public function __construct()
    {
        $this->case = [
            'servicePrice' => 0,
            'productPrice' => 0,
            'total' => 0,
        ];
        $this->middleware(["permission:prim.view"]);
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    public function index()
    {
        $prims = [];
        $personels = $this->business->personels()->where('id', 2)->get();
        foreach ($personels as $personel) {
            $servicePrice = 0;
            foreach ($personel->appointments->whereIn('status', [5, 6]) as $appointment) {
                $servicePrice += $appointment->service->price;
            }

            $productPrice = $personel->sales->sum('total');

            $serviceRate = (($servicePrice * $personel->rate) / 100);

            $productRate = (($productPrice * $personel->product_rate) / 100);
            $total = $serviceRate + $productRate;
            $prims[] = [
                'personelName' => $personel->name,
                'servicePrice' => $serviceRate,
                'productPrice' => $productRate,
                'total' => $total,
            ];
            $this->case['servicePrice'] += $serviceRate;
            $this->case['productPrice'] += $productRate;
            $this->case['total'] += $total;
        }
        $case = $this->case;

        return view('business.case.prim', compact('case', 'prims'));
    }
}
