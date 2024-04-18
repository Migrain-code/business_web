<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\InformationAddRequest;
use App\Models\BussinessPackage;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\MaingPage;
use App\Models\Propartie;
use App\Models\Sponsor;

class HomeController extends Controller
{
    /**
     * Anasayfa
     */
    public function index()
    {
        $brands = Sponsor::whereStatus(1)->get();
        $mainPagePartitions = MaingPage::whereType(1)->whereStatus(1)->get();
        $comments = Comment::whereStatus(1)->take(5)->get();
        $proparties = Propartie::orderBy('order_number')->whereStatus(1)->where('is_featured', 1)->get();
        return view('main-page.index', compact('proparties', 'comments', 'brands', 'mainPagePartitions'));
    }

    /**
     * Özellikler
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function proparties()
    {
        $proparties = Propartie::orderBy('order_number')->whereStatus(1)->get();
        return view('proparties.index', compact('proparties'));
    }

    public function propartieDetail($slug)
    {
        $propartie = Propartie::where('slug', $slug)->first();

        return view('proparties.detail.index', compact('propartie'));
    }
    /**
     * Fiyatlandırma
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     *
     */
    public function prices()
    {
        $monthlyPackages = BussinessPackage::where('type', 0)->get();
        $yearlyPackages = BussinessPackage::where('type', 1)->get();

        return view('prices.index', compact('monthlyPackages', 'yearlyPackages'));
    }

    /**
     * Referanslar
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function references()
    {
        $brands = Sponsor::whereStatus(1)->get();

        return view('references.index', compact('brands'));
    }

    /**
     * Bloglar
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function blogs()
    {
        return view('blogs.index');
    }

    /**
     * Blog detayı
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function blogDetail($slug)
    {
        return view('blogs.detail.index');
    }

    /**
     * Sık Sorulan Sorular
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function faq()
    {
        return view('faq.index');
    }

    /**
     * Giriş Türleri
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function loginTypes()
    {
        return view('login-type.index');
    }

    public function informationRequest(InformationAddRequest $request)
    {
        $findContact = ContactInfo::where('ip_address', $request->ip())->whereStatus(0)->first();
        if ($findContact){
            return back()->with('response', [
                'status' => "error",
                'message' => "Ön Bilgilendirme Talebini Daha Önce Gönderdiniz"
            ]);
        }
        $contactInfo = new ContactInfo();
        $contactInfo->name = $request->input('name');
        $contactInfo->salon_name = $request->input('salon_name');
        $contactInfo->phone = $request->input('phone');
        $contactInfo->ip_address = $request->ip();
        if ($contactInfo->save()){
            return back()->with('response', [
                'status' => "success",
                'message' => "Ön Bilgilendirme Talebiniz Gönderildi"
            ]);
        }
    }
}
