"use strict";

var KTAppEcommerceReportCustomerOrders = function () {
    var table, dataTable;

    function initTable() {
        table = document.querySelector("#kt_ecommerce_report_customer_orders_table");
        if (table) {
            table.querySelectorAll("tbody tr").forEach(row => {
                const cells = row.querySelectorAll("td");
                const date = moment(cells[3].innerHTML, "DD MMM YYYY, LT").format();
                cells[3].setAttribute("data-order", date);
            });

            dataTable = $(table).DataTable({
                info: false,
                order: [],
                pageLength: 10
            });
        }
    }

    function initDateRangePicker() {
        const startDate = moment().subtract(29, "days");
        const endDate = moment();
        const dateRangePicker = $("#kt_ecommerce_report_customer_orders_daterangepicker");

        function updateDateRangePicker(start, end) {
            dateRangePicker.html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        }

        dateRangePicker.daterangepicker({
            startDate: startDate,
            endDate: endDate,
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, updateDateRangePicker);

        updateDateRangePicker(startDate, endDate);
    }

    function initExportButtons() {
        const reportTitle = "Customer Orders Report";
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
                document.querySelector(".dt-buttons .buttons-" + exportType).click();
            });
        });
    }

    function initSearchFilter() {
        document.querySelector('[data-kt-ecommerce-order-filter="search"]').addEventListener("keyup", event => {
            dataTable.search(event.target.value).draw();
        });
    }

    function initStatusFilter() {
        const statusFilter = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
        $(statusFilter).on("change", event => {
            let filterValue = event.target.value;
            if (filterValue === "all") {
                filterValue = "";
            }
            dataTable.column(2).search(filterValue).draw();
        });
    }

    return {
        init: function () {
            initTable();
            initDateRangePicker();
            initExportButtons();
            initSearchFilter();
            initStatusFilter();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceReportCustomerOrders.init();
});
