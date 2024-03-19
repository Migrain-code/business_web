var datatableReceivable;
const reportTitle = "Personel "+ personelName + " Randevu Raporu";
function initReceivableTable() {

    // DataTables zaten başlatılmışsa, yeni bir örneği başlatma
    if (!$.fn.DataTable.isDataTable(datatableReceivable)) {
        datatableReceivable = $('#datatable').DataTable({
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
        new $.fn.dataTable.Buttons('#datatable', {
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

var printWindowAppointment;

function printReceivable() {
    // Eğer zaten bir yazdırma penceresi açıksa, işlemi iptal edin
    if (printWindowAppointment && !printWindowAppointment.closed) {
        console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
        return;
    }

    var tableElementPayment = document.getElementById('datatable');
    $('#datatable').find('tr').each(function() {
        $(this).find('td:eq(4), th:eq(4)').hide(); // 0 tabanlı indexleme olduğu için 4. sütunu gizliyoruz
    });
    // Yazdırma penceresini aç
    printWindowAppointment = window.open('', '_blank');
    printWindowAppointment.document.write('<html><head><title>'+reportTitle+'</title>');

    // Orijinal sayfanızda tanımlanan CSS stillerini yazdırma penceresine ekleyin
    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        if (link.rel === "stylesheet") {
            printWindowAppointment.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
        }
    }
    var now = new Date();
    var formattedDateTime = now.toLocaleString();
    printWindowAppointment.document.write('</head><body style="padding-left: 20px">');
    printWindowAppointment.document.write('</head><div class="card-header p-3 text-center d-flex justify-content-between"><h3>'+reportTitle+'</h3><span>'+formattedDateTime+'</span></div>');
    printWindowAppointment.document.write(tableElementPayment.outerHTML);
    printWindowAppointment.document.write('</body></html>');
    printWindowAppointment.document.close();

    // Yeni pencerede yazdırma penceresini aç
    setTimeout(function (){
        printWindowAppointment.print();
    }, 1500);
    location.reload();
}
$(document).ready(function (){
   initReceivableTable();
});
