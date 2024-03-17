//Borç Liste

$('.payments').on('click', function () {

    var packageId = $(this).data('package');

    $.ajax({
        url: '/isletme/package-sale/' + packageId + '/payments',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let container = document.getElementById('paymentTable');
            container.innerHTML="";
            var items = "";
            $.each(response, function (index, item) {
                var item = `
                    <tr>
                            <td class="fs-6">${item.created_at}</td>
                            <td class="fs-6">${item.price}₺</td>
                            <td class="fw-bold">${item.amount}</td>
                            <td class="min-w-125px">

                                <a class="btn btn-danger btn-sm me-1 payment-delete-btn" href="#" data-toggle="popover" data-object-id="${item.id}" data-route="/isletme/package-sale/${item.id}/delete-payment" data-model="App\\Models\\PackagePayment" data-content="Paket Satışının Ödeme Kaydını Silmek İstediğinize Eminmisiniz?" data-title="Paket Ödemesi"><i class="fa fa-trash"></i></a>
                            </td>
                     </tr>
               `;
                items += item;
            });
            container.innerHTML= items;
            //initPaymentTable();

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
});

var datatablePayment;

function initPaymentTable() {
    const reportTitle = "Paket Satışı Ödemeleri";
    // DataTables zaten başlatılmışsa, yeni bir örneği başlatma
    if (!$.fn.DataTable.isDataTable(datatablePayment)) {
        datatablePayment = $('#paymentDataTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.2/i18n/tr.json"
            },
            responsive: true,
            "info": false,
            'order': [0],
            dom: 'Bfrtip',
            buttons: [
                {extend: "copyHtml5", title: reportTitle},
                {extend: "excelHtml5", title: reportTitle},
                {extend: "csvHtml5", title: reportTitle},
                {extend: "pdfHtml5", title: reportTitle}
            ]
        });

        // Düğmelerin eklenmesi
        new $.fn.dataTable.Buttons('#paymentDataTable', {
            buttons: [
                {extend: "copyHtml5", title: reportTitle},
                {extend: "excelHtml5", title: reportTitle},
                {extend: "csvHtml5", title: reportTitle},
                {extend: "pdfHtml5", title: reportTitle}
            ]
        }).container().appendTo($("#kt_ecommerce_report_customer_payment_export"));
    }

    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
    datatablePayment.on('draw', function () {

        setTimeout(() => {
            $('.dataTables_filter').css('display', 'none');
            $('.dt-buttons').css('display', 'none');
        }, 1);
    });

    document.querySelectorAll("#kt_ecommerce_report_customer_orders_export_menu_payment [data-kt-ecommerce-export-payment]").forEach(buttonPayment => {
        buttonPayment.addEventListener("click", event => {
            event.preventDefault();
            const exportTypePayment = event.target.getAttribute("data-kt-ecommerce-export-payment");
            if (exportTypePayment === "print") {
                printPayment();
            } else {
                setTimeout(() => {
                    let btnContainer = document.getElementById('kt_ecommerce_report_customer_payment_export');
                    const exportButton = btnContainer.querySelector(".dt-buttons .buttons-" + exportTypePayment);
                    if (exportButton) {
                        exportButton.click();
                    } else {
                        console.error(`Export button for ${exportTypePayment} not found.`);
                    }
                }, 0);
            }

        });
    });
}
$(document).ready(function (){
   initPaymentTable();
});
$('select[name="listTypePayment"]').on('change', function () {
    var selectedValue = $(this).val();
    var startDate, endDate;

    // Seçilen değere göre tarih aralığını belirle
    switch (selectedValue) {
        case 'thisWeek':
            startDate = moment().startOf('week').format('YYYY-MM-DD');
            endDate = moment().endOf('week').format('YYYY-MM-DD');
            break;
        case 'thisMonth':
            startDate = moment().startOf('month').format('YYYY-MM-DD');
            endDate = moment().endOf('month').format('YYYY-MM-DD');
            break;
        case 'thisYear':
            startDate = moment().startOf('year').format('YYYY-MM-DD');
            endDate = moment().endOf('year').format('YYYY-MM-DD');
            break;
        case 'all':
            // Bu yıldan 1 önceki yılı al
            startDate = moment().subtract(1, 'years').startOf('year').format('YYYY-MM-DD');
            // Bugüne kadar olan tüm tarihler
            endDate = moment().endOf('year').format('YYYY-MM-DD');
            break;
    }

    datatablePayment.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.nodes().to$().show();
    });
    // Tarih aralığına göre filtrele
    datatablePayment.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var date = moment(data[0], 'DD.MM.YYYY HH:mm'); // İlk sütunun tarihini al ve formatına göre dönüştür
        if (!date.isBetween(startDate, endDate)) {
            this.nodes().to$().hide(); // Eğer tarih aralığı dışındaysa, satırı gizle
        }
    });

    // Tabloyu yeniden çiz
    datatablePayment.draw();
});

var printWindowPayment;

function printPayment() {
    // Eğer zaten bir yazdırma penceresi açıksa, işlemi iptal edin
    if (printWindowPayment && !printWindowPayment.closed) {
        console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
        return;
    }

    var tableElementPayment = document.getElementById('paymentDataTable');

    // Yazdırma penceresini aç
    printWindowPayment = window.open('', '_blank');
    printWindowPayment.document.write('<html><head><title>Ödemeleri</title>');

    // Orijinal sayfanızda tanımlanan CSS stillerini yazdırma penceresine ekleyin
    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        if (link.rel === "stylesheet") {
            printWindowPayment.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
        }
    }

    printWindowPayment.document.write('</head><body style="padding-left: 20px">');
    printWindowPayment.document.write(tableElementPayment.outerHTML);
    printWindowPayment.document.write('</body></html>');
    printWindowPayment.document.close();

    // Yeni pencerede yazdırma penceresini aç
    setTimeout(function (){
        printWindowPayment.print();
    }, 1000);
}
