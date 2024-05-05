<!DOCTYPE html>

<html lang="tr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <title>{{config('app.name', 'Laravel')}} | @yield('title', '')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('business.layouts.components.styles')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--Begin::Google Tag Manager (noscript) -->

<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @if(!request()->routeIs('business.setup.*') && !request()->routeIs('business.detailSetup.*'))
          @include('business.layouts.menu.top')
        @endif
         <div class="@if(!request()->routeIs('business.setup.*') && !request()->routeIs('business.detailSetup.*')) app-wrapper flex-column flex-row-fluid @endif" id="kt_app_wrapper">
             @if(!request()->routeIs('business.setup.*') && !request()->routeIs('business.detailSetup.*'))
                 @include('business.layouts.menu.sidebar')
             @endif
             <!--begin::Main-->
             <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                 <!--begin::Content wrapper-->
                 <div class="d-flex flex-column flex-column-fluid">
                     <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                         @if(!request()->routeIs('business.setup.*') && !request()->routeIs('business.detailSetup.*'))
                             <!--begin::Toolbar-->
                                 <!--begin::Toolbar container-->
                                 <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                                     <!--begin::Page title-->
                                     <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                         <!--begin::Title-->
                                         <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">@yield('title')</h1>
                                         <!--end::Title-->
                                         <!--begin::Breadcrumb-->
                                         <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                             <!--begin::Item-->
                                             <li class="breadcrumb-item text-muted">
                                                 <a href="{{route('business.home')}}" class="text-muted text-hover-primary"><i class="fa fa-home"></i></a>
                                             </li>
                                             <!--end::Item-->
                                             <!--begin::Item-->
                                             <li class="breadcrumb-item">
                                                 <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
                                             <!--end::Item-->
                                             @yield('breadcrumbs')
                                         </ul>
                                         <!--end::Breadcrumb-->
                                     </div>
                                     <!--end::Page title-->
                                     <!--begin::Actions-->
                                     <div class="d-flex align-items-center gap-2 gap-lg-3">

                                         <a href="#" class="btn fw-bold btn-primary d-flex align-items-center">
                                             Salona Git
                                             <span class="svg-icon svg-icon-muted svg-icon-1 ms-3">
                                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z" fill="currentColor"/>
                                            <path opacity="0.3" d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z" fill="currentColor"/>
                                            <path opacity="0.3" d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z" fill="currentColor"/>
                                            <path opacity="0.3" d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z" fill="currentColor"/>
                                            <path opacity="0.3" d="M14 4H10V10H14V4Z" fill="currentColor"/>
                                            <path opacity="0.3" d="M17 4H20L22 10H18L17 4Z" fill="currentColor"/>
                                            <path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="currentColor"/>
                                            <path d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z" fill="currentColor"/>
                                            </svg>
                                         </span>
                                             <!--end::Svg Icon-->
                                         </a>
                                         <!--end::Primary button-->

                                     </div>
                                     <!--end::Actions-->
                                 </div>
                                 <!--end::Toolbar container-->
                             <!--end::Toolbar-->
                         @endif
                     </div>
                     <div id="kt_app_content" class="app-content flex-column-fluid">
                         <!--begin::Content container-->
                         <div id="kt_app_content_container" class="app-container container-fluid">

