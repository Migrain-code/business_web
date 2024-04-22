@extends('business.layouts.master')
@section('title', 'İşletme Kurulumu 1. Adım')
@section('styles')
    <style>
        #kt_forms_widget_1_editor {
            height: 200px; /* Yüksekliği 200 piksel olarak ayarla */
        }

          #searchInput{
              position: absolute;
              left: 177px;
              top: 8px !important;
              width: 67%;
              height: 40px;
              border-radius: 15px;
              padding: 5px;
              border: 1px solid #600ee4;
              outline: 0px;
          }

    </style>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10" id="kt_create_account_stepper">
            @include('business.setup.parts.aside')

            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                <!--begin::Form-->
                <form class="card-body py-20 w-100 px-9" novalidate="novalidate" id="kt_create_account_form">
                    @include('business.setup.parts.step-1')
                    @include('business.setup.parts.step-2')
                    @include('business.setup.parts.step-3')
                    @include('business.setup.parts.package')
                    @include('business.setup.parts.step-4')
                    @include('business.setup.parts.step-5')
                    <!--begin::Actions-->
                    <div class="d-flex flex-stack pt-10">
                        <!--begin::Wrapper-->
                        <div class="mr-2">
                            <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                <i class="ki-duotone ki-arrow-left fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>                        Back
                            </button>
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Wrapper-->
                        <div>
                            <button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
                        <span class="indicator-label">
                            Submit
                            <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0"><span class="path1"></span><span class="path2"></span></i>                        </span>
                                <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                            </button>

                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                Continue
                                <i class="ki-duotone ki-arrow-right fs-4 ms-1 me-0"><span class="path1"></span><span class="path2"></span></i>                    </button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        var quill = new Quill('#kt_forms_widget_1_editor', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, 4, 5, 6, false] }], // Başlık seçenekleri
                    ['bold', 'italic', 'underline', 'strike'], // Vurgulama, italik, alt çizgi, çizgi üstü
                    ['blockquote'], // Alıntı, kod bloğu
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Numaralı liste, madde işaretli liste
                    [{ 'script': 'sub'}, { 'script': 'super' }], // Alt simge, üst simge
                    [{ 'indent': '-1'}, { 'indent': '+1' }], // Sola doğru girinti, sağa doğru girinti
                    [{ 'direction': 'rtl' }], // Sağdan sola yazım
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Küçük, normal, büyük, çok büyük
                    [{ 'color': [] }, { 'background': [] }], // Yazı rengi, arka plan rengi
                    [{ 'font': ['Arial', 'Times New Roman', 'Courier New', 'Georgia', 'Verdana', 'Inter', 'Helvatica']}], // Font ailesi
                    [{ 'align': [] }], // Hizalama
                    ['clean'], // Temizleme
                    ['image']
                ]
            },
            height:200,
            placeholder: 'İşletmenizin tanıtım sayfasında görüntülenecek olan hakkımızda metnidir',
            theme: 'snow'
        });

    </script>

    <script src="/business/assets/js/project/setup/create-account.js"></script>
    <script src="/business/assets/js/custom.js"></script>
    <script>
        $(".timeSelector").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcMXrk2ldIslFsanG5wUm5EuuTjkLfl8U&libraries=places&callback=initAutocomplete" async defer></script>
    <script>
        let map;
        let marker = null;

        function initAutocomplete() {
            // Harita başlatma kodu burada
            var businessLat = '{{$business->lat ?? "49.610307094885016"}}';
            var businessLong = '{{$business->longitude ?? "6.132590619068177"}}';
            if (isNaN(businessLat) || isNaN(businessLong)) {
                businessLat = 49.610307094885016; // Varsayılan enlem
                businessLong = 6.132590619068177; // Varsayılan boylam
            }
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: parseFloat(businessLat), lng: parseFloat(businessLong) },
                zoom: 12,
                mapTypeId: "roadmap",
            });

            // Harita üzerine tıklama olayı
            google.maps.event.addListener(map, 'click', function(event) {
                if (marker !== null) {
                    marker.setMap(null);
                }

                var latitude = event.latLng.lat();
                var longitude = event.latLng.lng();

                addEmbed(latitude, longitude);

                reverseGeocode(latitude, longitude);

                marker = new google.maps.Marker({
                    position: { lat: latitude, lng: longitude },
                    map: map,
                    title: 'Selected Location'
                });

                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
                console.log('tıklanan lat '+ latitude +" tıklanan long : "+ longitude)
            });

            // Sayfa yüklendiğinde işletme konumu veya varsayılan konumu göster
            $(function () {
                marker = new google.maps.Marker({
                    position: { lat: parseFloat(businessLat), lng: parseFloat(businessLong) },
                    map: map,
                    title: 'Selected Location'
                });
            });

            // Adres arama işlevselliği
            const input = document.getElementById("searchInput");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                if (marker !== null) {
                    marker.setMap(null);
                }

                const bounds = new google.maps.LatLngBounds();

                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    const latitude = place.geometry.location.lat();
                    const longitude = place.geometry.location.lng();

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                    console.log('tıklanan lat '+ latitude +" tıklanan long : "+ longitude)

                    reverseGeocode(latitude, longitude);
                    marker = new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });

                map.fitBounds(bounds);
            });
        }
        function addEmbed(latitude,longitude){
            var embedUrl = `https://www.google.com/maps/embed/v1/place?q=${latitude},${longitude}&key=AIzaSyBcMXrk2ldIslFsanG5wUm5EuuTjkLfl8U`;
            var embed = `<iframe width="350" height="350" frameborder="0" style="border:0;border-radius: 15px"
                    src="${embedUrl}" allowfullscreen></iframe>`
            $('#embed').text(embed);

        }
        function reverseGeocode(latitude, longitude) {
            var geocodingUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyBcMXrk2ldIslFsanG5wUm5EuuTjkLfl8U`;

            fetch(geocodingUrl)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.status === "OK") {
                        var selectedAddress = data.results[0].formatted_address;
                        $('#address').text(selectedAddress);
                    } else {
                        console.log("Adres alınamadı.");
                    }
                })
                .catch(error => {
                    console.log("Hata Adres Alınamadı");
                });
        }

        // Enter tuşunu engelleme işlemi
        document.getElementById("searchInput").addEventListener("keydown", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });

    </script>
    <!-- Swiper CSS -->

@endsection
