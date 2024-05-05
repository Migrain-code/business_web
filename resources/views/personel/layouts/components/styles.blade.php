<link rel="shortcut icon" href="{{image(setting('speed_favicon'))}}">

<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="/business/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<link href="/business/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="/business/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="/business/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
<link href="/business/assets/css/custom.css" rel="stylesheet" type="text/css" />
<style>
    ::-webkit-scrollbar{
        width: 10px;
    }
    ::-webkit-scrollbar-thumb{
        background: #0095e8;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-track{
        background: #1e1e2d;
    }
</style>
<!--end::Global Stylesheets Bundle-->
@yield('styles')
