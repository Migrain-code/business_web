<?php

namespace App\Http\Controllers\Business\Promossion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promossion\PromosionUpdateRequest;
use App\Http\Resources\Promosion\PromossionListResource;
use App\Models\BusinessPromossion;

/**
 * @group Promosyonlar
 *
 */
class BusinessPromossionController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(['permission:promossion.view']);
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }
    /**
     * Promosyon Listesi
     *
     * Burada işletmenin promosyon listesi dönecek. 1-100 arasında seçim alanlarında mobilde
     * değer üretilip apiden gelen rate verisine göre selected attribute aktif edilecek
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promossions = $this->business->promossions;
        if(!isset($promossions)){
            $promossions = new BusinessPromossion();
            $promossions->business_id = $this->business->id;
            $promossions->cash = 0;
            $promossions->credit_cart = 0;
            $promossions->eft = 0;
            $promossions->use_limit = 10;
            $promossions->birthday_discount = 0;
            $promossions->save();
        }
        return view('business.promossion.index', compact('promossions'));
    }

    /**
     * Promosyon Kayıt Etme
     *
     * Burada işletmenin promosyon listesi dönecek. 1-100 arasında seçim alanlarında mobilde
     * değer üretilip apiden gelen rate verisine göre selected attribute aktif edilecek
     * @return \Illuminate\Http\Response
     */
    public function store(PromosionUpdateRequest $request)
    {

        $promossions = $this->business->promossions;
        $promossions->cash = $request->cash;
        $promossions->credit_cart = $request->credit;
        $promossions->eft = $request->eft;
        $promossions->use_limit = $request->use_limit;
        $promossions->birthday_discount = $request->birthday;
        if($promossions->save()){
            return back()->with('response',[
                'status' => "success",
                'message' => "Promosyon Ayarlarınız Güncellendi"
            ]);
        }
        return back()->with('response',[
            'status' => "error",
            'message' => "Sistemsel Bir Hata Oluştur Lütfen Daha Sonra Tekrar Deneyiniz"
        ], 422);
    }
}
