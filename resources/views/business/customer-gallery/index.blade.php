@extends('business.layouts.master')
@section('title', 'Müşteri Galerisi')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.customer-gallery.index')}}"> Müşteri Galerisi </a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content">
        <div class="card">
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title">
                    <div class="d-flex align-items-center flex-column mt-3 w-300px">
                        Müşterilerinizin Fotoğrafları
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($galleries as $gallery)
                        <!--begin::item-->
                        <a class="d-block overlay col-3 mb-5" href="javascript:void(0)">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-300px object-fit-cover"
                                 style="background-image:url('{{image($gallery->image)}}')">
                            </div>
                            <!--end::Image-->

                            <!--begin::Action-->
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                <i class="bi bi-eye-fill text-white fs-3x"></i>
                            </div>
                            <!--end::Action-->
                            <button class="btn btn-danger position-absolute w-50px h-50px delete-gallery" data-id="{{$gallery->id}}" style="top: 10px;right: 20px"><i class="fa fa-trash"></i></button>

                        </a>
                        <!--end::item-->
                    @empty
                        @include('business.layouts.components.alerts.empty-alert')
                    @endforelse
                </div>
            </div>
        </div>
        @include('business.gallery.modals.add-photo')


    </div>
@endsection
@section('scripts')

        <script src="/business/assets/js/project/fslightbox/fslightbox.bundle.js"></script>
        <script>
            $(document).ready(function() {
                // Silme butonuna tıkladığınızda oluşan olayın yayılmasını durdur
                $('.delete-gallery').on('click', function(event) {

                    let galleryID = $(this).data('id');

                    $.ajax({
                        url: '/isletme/customer-gallery/'+galleryID,
                        type: "POST",
                        data: {
                            "_token": csrf_token,
                            "_method": 'DELETE',
                        },
                        dataType: "JSON",
                        success: function (res) {
                            Swal.fire({
                                title: "Kayıt Silindi!",
                                icon: res.status,
                                text: res.message,
                                confirmButtonText: 'Tamam'
                            })
                            location.reload();
                        }
                    });
                });
            });
        </script>
@endsection
