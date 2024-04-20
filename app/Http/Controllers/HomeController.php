<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\InformationAddRequest;
use App\Models\Ads;
use App\Models\BusinessBlog;
use App\Models\BusinessContact;
use App\Models\BusinessFaqCategory;
use App\Models\BussinessPackage;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\MaingPage;
use App\Models\Propartie;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

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
        $blogCategories = Category::all();
        $blogAdvrt = Ads::where('type', 4)->where('status', 1)->get();

        return view('blogs.index', compact('blogCategories', 'blogAdvrt'));
    }

    public function blogDetail($slug)
    {
        $blog = BusinessBlog::whereJsonContains('slug->' . App::getLocale(), $slug)->first();
        if ($blog) {
            $heads = $this->headers($blog->getDescription());

            $blogCategories = Category::all();
            $latestBlog = BusinessBlog::latest()->get();
            return view('blogs.detail.index', compact('blog', 'heads', 'blogCategories', 'latestBlog'));
        } else {
            return back()->with('response', [
                'status' => "warning",
                'message' => "Blog bulunamadı"
            ]);
        }

    }

    public function category($category)
    {
        $blogCategories = Category::whereJsonContains('slug->' . App::getLocale(), $category)->get();

        if ($blogCategories->count() > 0) {
            $ads = Ads::where('type', 4)->where('status', 1)->get();
            return view('blogs.index', compact('blogCategories', 'ads'));
        } else {
            return back()->with('response', [
                'status' => "warning",
                'message' => "Blog bulunamadı"
            ]);
        }

    }

    public function headers($html)
    {
        $heads = [];
        preg_match_all('/<h[1-5].*?>(.*?)<\/h[1-5]>/', $html, $matches);
        foreach ($matches[1] as $match) {
            $heads[] = $match;
        }
        return $heads;
    }

    /**
     * Sık Sorulan Sorular
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function faq()
    {
        $categories = BusinessFaqCategory::where('status', 1)->orderBy('order_number', 'asc')->get();
        return view('faq.index', compact('categories'));
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
        if ($findContact) {
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
        if ($contactInfo->save()) {
            return back()->with('response', [
                'status' => "success",
                'message' => "Ön Bilgilendirme Talebiniz Gönderildi"
            ]);
        }
    }

    public function about()
    {
        return view('about.index');
    }

    public function contact()
    {
        return view('contact.index');

    }

    public function contactRequest(Request $request)
    {
        $request->validate([
            'name' => "required",
            'surname' => "required",
            'email' => "required|min:3|email",
            'phone' => "required|min:3",
            'subject' => "required|min:3",
            'content' => "required|min:3",
        ], [], [
            'name' => "Ad",
            'surname' => "Soyad",
            'email' => "E-posta",
            'phone' => "Telefon",
            'subject' => "Konu",
            'content' => "İçerik",
        ]);
        $contactSearch = BusinessContact::where('ip_address', $request->ip())->latest()->first();
        if (isset($contactSearch) && $contactSearch->created_at < Carbon::now()->subMinutes(5)) {
            $contact = new BusinessContact();
            $contact->name = $request->input('name');
            $contact->surname = $request->input('surname');
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->subject = $request->input('subject');
            $contact->content = $request->input('content');
            $contact->ip_address = $request->ip();
            $contact->save();

            return to_route('contact')->with('response', [
                'status' => "success",
                'message' => "İletişim Mesajı Gönderildi"
            ]);
        } else {
            return to_route('contact')->with('response', [
                'status' => "warning",
                'message' => "Yeni Bir İletişim Mesajı Göndermeden Önce 5 Dk beklemelisiniz"
            ]);
        }
    }
}
