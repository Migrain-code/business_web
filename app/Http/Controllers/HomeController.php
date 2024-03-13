<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Anasayfa
     */
    public function index()
    {
        return view('main-page.index');
    }

    /**
     * Özellikler
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function proparties()
    {
        return view('proparties.index');
    }

    /**
     * Fiyatlandırma
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     *
     */
    public function prices()
    {
        return view('prices.index');
    }

    /**
     * Referanslar
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function references()
    {
        return view('references.index');
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
}
