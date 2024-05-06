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
                                         <a href="#" class="btn fw-bold btn-primary d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Salona Git">
                                             <span id="goSalon">Salona Git</span>

                                               <i class="ki-duotone ki-home-1 fs-2 ms-3">
                                                     <span class="path1"></span>
                                                     <span class="path2"></span>
                                               </i>
                                             <!--end::Svg Icon-->
                                         </a>
                                         <!--end::Primary button-->
                                         @yield('toolbar')
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

