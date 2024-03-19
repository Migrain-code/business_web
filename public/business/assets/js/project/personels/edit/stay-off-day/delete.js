$(document).on('click', '.off-day-delete-btn', function () {
    let model = $(this).data('model')
    let isReload = $(this).data('reload')
    let route = $(this).data('route')
    let content = $(this).data('content')
    let title = $(this).data('title')
    let id = $(this).data('object-id')
    let delete_type = true;

    if ($(this).data('delete-type')){
        delete_type = $(this).data('delete-type');
    }

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
                url: route,
                type: "POST",
                data: {
                    "_token": csrf_token,
                    "_method": 'DELETE',
                    'id': id,
                    'model': model,
                    'content': content,
                    'title': title,
                    'delete_type': delete_type,
                },
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        title: "Kayıt Silindi!",
                        icon: res.status,
                        text: res.message,
                        confirmButtonText: 'Tamam'
                    })
                    if (isReload){
                        setTimeout(function (){
                            location.reload();
                        }, 700);
                    }
                    if ($('#datatable').length > 0 && $.fn.DataTable.isDataTable('#datatable')) {
                        location.reload();
                    }
                }
            });
        }
    });

});
