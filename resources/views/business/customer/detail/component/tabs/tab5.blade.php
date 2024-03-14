<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_notifications" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Bildirimler</h2>
            </div>
            <!--end::Card title-->
            <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_notification">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    Bildirim Gönder
                </a>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="kt_ecommerce_customer_comments" class="card-body pt-0 pb-5">
            <!--begin::Addresses-->
            @forelse($customer->notifications as $notification)
                <!--begin::Address Item-->
                <div class="py-0">
                    <!--begin::Header-->
                    <div class="py-3 d-flex flex-stack flex-wrap">
                        <!--begin::Toggle-->
                        <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_ecommerce_customer_notification_{{$notification->id}}" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_1">
                            <!--begin::Arrow-->
                            <div class="me-3 rotate-90">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor" />
                                </svg>
                            </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Arrow-->
                            <!--begin::Summary-->
                            <div class="me-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">{{$notification->title}}</div>
                                    @if($notification->status == 1)
                                        <div class="badge badge-light-success ms-5">Görüntülendi</div>
                                    @else
                                        <div class="badge badge-light-danger ms-5">Görüntülenmedi</div>
                                    @endif
                                </div>
                                <div class="text-muted">{{$notification->created_at->format('d.m.Y H:i:s')}}</div>
                            </div>
                            <!--end::Summary-->
                        </div>
                        <!--end::Toggle-->
                        <!--begin::Toolbar-->
                        <div class="d-flex my-3 ms-9 align-items-center">
                            <!--begin::Delete-->
                            {!! create_form_delete_button('CustomerNotificationMobile', $notification->id, 'Bildirim', 'Bildirimi Silmek İstediğinize Eminmisiniz?') !!}
                            <!--end::Delete-->

                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div id="kt_ecommerce_customer_notification_{{$notification->id}}" class="collapse fs-6 ps-9" data-bs-parent="#kt_ecommerce_customer_addresses">
                        <!--begin::Details-->
                        <div class="d-flex flex-column pb-5">

                            <div class="text-muted">
                                {!! $notification->content !!}
                            </div>
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Address Item-->
            @empty
                @include('layouts.components.alerts.empty-alert')
            @endforelse


            <!--end::Addresses-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</div>
<!--end:::Tab pane-->
