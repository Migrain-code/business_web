<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\BussinessPackage;
use App\Models\BussinessPackagePropartieList;
use App\Models\DayList;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }
    public function step1()
    {
        $businessCategories = BusinessCategory::all();
        $dayList = DayList::all();
        $business = $this->business;
        $proparties = BussinessPackagePropartieList::all();

        $monthlyPackages = BussinessPackage::where('type', 0)->get();
        $yearlyPackages = BussinessPackage::where('type', 1)->get();
        return view('business.setup.step-1.index', compact('businessCategories', 'dayList', 'business', 'monthlyPackages', 'yearlyPackages', 'proparties'));
    }

    public function step1Update(Request $request)
    {
        $business = $this->business;
        $business->category_id = $request->input('category_id');
        if ($business->save()){
            return response()->json([
               'status' => "success",
               'message' => "İşletme Kategoriniz Kayıt Edildi"
            ]);
        }
    }

    public function step2Update(Request $request)
    {
        $business = $this->business;
        $business->personal_count = $request->input('team_size');
        $business->name = $request->input('business_name');
        $business->type_id = $request->input('business_type');
        $business->phone = $request->input('business_phone');
        $business->city = $request->input('city_id');
        $business->district = $request->input('district_id');
        $business->off_day = $request->input('off_day_id');
        $business->about = $request->input('about_content');
        $business->start_time = $request->input('start_time');
        $business->end_time = $request->input('end_time');
        if ($business->save()){
            return response()->json([
                'status' => "success",
                'message' => "İşletme Genel Bilgileriniz Kayıt Edildi"
            ]);
        }
    }

    public function step3Update(Request $request)
    {
        $business = $this->business;
        $business->lat = $request->input('latitude');
        $business->longitude = $request->input('longitude');
        $business->address = $request->input('address');

        if ($business->save()){
            return response()->json([
                'status' => "success",
                'message' => "İşletme Konum Bilgileriniz Kayıt Edildi"
            ]);
        }
    }

    public function step4Update(Request $request)
    {
        $package = BussinessPackage::find($request->package_id);
        if($package->price == 0){
            $business = $this->business;
            $business->package_id = 0;
            $business->packet_start_date = now();
            $business->packet_end_date = now()->addDays(30);
            $business->setup_status = 1;
            if ($business->save()){
                return response()->json([
                    'status' => "success",
                    'message' => "İşletme Kurulumunuz Tamamlandı İşletmenize ". $package->name. " Paketi Tanımlandı. Panele Yönlendiriliyorsunuz",
                    'redirectType' => "redirect"
                ]);
            }

        }


        return response()->json([
            'status' => "success",
            'message' => "Paket seçiminiz tamamlandı. Devam butonuna tıklayın",
            'redirectType' => "not_redirect"
        ]);

    }
}
