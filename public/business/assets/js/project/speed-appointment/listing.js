var mySelect = new TomSelect("#customer_select", {
    load: function (query, callback) {
        if (!query.length) return callback(); // Boş sorgular için istek atma
        this.clearOptions();

        $.ajax({
            url: '/isletme/speed-appointment/customer',
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
                callback(); // Hata durumunda boş bir dizi gönder
            }
        });
    },
    create: false,
    highlight: false,
    render: {
        no_results: function (data, escape) {
            return '<div class="no-results">Sonuç bulunamadı.</div>';
        }
    },
    score: function() {
        // Her zaman 1 döner, böylece Tom Select kendi içinde arama yapmaz
        return function() { return 1; };
    }
});


var personelId = null;
$('#personel_select').on('change', function () {
    personelId = $(this).val();
    var serviceSelect = $('#service_select');
    var room_select_area = $('#roomSelectArea');
    var date_select = $('#date_select');
    $.ajax({
        url: '/isletme/speed-appointment/personel/' + personelId + '/services',
        method: 'GET',
        dataType: 'json', // Beklenen veri tipi
        success: function (res) {
            serviceSelect.empty();
            room_select_area.empty();
            date_select.val("");
            $('#clockContainer').empty();
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
                                                    <input class="form-check-input roomCheckBox" type="radio" name="room_id" value="${item.id}"/>
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
            document.getElementById('roomSelectArea').innerHTML = rooms;
        },
        error: function () {
            console.error("Arama sırasında bir hata oluştu.");
        }
    });
});
$('.roomCheckBox').on('change', function (){
    var room_id = $(this).val();
    fetchPersonel(room_id);
})
function fetchPersonel(room_id = null){
    var personelSelect = $('#personel_select');
    $.ajax({
        url: '/isletme/speed-appointment/personel/list',
        method: 'GET',
        data: {
            'room_id' : room_id,
        },
        dataType: 'json', // Beklenen veri tipi
        success: function (res) {
            personelSelect.empty();
            personelSelect.append('<option value="' + 0 + '">Personel Seçiniz</option>');

            $.each(res, function (index, item) {
                personelSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        },
        error: function () {
            console.error("Arama sırasında bir hata oluştu.");
        }
    });
}

$('#date_select').on('change', function (){
    var selectedDate = $(this).val();
    if ($('[name="room_id"]').is(':radio')) {
        roomId = $('[name="room_id"]:checked').val();
    } else {
        roomId = $('[name="room_id"]').val();
    }
    $.ajax({
        url: '/isletme/speed-appointment/personel/' + personelId + '/clocks',
        method: 'GET',
        data: {
            appointment_date : selectedDate,
            room_id : roomId,
        },
        dataType: 'json', // Beklenen veri tipi
        success: function (res) {
            var clocks = "";
            if(res.status == "error"){
                Toast.fire({
                    icon: res.status,
                    title: res.message,

                })
            } else{
                if (res.length > 0){
                    $.each(res, function(index, item){
                        clocks += `
                            <div class="col-lg-2 col-4">
                                <input type="radio" class="btn-check" name="start_time" value="${item.value}"  id="kt_radio_buttons_2_option_${item.value}"/>
                                <label class="btn btn-outline btn-light-success p-4 d-flex align-items-center mb-5" style="border-radius: 15px" for="kt_radio_buttons_2_option_${item.value}">
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-white fw-bold d-block fs-3">${item.saat}</span>
                                 </span>
                                </label>
                            </div>
                        `
                    });
                } else{
                    Swal.fire({
                        text: "Seçilen Tarihte Boş Saat Bulunamadı. Oda Seçimini değiştirip tekrar kontrol edebilirsiniz",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }

            }

            document.getElementById('clockContainer').innerHTML = clocks;
        },
        error: function () {
            console.error("Arama sırasında bir hata oluştu.");
        }
    });
});
