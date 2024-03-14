//Ürün Satış Liste

$('.productSale').on('click', function () {
    var customerId = $(this).data('customer');
    $.ajax({
        url: '/isletme/customer/' + customerId + '/product-sale-list',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let container = document.getElementById('productSaleTable');
            container.innerHTML="";
            var items = "";
            $.each(response, function (index, item) {
                var item = `
                    <tr>
                            <td class="fs-6">${item.seller_date}</td>
                            <td class="fs-6">${item.productName}</td>
                            <td class="fs-6">${item.piece}</td>
                            <td class="fw-bold">₺${item.total}</td>
                            <td class="fs-6">${item.personelName}</td>
                     </tr>
               `;
                items += item;
            });
            container.innerHTML = items;

            initProductSaleTable();

        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                html: 'Sistemsel Bir Hata Sebebiyle Parapuan Listesi Alınamadı',
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    });
});

var datatable;

function initProductSaleTable() {
    if ($.fn.DataTable.isDataTable('#productSaleDataTable')) {
        datatable = $('#productSaleDataTable').DataTable();
    } else {
        // DataTables henüz başlatılmamışsa, yeni bir örneği başlat
        datatable = $('#productSaleDataTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.2/i18n/tr.json"
            },
            responsive: true,
            "info": false,
            'order': [0],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ],
        });
    }

    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
    datatable.on('draw', function () {

        setTimeout(() => {
            $('.dataTables_filter').css('display', 'none');
            $('.dt-buttons').css('display', 'none');
        }, 1);
    });

    const reportTitle = "Ürün Satış Raporu";
    new $.fn.dataTable.Buttons('#productSaleDataTable', {
        buttons: [
            {extend: "copyHtml5", title: reportTitle},
            {extend: "excelHtml5", title: reportTitle},
            {extend: "csvHtml5", title: reportTitle},
            {extend: "pdfHtml5", title: reportTitle}
        ]
    }).container().appendTo($("#kt_ecommerce_report_customer_orders_export"));

    document.querySelectorAll("#kt_ecommerce_report_customer_orders_export_menu [data-kt-ecommerce-export]").forEach(button => {
        button.addEventListener("click", event => {
            event.preventDefault();
            const exportType = event.target.getAttribute("data-kt-ecommerce-export");
            if (exportType == "print") {
                print();
            } else {
                setTimeout(() => {
                    const exportButton = document.querySelector(".dt-buttons .buttons-" + exportType);
                    if (exportButton) {
                        exportButton.click();
                    } else {
                        console.error(`Export button for ${exportType} not found.`);
                    }
                }, 0);
            }

        });
    });
}

$('select[name="listType"]').on('change', function () {
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

    datatable.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.nodes().to$().show();
    });
    // Tarih aralığına göre filtrele
    datatable.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var date = moment(data[0], 'DD.MM.YYYY HH:mm'); // İlk sütunun tarihini al ve formatına göre dönüştür
        if (!date.isBetween(startDate, endDate)) {
            this.nodes().to$().hide(); // Eğer tarih aralığı dışındaysa, satırı gizle
        }
    });

    // Tabloyu yeniden çiz
    datatable.draw();
});

function print() {
    var tableElement = document.getElementById('productSaleDataTable');

    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write(tableElement.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Yeni pencerede yazdırma penceresini aç
    printWindow.print();
}
