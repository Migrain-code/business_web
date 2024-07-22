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
    .pulse-button {
        cursor: pointer;
        position: relative;
        z-index: 1;
    }

    .pulse-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        border-radius: 20px;
        width: 75%;
        height: 30px;
        opacity: 0.6;
        z-index: -1;
        transform: translate(-50%, -50%) scale(1);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: translate(-50%, -50%) scale(1);
            box-shadow: 0 0 0 0 rgba(114, 57, 244, 0.7);
        }
        70% {
            transform: translate(-50%, -50%) scale(1.5);
            box-shadow: 0 0 15px 30px rgba(114, 57, 244, 0);
        }
        100% {
            transform: translate(-50%, -50%) scale(1);
            box-shadow: 0 0 0 0 rgba(114, 57, 244, 0);
        }
    }
</style>
<style>

    ::-webkit-scrollbar{
        width: 5px;
    }
    ::-webkit-scrollbar-thumb{
        background: #56467D !important;
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
    .scroll-x::-webkit-scrollbar-thumb {
        background:#56467D !important;
    }
    .hover-scroll-x::-webkit-scrollbar-thumb {
        background:#56467D !important;
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
        .customMenu{
            display: none;
        }
        .btn.btn-primary{
            padding: 5px 12px !important;
        }
        .btn.btn-danger{
            padding: 5px 12px !important;
        }
        .stepperDisplay{
            display: none !important;
        }
    }
    :root{
        --kt-scrollbar-hover-color: #56467D;
        --kt-scrollbar-color: #56467D;
    }
    .btn.btn-primary {
        color: var(--kt-primary-inverse);
        border-color: #56467D;
        background-color: #56467D;
    }
    .btn.btn-warning {
        color: var(--kt-warning-inverse);
        border-color: #F22969 !important;
        background-color: #F22969 !important;
    }
    .btn-check:checked + .btn.btn-primary, .btn-check:active + .btn.btn-primary, .btn.btn-primary:focus:not(.btn-active), .btn.btn-primary:hover:not(.btn-active), .btn.btn-primary:active:not(.btn-active), .btn.btn-primary.active, .btn.btn-primary.show, .show > .btn.btn-primary {
        color: var(--kt-primary-inverse);
        border-color: #56467D !important;
        background-color: #56467D !important;
    }
    .btn-check:checked + .btn.btn-warning, .btn-check:active + .btn.btn-warning, .btn.btn-warning:focus:not(.btn-active), .btn.btn-warning:hover:not(.btn-active), .btn.btn-warning:active:not(.btn-active), .btn.btn-warning.active, .btn.btn-warning.show, .show > .btn.btn-warning {
        color: var(--kt-warning-inverse);
        border-color: #F22969 !important;
        background-color: #F22969 !important;
    }

    .btn.btn-light-primary {
        color: var(--kt-warning-inverse);
        border-color: #56467D !important;
        background-color: #56467D !important;
    }
    .btn.btn-light-primary i, .btn.btn-light-primary .svg-icon {
        color: var(--kt-warning-inverse);
    }
    .btn-check:checked + .btn.btn-light-primary, .btn-check:active + .btn.btn-light-primary, .btn.btn-light-primary:focus:not(.btn-active), .btn.btn-light-primary:hover:not(.btn-active), .btn.btn-light-primary:active:not(.btn-active), .btn.btn-light-primary.active, .btn.btn-light-primary.show, .show > .btn.btn-light-primary {
        color: var(--kt-primary-inverse);
        border-color: #56467D !important;
        background-color: #56467D !important;
    }
    .btn.btn-light-warning {
        color: var(--kt-warning-inverse);
        border-color: #F22969 !important;
        background-color: #F22969 !important;
    }
    .btn-check:checked + .btn.btn-light-warning, .btn-check:active + .btn.btn-light-warning, .btn.btn-light-warning:focus:not(.btn-active), .btn.btn-light-warning:hover:not(.btn-active), .btn.btn-light-warning:active:not(.btn-active), .btn.btn-light-warning.active, .btn.btn-light-warning.show, .show > .btn.btn-light-warning {
        color: var(--kt-warning-inverse);
        border-color: #F22969 !important;
        background-color: #F22969 !important;
    }
    .btn-check:checked + .btn.btn-active-primary, .btn-check:active + .btn.btn-active-primary, .btn.btn-active-primary:focus:not(.btn-active), .btn.btn-active-primary:hover:not(.btn-active), .btn.btn-active-primary:active:not(.btn-active), .btn.btn-active-primary.active, .btn.btn-active-primary.show, .show > .btn.btn-active-primary {
        color: var(--kt-primary-inverse);
        border-color: #56467D !important;
        background-color: #56467D !important;
    }
</style>
<!--end::Global Stylesheets Bundle-->
@yield('styles')
