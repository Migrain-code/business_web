//Borç Liste

$('.receivable').on('click', function () {

    var customerId = $(this).data('customer');
    $.ajax({
        url: '/isletme/customer/' + customerId + '/receivable-list',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let container = document.getElementById('receivableTable');
            container.innerHTML="";
            var items = "";
            $.each(response.receivables, function (index, item) {
                var item = `
                    <tr>
                            <td class="fs-6">${item.paymentDate}</td>
                            <td class="fs-6">${item.type}</td>
                            <td class="fs-6">${item.price}₺</td>
                            <td class="fw-bold">${item.status}</td>

                     </tr>
               `;
                items += item;
            });

            document.getElementById('totalReceviable').innerHTML = response.total+ "₺"
            container.innerHTML = items;

            initReceivableTable();

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

var datatableReceivable;

function initReceivableTable() {
    const reportTitle = "Salon Borç Raporu";
    // DataTables zaten başlatılmışsa, yeni bir örneği başlatma
    if (!$.fn.DataTable.isDataTable(datatableReceivable)) {
        datatableReceivable = $('#receivableDataTable').DataTable({
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
        new $.fn.dataTable.Buttons('#receivableDataTable', {
            buttons: [
                {extend: "copyHtml5", title: reportTitle},
                {extend: "excelHtml5", title: reportTitle},
                {extend: "csvHtml5", title: reportTitle},
                {extend: "pdfHtml5", title: reportTitle}
            ]
        }).container().appendTo($("#kt_ecommerce_report_customer_receivable_export"));
    }

    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
    datatableReceivable.on('draw', function () {

        setTimeout(() => {
            $('.dataTables_filter').css('display', 'none');
            $('.dt-buttons').css('display', 'none');
        }, 1);
    });

    document.querySelectorAll("#kt_ecommerce_report_customer_orders_export_menu_receivable [data-kt-ecommerce-export-receivable]").forEach(buttonReceivable => {
        buttonReceivable.addEventListener("click", event => {
            event.preventDefault();
            const exportTypeReceivable = event.target.getAttribute("data-kt-ecommerce-export-receivable");
            if (exportTypeReceivable === "print") {
                printReceivable();
            } else {
                setTimeout(() => {
                    let btnContainer = document.getElementById('kt_ecommerce_report_customer_receivable_export');
                    const exportButton = btnContainer.querySelector(".dt-buttons .buttons-" + exportTypeReceivable);
                    if (exportButton) {
                        exportButton.click();
                    } else {
                        console.error(`Export button for ${exportTypeReceivable} not found.`);
                    }
                }, 0);
            }

        });
    });
}

$('select[name="listTypeReceivable"]').on('change', function () {
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

    datatableReceivable.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.nodes().to$().show();
    });
    // Tarih aralığına göre filtrele
    datatableReceivable.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var date = moment(data[0], 'DD.MM.YYYY HH:mm'); // İlk sütunun tarihini al ve formatına göre dönüştür
        if (!date.isBetween(startDate, endDate)) {
            this.nodes().to$().hide(); // Eğer tarih aralığı dışındaysa, satırı gizle
        }
    });

    // Tabloyu yeniden çiz
    datatableReceivable.draw();
});

var printWindowReceivable; // Bu değişkeni global olarak tanımlayın

function printReceivable() {
    // Eğer zaten bir yazdırma penceresi açıksa, işlemi iptal edin
    if (printWindowReceivable && !printWindowReceivable.closed) {
        console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
        return;
    }

    var tableElementReceivable = document.getElementById('receivableDataTable');

    // Yazdırma penceresini aç
    printWindowReceivable = window.open('', '_blank');
    printWindowReceivable.document.write('<html><head><title>Salon Borçları</title>');

    // Orijinal sayfanızda tanımlanan CSS stillerini yazdırma penceresine ekleyin
    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        if (link.rel === "stylesheet") {
            printWindowReceivable.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
        }
    }

    printWindowReceivable.document.write('</head><body style="padding-left: 20px">');
    printWindowReceivable.document.write(tableElementReceivable.outerHTML);
    printWindowReceivable.document.write('</body></html>');
    printWindowReceivable.document.close();

    // Yeni pencerede yazdırma penceresini aç
    setTimeout(function (){
        printWindowReceivable.print();
    }, 1000);
}
