//Kullanım Liste

$('.usages').on('click', function () {

    var packageId = $(this).data('package');

    $.ajax({
        url: '/isletme/package-sale/' + packageId + '/usages',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let containerUsage = document.getElementById('usageTable');
            containerUsage.innerHTML="";
            var items = "";
            $.each(response, function (index, item) {
                var item = `
                    <tr>
                            <td class="fs-6">${item.created_at}</td>
                            <td class="fs-6">${item.personel.name}</td>
                            <td class="fw-bold">${item.amount}</td>
                            <td class="min-w-125px">

                                <a class="btn btn-danger btn-sm me-1 usage-delete-btn" href="#" data-toggle="popover" data-object-id="${item.id}" data-route="/isletme/package-sale/${item.id}/delete-usage" data-model="App\\Models\\PackagePayment" data-content="Paket Satışının Kullanım Kaydını Silmek İstediğinize Eminmisiniz?" data-title="Paket Kullanımı"><i class="fa fa-trash"></i></a>
                            </td>
                     </tr>
               `;
                items += item;
            });
            containerUsage.innerHTML= items;
            //initUsageTable();

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

var datatableUsage;

function initUsageTable() {
    const reportTitle = "Paket Satışı Kullanımları";
    // DataTables zaten başlatılmışsa, yeni bir örneği başlatma
    if (!$.fn.DataTable.isDataTable(datatableUsage)) {
        datatableUsage = $('#usageDataTable').DataTable({
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
        new $.fn.dataTable.Buttons('#usageDataTable', {
            buttons: [
                {extend: "copyHtml5", title: reportTitle},
                {extend: "excelHtml5", title: reportTitle},
                {extend: "csvHtml5", title: reportTitle},
                {extend: "pdfHtml5", title: reportTitle}
            ]
        }).container().appendTo($("#kt_ecommerce_report_customer_usage_export"));
    }

    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
    datatableUsage.on('draw', function () {

        setTimeout(() => {
            $('.dataTables_filter').css('display', 'none');
            $('.dt-buttons').css('display', 'none');
        }, 1);
    });

    document.querySelectorAll("#kt_ecommerce_report_customer_orders_export_menu_usage [data-kt-ecommerce-export-usage]").forEach(buttonUsage => {
        buttonUsage.addEventListener("click", event => {
            event.preventDefault();
            const exportTypeUsage = event.target.getAttribute("data-kt-ecommerce-export-usage");
            if (exportTypeUsage === "print") {
                printUsage();
            } else {
                setTimeout(() => {
                    let btnContainer = document.getElementById('kt_ecommerce_report_customer_usage_export');
                    const exportButton = btnContainer.querySelector(".dt-buttons .buttons-" + exportTypeUsage);
                    if (exportButton) {
                        exportButton.click();
                    } else {
                        console.error(`Export button for ${exportTypeUsage} not found.`);
                    }
                }, 0);
            }

        });
    });
}
$(document).ready(function (){
    initUsageTable();
});
$('select[name="listTypeUsage"]').on('change', function () {
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

    datatableUsage.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.nodes().to$().show();
    });
    // Tarih aralığına göre filtrele
    datatableUsage.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var date = moment(data[0], 'DD.MM.YYYY HH:mm'); // İlk sütunun tarihini al ve formatına göre dönüştür
        if (!date.isBetween(startDate, endDate)) {
            this.nodes().to$().hide(); // Eğer tarih aralığı dışındaysa, satırı gizle
        }
    });

    // Tabloyu yeniden çiz
    datatableUsage.draw();
});

var printWindowUsage;

function printUsage() {
    if (printWindowUsage && !printWindowUsage.closed) {
        console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
        return;
    }

    var tableElementUsage = document.getElementById('usageDataTable');
    $('#usageDataTable').find('tr').each(function() {
        $(this).find('td:eq(3), th:eq(3)').hide(); // 0 tabanlı indexleme olduğu için 4. sütunu gizliyoruz
    });
    // Yazdırma penceresini aç
    printWindowUsage = window.open('', '_blank');
    printWindowUsage.document.write('<html><head><title>Paket Satış Kullanım Raporu</title>');

    // Orijinal sayfanızda tanımlanan CSS stillerini yazdırma penceresine ekleyin
    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        if (link.rel === "stylesheet") {
            printWindowUsage.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
        }
    }
    var now = new Date();
    var formattedDateTime = now.toLocaleString();
    printWindowUsage.document.write('</head><body style="padding-left: 20px">');
    printWindowUsage.document.write('</head><div class="card-header p-3 text-center d-flex justify-content-between"><h3>Paket Satış Kullanım Raporu</h3><span>'+formattedDateTime+'</span></div>');
    printWindowUsage.document.write(tableElementUsage.outerHTML);
    printWindowUsage.document.write('</body></html>');
    printWindowUsage.document.close();

    // Yeni pencerede yazdırma penceresini aç
    setTimeout(function (){
        printWindowUsage.print();
    }, 500);
    // Açılan penecerede işlem yapılmamışsa kapat
    setTimeout(function (){
        location.reload();
    }, 500);

}
