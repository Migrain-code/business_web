<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    @include('layouts.static.meta')

    <link rel="stylesheet" href="/front/assets/fonts/EuclidCircularA/stylesheet.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="/front/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/front/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/front/assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="/front/assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/front/assets/css/jquery-ui.min.css" />
    <link rel="stylesheet" href="/front/assets/css/lightbox.min.css" />
    <link rel="stylesheet" href="/front/assets/css/hc-offcanvas-nav.carbon.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <link rel="stylesheet" href="/front/assets/css/tom-select.css" />
    <link rel="stylesheet" href="/front/assets/css/style.css" />
    <link rel="stylesheet" href="/front/assets/css/responsive.css" />
    <link rel="stylesheet" href="/front/assets/css/custom.css" />
    <link rel="stylesheet" href="/front/assets/css/business.css" />
    <script src="/front/assets/js/jquery.min.js"></script>
    <script src="/front/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/front/assets/js/owl.carousel.min.js"></script>
    <script src="/front/assets/js/jquery-ui.min.js"></script>
    <script src="/front/assets/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="/front/assets/js/hc-offcanvas-nav.js"></script>
    <script src="/front/assets/js/tom-select.complete.min.js"></script>
    <script src="/front/assets/js/app.js"></script>

    <link rel="shortcut icon" href="{{image(setting('speed_favicon'))}}">
    <script src="//code.jivosite.com/widget/HiXoAzoaMg" async></script>

    <style>
        ::-webkit-scrollbar{
            width: 10px;
        }
        ::-webkit-scrollbar-thumb{
            background: #f22969;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-track{
            background: #ffffff;
        }
        @media (max-width: 500px) {
            .home-stats {
                padding: 20px 20px !important;
            }
        }
    </style>
    @yield('style')
</head>
<body>
@include('layouts.menu.top')
