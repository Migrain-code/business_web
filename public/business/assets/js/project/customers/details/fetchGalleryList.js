//Galeri Kaydet
var customerId = $('#gallleryTab').data('customer');
var myDropzone = new Dropzone("#drop_zone_area", {
    url: '/isletme/customer/' + customerId + '/add-gallery', // Set the url for your upload script location
    paramName: "image", // The name that will be used to transfer the file
    maxFiles: 5,
    maxFilesize: 3, // MB
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': csrf_token // CSRF token'ini ekleyin
    },
    accept: function(file, done) {
            done();
            Swal.fire({
               icon: 'success',
               text: 'Fotoğraf Kayıt Edildi',
               confirmButtonText: 'Tamam',
            });

    }
});
//Kaydet Sonrası Yeniden Yükle
$('#kt_modal_add_gallery').on('hidden.bs.modal', function (e) {
    // Dropzone'ı temizle
    myDropzone.removeAllFiles(true);
    fetchGallery();
});
// Fetch
$('.gallery').on('click', function () {
    fetchGallery();
});
//Galeri Liste
function fetchGallery(){
    $.ajax({
        url: '/isletme/customer/' + customerId + '/gallery',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let container = document.getElementById('kt_ecommerce_customer_gallery_container');
            container.innerHTML="";
            var items = "";
            $.each(response, function (index, item) {
                var item = `
                <!--begin::Col-->
                <div class="col-md-4" style="position: relative">
                    <!--begin::Img-->
                    <a href="${item.image}" target="_blank">
                        <img src="/business/assets/media/stock/600x600/img-33.jpg" class="rounded w-100" alt="">
                    </a>
                    <a class="btn btn-danger btn-sm me-1 position-absolute delete-btn-gallery" style="
                        right: 20px;
                        top: 10px;
                        height: 40px;
                        padding-left: 13px;
                        width: 40px;
                        border-radius: 2.1rem;
                        display: flex;
                        align-items: center;"
                        href="#" data-toggle="popover"
                        data-object-id="${this.id}"
                        data-model="App\\Models\\CustomerGallery"
                        data-reload="true"
                        data-content="Görseli Silmek İstediğinize Eminmisiniz? Kayıt Müşteridende Silinecektir"
                        data-title="Müşteri Galeri">
                        <i class="fa fa-trash"></i>
                    </a>
                    <!--end::Img-->
                </div>
                <!--end::Col-->
               `;
                items += item;

            });
            document.getElementById('totalPayment').innerHTML = response.length;
            container.innerHTML = items;
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                html: 'Sistemsel Bir Hata Sebebiyle Borç Listesi Alınamadı',
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    });
}
//Galeri Silme
$(document).on('click', '.delete-btn-gallery', function () {
    let model = $(this).data('model')
    let content = $(this).data('content')
    let title = $(this).data('title')
    let id = $(this).data('object-id')

    Swal.fire({
        title: 'İşlemi Yapmak İstiyormusun',
        text: content,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Hayır, İptal Et",
        confirmButtonText: "Evet, Sil!",
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/isletme/ajax/delete/object',
                type: "POST",
                data: {
                    "_token": csrf_token,
                    "_method": 'DELETE',
                    'id': id,
                    'model': model,
                    'content': content,
                    'title': title
                },
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        title: "Kayıt Silindi!",
                        icon: res.status,
                        text: res.message,
                        confirmButtonText: 'Tamam'
                    })
                    fetchGallery();
                }
            });
        }
    });

});
