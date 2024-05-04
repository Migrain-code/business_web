<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setup\DetailSetupStep2UpdateRequest;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\ServiceCategory;
use App\Services\UploadFile;
use Illuminate\Http\Request;

class DetailSetupController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }
    public function detailSetup(Request $request)
    {
        $dayList = DayList::all();
        $business = $this->business;
        $serviceCategories = ServiceCategory::all();
        $services = $this->business->services;
        $ranges = AppointmentRange::all();
        $types = BusinnessType::all();
        return view('business.setup.step-2.index', compact( 'dayList', 'business', 'serviceCategories', 'services', 'types', 'ranges'));
    }

    public function detailSetupStep1(DetailSetupStep2UpdateRequest $request)
    {
        $business = $this->business;
        $business->name = $request->input('business_name');
        $business->phone = $request->input('business_phone');
        $business->off_day = $request->input('off_day_id');
        $business->start_time = $request->input('start_time');
        $business->end_time = $request->input('end_time');
        $business->appoinment_range = $request->input('appoinment_range');
        if ($request->hasFile('image')) {
           // $response = UploadFile::uploadFile($request->file('image'), 'business_logos');
           // $business->logo = $response["image"]["way"];
        }
        if ($business->save()){
            return response()->json([
                'status' => "success",
                'message' => "İşletme Detaylı Bilgileriniz Kayıt Edildi"
            ]);
        }
    }

}
