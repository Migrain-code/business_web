<?php

namespace App\Http\Controllers;

use App\Http\Requests\Business\BusinessInfoUpdateRequest;
use App\Models\AppointmentRange;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessSettingController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }
    public function index()
    {
        $business = $this->business;
        $dayList = DayList::all();
        $ranges = AppointmentRange::all();
        $types = BusinnessType::all();
        $categories = BusinessCategory::all();
        return view('business.setting.index', compact('business', 'dayList', 'ranges', 'types', 'categories'));
    }

    public function updateInfo(BusinessInfoUpdateRequest $request)
    {

        $business = $this->business;
        $business->category_id = $request->input('category_id');
        $business->personal_count = $request->input('team_size');
        $business->approve_type = $request->input('approve_type');
        $business->stock_count = $request->input('stock_count');
        $business->name = $request->input('name');
        if ($business->name != $request->input('name')){
            $business->slug = $this->checkSlug($request->input('name'));
        }
        $business->name = $request->input('name');
        $business->slug = Str::slug($request->input('name'));
        $business->business_email = $request->input('email');
        $business->type_id = $request->input('type_id');
        $business->phone = $request->input('phone');
        $business->city = $request->input('city_id');
        $business->district = $request->input('district_id');
        $business->off_day = $request->input('off_day');
        $business->about = $request->input('about_content');
        $business->start_time = $request->input('start_time');
        $business->end_time = $request->input('end_time');
        $business->appoinment_range = $request->input('range');
        if ($request->hasFile('avatar')){
            $response = UploadFile::uploadFile($request->file('avatar'), 'businessLogos');
            $business->logo = $response["image"]["way"];
        }
        if ($business->save()){
            return back()->with('response',[
                'status' => "success",
                'message' => "İşletme Bilgileriniz Kayıt Edildi"
            ]);
        }
    }

    public function checkSlug($business_name)
    {
        $slug = Str::slug($business_name);
        $existBusinessSlug = Business::whereSlug($slug)->count();
        if ($existBusinessSlug > 0){
            $slug .= "-". $existBusinessSlug + 1;
        }

        return $slug;
    }
}
