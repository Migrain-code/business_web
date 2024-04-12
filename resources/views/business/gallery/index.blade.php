@extends('business.layouts.master')
@section('title', 'İşletme Galerisi')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.gallery.index')}}"> İşletme Galerisi </a>
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
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-50 w-100 mt-auto mb-2">
                            <span>{{$galleries->count()}} Görsel Yüklendi {{number_format($usedMegabytes, 2). " mb."}}</span>
                            <span>{{$percentageUsed}}%</span>
                        </div>

                        <div class="h-8px mx-3 w-100 bg-light-danger rounded">
                            <div class="bg-danger rounded h-8px" role="progressbar" style="width: {{$percentageUsed}}%;" aria-valuenow="{{$percentageUsed}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <!--end::Card title-->
                <div class="card-toolbar d-flex">
                    <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_gallery">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                        <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                            <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                            <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                        </svg>
                    </span>
                        <!--end::Svg Icon-->
                        Yeni Görsel
                    </a>

                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($galleries as $gallery)
                        <!--begin::item-->
                        <a class="d-block overlay col-3 mb-5" href="javascript:void(0)">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-300px object-fit-cover"
                                 style="background-image:url('{{image($gallery->way)}}')">
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

        <script>
            var myDropzone = new Dropzone("#drop_zone_area", {
                url: '/isletme/gallery', // Set the url for your upload script location
                paramName: "image", // The name that will be used to transfer the file
                maxFiles: 5,
                maxFilesize: 3, // MB
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': csrf_token // CSRF token'ini ekleyin
                },
                success: function(file, response) {
                    // API'den dönen yanıtı işle
                    console.log(response);
                    Swal.fire({
                        icon: response.status,
                        title: response.message,
                        confirmButtonText: 'Tamam',
                    });
                },
            });
            //Kaydet Sonrası Yeniden Yükle
            $('#kt_modal_add_gallery').on('hidden.bs.modal', function (e) {
                // Dropzone'ı temizle
                myDropzone.removeAllFiles(true);
                location.reload();
            });
        </script>
        <script>
            $(document).ready(function() {
                // Silme butonuna tıkladığınızda oluşan olayın yayılmasını durdur
                $('.delete-gallery').on('click', function(event) {

                    let galleryID = $(this).data('id');

                    $.ajax({
                        url: '/isletme/gallery/'+galleryID,
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
