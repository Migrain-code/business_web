var printWindowAppointment;
const reportTitle = 'Personel '+ personelName + ' Bildirim raporu'
function printCase() {
    // Eğer zaten bir yazdırma penceresi açıksa, işlemi iptal edin
    if (printWindowAppointment && !printWindowAppointment.closed) {
        console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
        return;
    }
    $('#printButton').css('display', 'none');

    $('.delete-btn').css('display', 'none');
    var tableElementPayment = document.getElementById('printTable');
    $('#sendNotify').css('display', 'none');
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
    setTimeout(function (){
        $('#printButton').css('display', 'block');
        $('#sendNotify').css('display', 'block');
        $('.delete-btn').css('display', 'block');
    }, 1500);

}
