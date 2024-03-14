//Ürün Satış Liste

$('.packageSale').on('click', function () {

    var customerId = $(this).data('customer');
    $.ajax({
        url: '/isletme/customer/' + customerId + '/package-sale-list',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let container = document.getElementById('packageSaleTable');
            container.innerHTML="";
            var items = "";
            $.each(response, function (index, item) {
                var item = `

                    <tr>
                            <td class="fs-6">${item.sellerDate}</td>
                            <td class="fs-6">${item.serviceName}</td>
                            <td class="fs-6">${item.amount}</td>
                            <td class="fw-bold">${item.usedAmount}</td>
                            <td class="fs-6">${item.remainingAmount}</td>
                            <td class="fs-6">${item.total}</td>
                            <td class="fs-6">${item.payedTotal}₺</td>
                            <td class="fs-6">${item.remainingTotal}₺</td>
                     </tr>
               `;
                items += item;
            });
            container.innerHTML = items;

            initPackageSaleTable();

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

var datatablePackage;

function initPackageSaleTable() {
    const reportTitle = "Paket Satış Raporu";
    // DataTables zaten başlatılmışsa, yeni bir örneği başlatma
    if (!$.fn.DataTable.isDataTable(datatablePackage)) {
        datatablePackage = $('#packageSaleDataTable').DataTable({
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
        new $.fn.dataTable.Buttons('#packageSaleDataTable', {
            buttons: [
                {extend: "copyHtml5", title: reportTitle},
                {extend: "excelHtml5", title: reportTitle},
                {extend: "csvHtml5", title: reportTitle},
                {extend: "pdfHtml5", title: reportTitle}
            ]
        }).container().appendTo($("#kt_ecommerce_report_customer_packages_export"));
    }

    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
    datatablePackage.on('draw', function () {

        setTimeout(() => {
            $('.dataTables_filter').css('display', 'none');
            $('.dt-buttons').css('display', 'none');
        }, 1);
    });

    document.querySelectorAll("#kt_ecommerce_report_customer_orders_export_menu_package [data-kt-ecommerce-export-package]").forEach(buttonPackage => {
        buttonPackage.addEventListener("click", event => {
            event.preventDefault();
            const exportTypePackage = event.target.getAttribute("data-kt-ecommerce-export-package");
            if (exportTypePackage == "print") {
                printPackage();
            } else {
                setTimeout(() => {
                    let btnContainer = document.getElementById('kt_ecommerce_report_customer_packages_export');
                    const exportButton = btnContainer.querySelector(".dt-buttons .buttons-" + exportTypePackage);
                    if (exportButton) {
                        exportButton.click();
                    } else {
                        console.error(`Export button for ${exportTypePackage} not found.`);
                    }
                }, 0);
            }

        });
    });
}

$('select[name="listTypePackage"]').on('change', function () {
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

    datatablePackage.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.nodes().to$().show();
    });
    // Tarih aralığına göre filtrele
    datatablePackage.rows().every(function (rowIdx, tableLoop, rowLoop) {
        var data = this.data();
        var date = moment(data[0], 'DD.MM.YYYY HH:mm'); // İlk sütunun tarihini al ve formatına göre dönüştür
        if (!date.isBetween(startDate, endDate)) {
            this.nodes().to$().hide(); // Eğer tarih aralığı dışındaysa, satırı gizle
        }
    });

    // Tabloyu yeniden çiz
    datatablePackage.draw();
});

function printPackage() {
    var tableElementPackage = document.getElementById('packageSaleDataTable');

    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Paket Satışları</title></head><body>');
    printWindow.document.write(tableElementPackage.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Yeni pencerede yazdırma penceresini aç
    printWindow.print();
}
