<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Models\BusinessCost;
use Illuminate\Http\Request;

class PersonelCostController extends Controller
{
    public function index()
    {
        $personel = authUser();
        $payments = $personel->costs;
        return view('personel.payment.index', compact('payments', 'personel'));
    }

}
