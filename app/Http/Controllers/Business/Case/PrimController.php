<?php

namespace App\Http\Controllers\Business\Case;

use App\Http\Controllers\Controller;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        //$this->middleware(["permission:prim.list"])->only(['index']);
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $startTime = now();
        $endTime = now();
        if ($request->filled('date_range')){
            $timePartition = explode('-', $request->date_range);
            $startTime = Carbon::parse(clearPhone($timePartition[0]))->toDateString();
            $endTime = Carbon::parse(clearPhone($timePartition[1]))->toDateString();
        }


        $personels = $this->business->personels;
        if ($request->filled('personel_id')){
            $personel = Personel::find($request->personel_id);
        } else{
            $personel = $personels->first();
        }

        $case = $personel->case(null, $startTime, $endTime);
        //dd($case);

        return view('business.case.prim', compact('personel', 'case', 'personels'));
    }
}
