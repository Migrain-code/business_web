<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customer\CustomerListResource;
use Illuminate\Http\Request;

class SpeedAppointmentController extends Controller
{
    private $business;
    private $personel;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->personel = auth()->user();
            $this->business = $this->personel->business;
            return $next($request);
        });
    }
    public function getCustomerList(Request $request)
    {
        $customers = $this->business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request){
                $q->whereHas('customer', function ($q) use ($request){
                    $q->where('name', 'like', '%' . $request->input('name') . '%');
                });
            })
            ->take(250)->get();
        return response()->json(CustomerListResource::collection($customers));
    }
}
