@extends('business.layouts.master')
@section('title', 'Personel Düzenle')
@section('styles')
    <style>
        .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.personel.index')}}"> Personeller </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.personel.index', $personel->id)}}"> Personel Detayı </a>
    </li>

    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Personel Ödemeleri
    </li>
@endsection
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content ">
        @include('business.personel.edit.nav')
        <!--begin::Row-->
        <div class="col-xl-12" id="printTable">

            <!--begin::Table Widget 7-->
            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Bildirimler</span>

                        <span class="text-muted mt-1 fw-semibold fs-7">Personele gönderilmiş {{$personel->notifications->count()}} bildirm bulunuyor</span>
                    </h3>
                    <div class="card-toolbar">
                        <ul class="nav" role="tablist">
                            <li class="nav-item" id="printButton">
                                <a href="javascript:void(0)" class="btn btn-sm btn-color-muted btn-active btn-active-light-success fw-bold px-4 active me-2" id="sendNotify" data-bs-toggle="modal" title="Bildirim Gönder" data-bs-target="#kt_modal_add_notification">
                                    <i class="fa fa-plus me-2"></i> Bildirim Gönder
                                </a>
                            </li>
                            <li class="nav-item" id="printButton">
                                <a href="javascript:void(0)" onclick="printCase()" class="btn btn-sm btn-color-muted btn-active btn-active-light-success fw-bold px-4 active me-2" data-bs-toggle="tooltip" title="Geçerli Sekmeyi Yazdır">
                                    <i class="fa fa-print"></i>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bold px-4 active" data-bs-toggle="tab" href="#kt_table_widget_7_tab_this_day" aria-selected="true" tabindex="-1" role="tab">Bu gün</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bold px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_this_week" aria-selected="false" tabindex="-1" role="tab">Bu Hafta</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bold px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_this_month" aria-selected="false" role="tab">Bu Ay</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bold px-4" data-bs-toggle="tab" href="#kt_table_widget_7_this_year" aria-selected="false" tabindex="-1" role="tab">Bu Yıl</a>
                            </li>


                        </ul>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
                    <div class="tab-content">

                        <!--begin::Tap pane-->
                        <div class="tab-pane fade show active" id="kt_table_widget_7_tab_this_day" role="tabpanel">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr>
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-120px"></th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->

                                    <!--begin::Table body-->
                                    <tbody>
                                       @forelse($dayNotifications as $notification)
                                           <tr>
                                               <td>
                                                   <div class="symbol symbol-50px me-2">
                                                        <span class="symbol-label bg-light-success">
                                                            <i class="ki-duotone ki-scroll fs-2x text-success">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                   </div>
                                               </td>
                                               <td>
                                                   <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$notification->title}}</a>
                                                   <span class="text-muted fw-semibold d-block fs-7">{{$notification->message}}</span>
                                               </td>
                                               <td class="text-end">
                                                   <span class="text-muted fw-semibold d-block fs-8">{{$notification->created_at->format('d.m.Y H:i:s')}}</span>

                                                   <span class="text-dark fw-bold d-block fs-7">{{$notification->created_at->diffForHumans()}}</span>
                                               </td>
                                               <td class="text-end">
                                                   <span class="badge badge-light-success fs-7 fw-bold">Gönderildi</span>
                                               </td>
                                               <td class="text-end">
                                                   <a class="btn btn-clean btn-sm btn-icon btn-icon-danger btn-active-light-danger ms-auto delete-btn" href="#" data-toggle="popover"
                                                      data-object-id="{{$notification->id}}" data-route="/isletme/ajax/delete/object"
                                                      data-model="App\Models\PersonelNotification"
                                                      data-delete-type="1"
                                                      data-reload="true"
                                                      data-content="Personel Bildirim Kaydını Silmek İstediğinize Eminmisiniz?"
                                                      data-title="Personel Bildirim">
                                                       <i class="ki-duotone ki-trash fs-1">
                                                           <span class="path1"></span>
                                                           <span class="path2"></span>
                                                           <span class="path3"></span>
                                                           <span class="path4"></span>
                                                           <span class="path5"></span>
                                                       </i>
                                                   </a>
                                               </td>
                                           </tr>
                                       @empty
                                           <div id="kt_schedule_day_0" class="tab-pane fade show ">
                                               <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">

                                                   <!--begin::Wrapper-->
                                                   <div class="d-flex flex-stack flex-grow-1 justify-content-center">
                                                       <!--begin::Content-->
                                                       <div class=" fw-semibold">
                                                           <div class="fs-6 text-white fw-bold">
                                                               Bugün gönderilmiş bildirim kaydı bulunamadı
                                                           </div>
                                                       </div>
                                                       <!--end::Content-->

                                                   </div>
                                                   <!--end::Wrapper-->
                                               </div>
                                           </div>
                                       @endforelse

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Tap pane-->

                        <!--begin::Tap pane-->
                        <div class="tab-pane fade " id="kt_table_widget_7_this_week" role="tabpanel">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr>
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-120px"></th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->

                                    <!--begin::Table body-->
                                    <tbody>
                                    @forelse($weekNotifications as $notification)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-2">
                                                        <span class="symbol-label bg-light-success">
                                                            <i class="ki-duotone ki-scroll fs-2x text-success">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$notification->title}}</a>
                                                <span class="text-muted fw-semibold d-block fs-7">{{$notification->message}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-muted fw-semibold d-block fs-8">{{$notification->created_at->format('d.m.Y H:i:s')}}</span>

                                                <span class="text-dark fw-bold d-block fs-7">{{$notification->created_at->diffForHumans()}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge badge-light-success fs-7 fw-bold">Gönderildi</span>
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-clean btn-sm btn-icon btn-icon-danger btn-active-light-danger ms-auto delete-btn" href="#" data-toggle="popover"
                                                   data-object-id="{{$notification->id}}" data-route="/isletme/ajax/delete/object"
                                                   data-model="App\Models\PersonelNotification"
                                                   data-delete-type="1"
                                                   data-reload="true"
                                                   data-content="Personel Bildirim Kaydını Silmek İstediğinize Eminmisiniz?"
                                                   data-title="Personel Bildirim">
                                                    <i class="ki-duotone ki-trash fs-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <div id="kt_schedule_day_0" class="tab-pane fade show ">
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">

                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 justify-content-center">
                                                    <!--begin::Content-->
                                                    <div class=" fw-semibold">
                                                        <div class="fs-6 text-white fw-bold">
                                                            Bugün gönderilmiş bildirim kaydı bulunamadı
                                                        </div>
                                                    </div>
                                                    <!--end::Content-->

                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                    @endforelse

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Tap pane-->

                        <!--begin::Tap pane-->
                        <div class="tab-pane fade " id="kt_table_widget_7_this_month" role="tabpanel">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr>
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-120px"></th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->

                                    <!--begin::Table body-->
                                    <tbody>
                                    @forelse($monthNotifications as $notification)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-2">
                                                        <span class="symbol-label bg-light-success">
                                                            <i class="ki-duotone ki-scroll fs-2x text-success">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$notification->title}}</a>
                                                <span class="text-muted fw-semibold d-block fs-7">{{$notification->message}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-muted fw-semibold d-block fs-8">{{$notification->created_at->format('d.m.Y H:i:s')}}</span>

                                                <span class="text-dark fw-bold d-block fs-7">{{$notification->created_at->diffForHumans()}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge badge-light-success fs-7 fw-bold">Gönderildi</span>
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-clean btn-sm btn-icon btn-icon-danger btn-active-light-danger ms-auto delete-btn" href="#" data-toggle="popover"
                                                   data-object-id="{{$notification->id}}" data-route="/isletme/ajax/delete/object"
                                                   data-model="App\Models\PersonelNotification"
                                                   data-delete-type="1"
                                                   data-reload="true"
                                                   data-content="Personel Bildirim Kaydını Silmek İstediğinize Eminmisiniz?"
                                                   data-title="Personel Bildirim">
                                                    <i class="ki-duotone ki-trash fs-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <div id="kt_schedule_day_0" class="tab-pane fade show ">
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">

                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 justify-content-center">
                                                    <!--begin::Content-->
                                                    <div class=" fw-semibold">
                                                        <div class="fs-6 text-white fw-bold">
                                                            Bugün gönderilmiş bildirim kaydı bulunamadı
                                                        </div>
                                                    </div>
                                                    <!--end::Content-->

                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                    @endforelse

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Tap pane-->

                        <!--begin::Tap pane-->
                        <div class="tab-pane fade " id="kt_table_widget_7_this_year" role="tabpanel">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr>
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-120px"></th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->

                                    <!--begin::Table body-->
                                    <tbody>
                                    @forelse($yearNotifications as $notification)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px me-2">
                                                        <span class="symbol-label bg-light-success">
                                                            <i class="ki-duotone ki-scroll fs-2x text-success">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{$notification->title}}</a>
                                                <span class="text-muted fw-semibold d-block fs-7">{{$notification->message}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-muted fw-semibold d-block fs-8">{{$notification->created_at->format('d.m.Y H:i:s')}}</span>

                                                <span class="text-dark fw-bold d-block fs-7">{{$notification->created_at->diffForHumans()}}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="badge badge-light-success fs-7 fw-bold">Gönderildi</span>
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-clean btn-sm btn-icon btn-icon-danger btn-active-light-danger ms-auto delete-btn" href="#" data-toggle="popover"
                                                   data-object-id="{{$notification->id}}" data-route="/isletme/ajax/delete/object"
                                                   data-model="App\Models\PersonelNotification"
                                                   data-delete-type="1"
                                                   data-reload="true"
                                                   data-content="Personel Bildirim Kaydını Silmek İstediğinize Eminmisiniz?"
                                                   data-title="Personel Bildirim">
                                                    <i class="ki-duotone ki-trash fs-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <div id="kt_schedule_day_0" class="tab-pane fade show ">
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">

                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 justify-content-center">
                                                    <!--begin::Content-->
                                                    <div class=" fw-semibold">
                                                        <div class="fs-6 text-white fw-bold">
                                                            Bugün gönderilmiş bildirim kaydı bulunamadı
                                                        </div>
                                                    </div>
                                                    <!--end::Content-->

                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                        </div>
                                    @endforelse

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Tap pane-->
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tables Widget 7-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Content-->
    @include('business.personel.edit.notification.add-modal')
@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script>
        var personelName = "{{$personel->name}}";
        var personelId = "{{$personel->id}}";
    </script>
    <script src="/business/assets/js/project/personels/edit/notification/print.js"></script>
    <script src="/business/assets/js/project/personels/edit/notification/add.js"></script>

@endsection
