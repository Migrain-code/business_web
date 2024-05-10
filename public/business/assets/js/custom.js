$(document).on('click', '.delete-btn', function () {
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
                    if (res.status == "success"){
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
                        else{
                            if ($('#datatable').length > 0 && $.fn.DataTable.isDataTable('#datatable')) {
                                $('#datatable').DataTable().ajax.reload();
                            }
                        }

                    }
                    else {
                        Swal.fire({
                            title: "Uyarı",
                            icon: res.status,
                            text: res.message,
                            confirmButtonText: 'Tamam'
                        })
                    }

                }
            });
        }
    });

});

$(document).on('change', '[name="city_id"]', function () {

    let id = $(this).val();
    var district = $('[name="district_id"]');
    district.empty();
            $.ajax({
                url: '/isletme/ajax/get/district',
                type: "POST",
                data: {
                    "_token": csrf_token,
                    'id': id,
                },
                dataType: "JSON",
                success: function (res) {
                    $.each(res, function (index, item) {
                        district.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
});


$(document).on('click', '[data-kt-customer-table-select="delete_selected"]', function () {

    const allCheckboxes = document.querySelectorAll('tbody .delete[type="checkbox"]');
    let count = 0;
    let model = "";
    let title = "";
    let is_delete = true;// true ise kayıt silinir değilse arşive atılır
    let values = [];
    allCheckboxes.forEach(c => {
        if (c.checked) {
            count++;
            model = c.dataset.model;
            title = c.dataset.title;
            is_delete = c.dataset.delete;
            values.push(c.value);
        }
    });

    Swal.fire({
        title: 'İşlemi Yapmak İstiyormusun',
        text: title + " Silmek İstiyormusunuz. Silinecek kayıt sayısı " + count,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Evet, Sil!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/isletme/ajax/delete/all/object',
                type: "POST",
                data: {
                    "_token": csrf_token,
                    'ids': values,
                    'model': model,
                    'title': title,
                    'is_delete': is_delete,
                },
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        title: "Silindi!",
                        icon: res.status,
                        text: res.message,
                    })
                    if ($.fn.DataTable.isDataTable('#datatable')) {
                        $('#datatable').DataTable().ajax.reload();
                    }
                }
            });
        }
    });

})


$(document).on('change', '.ajax-switch', function () {
    let model = $(this).data('model')
    let column = $(this).data('column')
    let id = $(this).val()
    let value = $(this).is(':checked') ? 1 : 0

    $.ajax({
        url: '/isletme/ajax/update-featured',
        type: "POST",
        data: {
            "_token": csrf_token,
            'id': id,
            'value': value,
            'model': model,
            'column': column,
        },
        success: function (res) {
            Swal.fire({
                icon: res.status,
                text: res.text ? res.text : res.message,
                confirmButtonText: 'Tamam'
            });
        }
    });
})

