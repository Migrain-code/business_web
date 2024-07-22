var mySelectClose = new TomSelect("#customer_select_close", {
    remoteUrl: '/isletme/speed-appointment/customer',
    remoteSearch: true,
    create: false,
    highlight: false,
    render: {
        no_results: function (data, escape) {
            return '<div class="no-results">Sonuç bulunamadı.</div>';
        }
    },
    load: function (query, callback) {
        if (query.length > 3) {
            $.ajax({
                url: this.settings.remoteUrl,
                method: 'GET',
                data: { name: query },
                dataType: 'json',
                success: function (data) {
                    var results = data.map(function (item) {
                        return {
                            value: item.id,
                            text: item.name + " -> 0" + item.phone,
                        };
                    });
                    callback(results);
                },
                error: function () {
                    console.error("Arama sırasında bir hata oluştu.");
                    callback([]); // Hata durumunda boş bir dizi gönder
                }
            });
        } else {
            callback([]); // Sorgu uzunluğu yeterli değilse boş bir dizi gönder
        }
    }
});


var personelId = null;
$('#personel_select_close').on('change', function () {
    personelId = $(this).val();
    var serviceSelect = $('#service_select_close');
    var room_select_area = $('#roomSelectAreaClose');
    $.ajax({
        url: '/isletme/speed-appointment/personel/' + personelId + '/services',
        method: 'GET',
        dataType: 'json', // Beklenen veri tipi
        success: function (res) {
            serviceSelect.empty();
            room_select_area.empty();
            $.each(res.services, function (index, item) {
                serviceSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
            });
            var rooms = "";
            $.each(res.rooms, function (index, item) {
                rooms+=`<div class="col-lg-6 col-12">
                                        <!--begin::Radio button-->
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5" style="min-width: 200px">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input roomCheckBox" type="radio" name="room_id_close" value="${item.id}"/>
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                        ${item.name}
                                                   </h2>
                                               </div>
                                               <!--end::Info-->
                                           </div>
                                           <!--end::Description-->
                                       </label>
                                       <!--end::Radio button-->
                                   </div>`
            });
            document.getElementById('roomSelectAreaClose').innerHTML = rooms;
        },
        error: function () {
            console.error("Arama sırasında bir hata oluştu.");
        }
    });
});
$('#date_select_close').on('change', function (){
    var selectedDate = $(this).val();
    $.ajax({
        url: '/isletme/speed-appointment/personel/' + personelId + '/clocks',
        method: 'GET',
        data: {
            appointment_date : selectedDate,
        },
        dataType: 'json', // Beklenen veri tipi
        success: function (res) {
            var start_time_select = $('#start_time_select_close');
            var end_time_select = $('#end_time_select_close');
            start_time_select.empty();
            end_time_select.empty();
            $.each(res, function(index, item){
                start_time_select.append('<option value="' + item.value + '">' + item.saat + '</option>');
                end_time_select.append('<option value="' + item.value + '">' + item.saat + '</option>');
            });
        },
        error: function () {
            console.error("Arama sırasında bir hata oluştu.");
        }
    });
});
