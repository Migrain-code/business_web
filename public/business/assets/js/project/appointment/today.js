function checkAppointments() {
    const now = new Date();
    const endTimeElements = document.querySelectorAll('.endTime');

    endTimeElements.forEach(function(element) {
        const endTimeStr = element.getAttribute('data-end-time');
        const endTimeParts = endTimeStr.split(':');
        const endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), endTimeParts[0], endTimeParts[1]);

        if (now > endTime) {
            const timelineItem = element.closest('.timeline-item');
            if (timelineItem) {
                timelineItem.style.display = 'none';
            }
        }
    });
    console.log('saat kontrolü çalıştırıldı');
}


if (setCloseClockStatus){
    checkAppointments();

// 5 dakikada bir kontrol et
    setInterval(checkAppointments, 5 * 60 * 1000);
}
function openFullScreen() {
    // appointmentCalendar div'inin içeriğini al
    var content = document.getElementById('appointmentCalendar').outerHTML;


    var scripts = document.head.getElementsByTagName('script');

    // Pencerenin genişlik ve yüksekliğini al
    var width = window.innerWidth;
    var height = window.innerHeight + 30;

    // Yeni bir pencere aç (tam ekran boyutunda)
    var newWindow = window.open('', '', `width=${width},height=${height}`);
    // Yeni pencereye içeriği yaz
    newWindow.document.write('<html><head><title>Bugünkü Randevular</title>');

    var links = document.getElementsByTagName("link");
    for (var i = 0; i < links.length; i++) {
        var link = links[i];
        if (link.rel === "stylesheet") {
            newWindow.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
        }
    }

    newWindow.document.write('</head><body>');
    newWindow.document.write(content);
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i].src) {
            // Eğer script bir dosyadan yükleniyorsa, src ile ekle
            newWindow.document.write(`<script src="${scripts[i].src}"></` + 'script>');
        } else {
            // Eğer script inline ise, içeriğini ekle
            newWindow.document.write(`<script>${scripts[i].innerHTML}</` + 'script>');
        }
    }
    newWindow.document.write('</body></html>');
    newWindow.document.close(); // HTML dokümanını tamamla

    // Yeni pencereyi tam ekran yap
    newWindow.onload = function() {
        if (newWindow.document.documentElement.requestFullscreen) {
            newWindow.document.documentElement.requestFullscreen();
        } else if (newWindow.document.documentElement.mozRequestFullScreen) { // Firefox
            newWindow.document.documentElement.mozRequestFullScreen();
        } else if (newWindow.document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
            newWindow.document.documentElement.webkitRequestFullscreen();
        } else if (newWindow.document.documentElement.msRequestFullscreen) { // IE/Edge
            newWindow.document.documentElement.msRequestFullscreen();
        }
    };
}
