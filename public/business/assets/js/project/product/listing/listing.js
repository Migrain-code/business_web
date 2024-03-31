"use strict";

// Class definition
var KTCustomersList = function () {
    // Define shared variables
    var table, datatable;
    // Private functions
    var initCustomerList = function () {
        // Set date data order
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            dateRow[5].setAttribute('data-order', realDate);
        });

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.2/i18n/tr.json"
            },
            serverSide: true,
            processing : true,
            columns: DATA_COLUMNS,
            responsive: true,
            "info": false,
            'order': [],
            dom: 'Bfrtip',//B eklersek başına doma ekler
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
            ],
            'columnDefs': [
                { orderable: false, targets: 0 }, // Disable ordering on column 0 (checkbox)
                { orderable: false, targets: 6 }, // Disable ordering on column 6 (actions)
            ],
            ajax: {
                url: DATA_URL,
                data: function (d) {
                    d.listType = $('#listType').val();
                    d.stockType = $('#stockType').val();
                }
            },
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            setTimeout(() => {
                document.getElementById('datatable_filter').style.display = "none";
                $('.dt-buttons').css('display', 'none');
            }, 1);
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-sale-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    $('#listType').on('change', function () {
        datatable.ajax.reload();
    });
    $('#stockType').on('change', function () {
        datatable.ajax.reload();
    });
    function initExportButtons() {
        const reportTitle = "Ürün Raporu";
        new $.fn.dataTable.Buttons(table, {
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
                if (exportType === 'print'){
                    printSaleReport();
                }else{
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
    var printWindowPayment;
    function printSaleReport() {
        // Eğer zaten bir yazdırma penceresi açıksa, işlemi iptal edin
        if (printWindowPayment && !printWindowPayment.closed) {
            console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
            return;
        }

        var tableElementPayment = document.getElementById('datatable');
        $('#datatable').find('tr').each(function() {
            $(this).find('td:eq(6), th:eq(6)').hide(); // 0 tabanlı indexleme olduğu için 4. sütunu gizliyoruz
        });
        // Yazdırma penceresini aç
        printWindowPayment = window.open('', '_blank');
        printWindowPayment.document.write('<html><head><title>Ürün Raporu</title>');

        // Orijinal sayfanızda tanımlanan CSS stillerini yazdırma penceresine ekleyin
        var links = document.getElementsByTagName("link");
        for (var i = 0; i < links.length; i++) {
            var link = links[i];
            if (link.rel === "stylesheet") {
                printWindowPayment.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
            }
        }
        var now = new Date();
        var formattedDateTime = now.toLocaleString();
        printWindowPayment.document.write('</head><body style="padding-left: 20px">');
        printWindowPayment.document.write('</head><div class="card-header p-3 text-center d-flex justify-content-between"><h3>Ürün Raporu</h3><span>'+formattedDateTime+'</span></div>');
        printWindowPayment.document.write(tableElementPayment.outerHTML);
        printWindowPayment.document.write('</body></html>');
        printWindowPayment.document.close();

        // Yeni pencerede yazdırma penceresini aç
        setTimeout(function (){
            printWindowPayment.print();
        }, 1000);
        location.reload();
    }
    // Public methods
    return {
        init: function () {
            table = document.querySelector('#datatable');

            if (!table) {
                return;
            }

            initCustomerList();
            handleSearchDatatable();
            initExportButtons();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTCustomersList.init();
});
