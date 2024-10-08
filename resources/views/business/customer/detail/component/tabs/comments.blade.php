<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_comments" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        @can('customer.comment.show')
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Yorumlar</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="kt_ecommerce_customer_comments" class="card-body pt-0 pb-5">
            <!--begin::Addresses-->
            @forelse($customer->comments as $comment)
                <!--begin::Address Item-->
                <div class="py-0">
                    <!--begin::Header-->
                    <div class="py-3 d-flex flex-stack flex-wrap">
                        <!--begin::Toggle-->
                        <div class="d-flex align-items-center collapsible collapsed rotate" data-bs-toggle="collapse" href="#kt_ecommerce_customer_addresses_{{$comment->id}}" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_1">
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
                                    <div class="fs-4 fw-bold">{{$comment->business->name}}</div>
                                    @if($comment->status == 1)
                                        <div class="badge badge-light-success ms-5">Yayında</div>
                                    @else
                                        <div class="badge badge-light-danger ms-5">Yayında Değil</div>
                                    @endif
                                </div>
                                <div class="text-muted">{{$comment->created_at->format('d.m.Y H:i:s')}}</div>
                            </div>
                            <!--end::Summary-->
                        </div>
                        <!--end::Toggle-->
                        <!--begin::Toolbar-->
                        <div class="d-flex my-3 ms-9 align-items-center">
                            <!--begin::Delete-->
                            {!! create_form_delete_button('BusinessComment', $comment->id, 'Yorum', 'Yorumu Silmek İstediğinize Eminmisiniz?') !!}
                            <!--end::Delete-->
                            <!--begin::More-->
                            {!! create_switch($comment->id,$comment->status == 1 ? true : false, 'BusinessComment', 'status') !!}

                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div id="kt_ecommerce_customer_addresses_{{$comment->id}}" class="collapse fs-6 ps-9" data-bs-parent="#kt_ecommerce_customer_addresses">
                        <!--begin::Details-->
                        <div class="d-flex flex-column pb-5">

                            <div class="text-muted">
                                {!! $comment->content !!}
                            </div>
                        </div>
                        <!--end::Details-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Address Item-->
            @empty
                @include('business.layouts.components.alerts.empty-alert')
            @endforelse


            <!--end::Addresses-->
        </div>
        <!--end::Card body-->
        @else
            <div class="card-body">
                <x-forbidden-component title="Yetkisiz Erişim" message="Müşteri Yorumlarını Görüntülemek için yetkiniz bulunmamaktadır"></x-forbidden-component>
            </div>
        @endcan
    </div>
    <!--end::Card-->

</div>
<!--end:::Tab pane-->
