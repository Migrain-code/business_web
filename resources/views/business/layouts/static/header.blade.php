<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
    <title>{{config('app.name', 'Laravel')}} | @yield('title', '')</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <link rel="canonical" href="">
    <link rel="shortcut icon" href="{{image(setting('speed_favicon'))}}">

    @include('business.layouts.components.styles')
    @if(request()->routeIs('business.setup.*'))
        <style>
            @media (min-width: 992px){
                [data-kt-app-sidebar-fixed=true] .app-wrapper {
                    margin-left: 0px;
                    margin-top: 0px;
                }
            }
        </style>
    @endif
</head>
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    @include('business.layouts.components.theme-mode')

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
            @if(!request()->routeIs('business.setup.*'))
                @include('business.layouts.menu.top')
            @endif
            <div class="app-wrapper  d-flex " id="kt_app_wrapper">
                @if(!request()->routeIs('business.setup.*'))
                    @include('business.dashboard.parts.side-personel')
                @endif
                <!--begin::Wrapper container-->
                <div class="app-container  container-fluid ">

                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">

                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">

                            <!--begin::Toolbar-->
                            @include('business.layouts.components.breadcrumb')
                            <!--end::Toolbar-->
