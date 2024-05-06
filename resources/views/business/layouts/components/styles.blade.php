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
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6639124b07f59932ab3ca2f7/1ht7eutps';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
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
        #goSalon{
            display: none;
        }
    }
</style>
<!--end::Global Stylesheets Bundle-->
@yield('styles')
