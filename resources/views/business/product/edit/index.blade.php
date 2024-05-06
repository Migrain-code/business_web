@extends('business.layouts.master')
@section('title', 'Ürün Düzenle')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.product.index')}}">Ürünler</a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h2>Ürün Bilgilerini Güncelle</h2>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <!--begin::Button-->
                    <a href="{{route('business.sale.index')}}" id="kt_ecommerce_edit_order_cancel" class="btn btn-light me-5">
                        İptal Et
                    </a>
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" onclick="$('#productUpdateForm').submit()" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Ürün Bilgilerini Güncelle
                        </span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--begin::Card body-->
            <div class="card-body pt-15">
               <form method="post" id="productUpdateForm" action="{{route('business.product.update', $product->id)}}">
                   @csrf
                   @method('PUT')
                   <div class="fv-row mb-7">
                       <!--begin::Label-->
                       <label class="required fs-6 fw-semibold mb-2">Ürün Adı</label>
                       <!--end::Label-->
                       <!--begin::Input-->
                       <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$product->name}}" />
                       <!--end::Input-->
                   </div>
                   <!--end::Input group-->
                   <!--begin::Input group-->
                   <div class="fv-row mb-7">
                       <!--begin::Label-->
                       <label class="fs-6 fw-semibold mb-2">
                           <span class="required">Fiyat</span>
                           <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="1 Adet Ürünün Fiyatı"></i>
                       </label>
                       <!--end::Label-->
                       <!--begin::Input-->
                       <input type="number" class="form-control form-control-solid" placeholder="" name="price" value="{{$product->price}}" />
                       <!--end::Input-->
                   </div>
                   <!--end::Input group-->
                   <!--begin::Input group-->
                   <div class="fv-row mb-7">
                       <!--begin::Label-->
                       <label class="fs-6 fw-semibold mb-2">
                           <span class="required">Stok Adedi</span>
                           <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Üründen stoğunuzda kaç adet var"></i>
                       </label>
                       <!--end::Label-->
                       <!--begin::Input-->
                       <input type="number" class="form-control form-control-solid phone" placeholder="" name="amount" value="{{$product->piece}}" />
                       <!--end::Input-->
                   </div>
                   <!--end::Input group-->
                   <!--begin::Input group-->
                   <div class="fv-row mb-7">
                       <!--begin::Label-->
                       <label class="fs-6 fw-semibold mb-2">
                           <span class="required">Barcode</span>
                           <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Şifre Zorunlu"></i>
                       </label>
                       <!--end::Label-->
                       <!--begin::Input-->
                       <input type="text" class="form-control form-control-solid" placeholder="" name="barcode" value="{{$product->barcode}}" />
                       <!--end::Input-->
                   </div>
               </form>

            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

    </div>

@endsection
@section('scripts')
    <script>

    </script>
@endsection
