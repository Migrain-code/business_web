<header>
    <div class="container">
        <div class="row">
            <div class="col-4 col-xl-2 d-flex align-items-center">
                <div class="logo">
                    <a href="/">
                        <img
                            src="{{image(setting('business_logo_white'))}}"
                            class="logo-white"
                            alt="logo"
                        />
                        <img
                            src="{{image(setting('business_logo_dark'))}}"
                            class="logo-dark"
                            alt="logo"
                        />
                    </a>
                </div>
            </div>
            <div class="col-lg-7 d-none d-xl-block">
                <div class="topMenu">
                    <ul>
                        <li @if(request()->routeIs('welcome')) class="active" @endif >
                            <a href="/">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-home-2"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                    <path
                                        d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"
                                    ></path>
                                    <path d="M10 12h4v4h-4z"></path>
                                </svg>
                                Ana Sayfa
                            </a>
                        </li>
                        <li @if(request()->routeIs('proparties')) class="active" @endif >
                            <a href="{{route('proparties')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-category"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 4h6v6h-6z"></path>
                                    <path d="M14 4h6v6h-6z"></path>
                                    <path d="M4 14h6v6h-6z"></path>
                                    <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                                Özellikler
                            </a>
                        </li>
                        <li @if(request()->routeIs('prices')) class="active" @endif >
                            <a href="{{route('prices')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-users"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path
                                        d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                    ></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                </svg>
                                Fiyatlandırma
                            </a>
                        </li>
                        <li @if(request()->routeIs('references')) class="active" @endif >
                            <a href="{{route('references')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-24-hours"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 13c.325 2.532 1.881 4.781 4 6"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2"></path>
                                    <path d="M4 5v4h4"></path>
                                    <path
                                        d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2"
                                    ></path>
                                    <path d="M18 15v2a1 1 0 0 0 1 1h1"></path>
                                    <path d="M21 15v6"></path>
                                </svg>
                                Referanslar
                            </a>
                        </li>
                        <li @if(request()->routeIs('blogs')) class="active" @endif >
                            <a href="{{route('blogs')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-article"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"
                                    ></path>
                                    <path d="M7 8h10"></path>
                                    <path d="M7 12h10"></path>
                                    <path d="M7 16h10"></path>
                                </svg>
                                Blog
                            </a>
                        </li>
                        <li @if(request()->routeIs('faq')) class="active" @endif >
                            <a href="{{route('faq')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-article"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"
                                    ></path>
                                    <path d="M7 8h10"></path>
                                    <path d="M7 12h10"></path>
                                    <path d="M7 16h10"></path>
                                </svg>
                                S.S.S.
                            </a>
                        </li>
                        <li @if(request()->routeIs('welcome')) class="d-sm-none active" @else class="d-sm-none"  @endif>
                            <a href="{{route('contact')}}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-building"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 21l18 0"></path>
                                    <path d="M9 8l1 0"></path>
                                    <path d="M9 12l1 0"></path>
                                    <path d="M9 16l1 0"></path>
                                    <path d="M14 8l1 0"></path>
                                    <path d="M14 12l1 0"></path>
                                    <path d="M14 16l1 0"></path>
                                    <path
                                        d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"
                                    ></path>
                                </svg>
                                İletişim</a>
                        </li>
                        <li class="mobile-menu-logo">
                            <img src="{{image(setting('business_logo_white'))}}" alt="" />
                        </li>
                        <div class="contact-navbar">
                            <li class="contact-info">
                    <span>
                      <img src="/front/assets/images/icons/ico-phone.svg" alt="" />
                      <a href="tel:{{setting('business_phone')}}">{{setting('business_phone')}}</a>
                    </span>
                                <span>
                                    <a href="mailto:{{setting('business_email')}}" style="overflow-wrap: anywhere;"><img src="/front/assets/images/icons/ico-mail.svg" alt="" /> {{setting('business_email')}}</a>
                                </span>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
            <div
                class="col-8 col-xl-3 d-flex align-items-center justify-content-end"
            >
                <div class="headerRight">
                    <a href="{{route('loginTypes')}}" class="btn-outline-white"> Giriş Yap </a>
                    <a href="{{route('business.register')}}" class="btn-white d-none d-sm-block">Ücretsiz Dene</a>
                    <a href="javascript:;" class="toggle"><span></span></a>
                </div>
            </div>
        </div>
    </div>
</header>
