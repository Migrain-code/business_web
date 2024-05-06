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
        width: 5px;
    }
    ::-webkit-scrollbar-thumb{
        background: #0095e8;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-track{
        background: #1e1e2d;
    }
    .scroll-x{
        overflow-y: hidden;
    }
    .scroll-x::-webkit-scrollbar {
        width: 5px; /* Scrollbar genişliği */
        height: 5px;
    }
    .hover-scroll-x::-webkit-scrollbar {
        width: 5px; /* Scrollbar genişliği */
        height: 5px;
    }
    .scroll-y::-webkit-scrollbar {
        width: 5px; /* Scrollbar genişliği */
        height: 5px;
    }
    .scroll-y::-webkit-scrollbar-track {
        background: #1e1e2d;
    }
    @media (max-width: 876px) {
        .form-check-input.delete {
            display: none;
        }
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control, table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control {
            position: relative;
            padding-left: 0px;
            cursor: pointer;
        }
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before, table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before{
            height: 1.70rem !important;
            width: 1.70rem !important;
        }
    }
</style>
<!--end::Global Stylesheets Bundle-->
@yield('styles')
