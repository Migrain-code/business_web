async function addEventToCalendar() {
    addMultipleEventsToCalendar(eventsToAdd);
}

async function addMultipleEventsToCalendar(events) {

    try {
        // İlk olarak mevcut takvim etkinliklerini alın
        const existingEvents = await gapi.client.calendar.events.list({
            'calendarId': 'primary',
            'timeMin': minDate,
            'showDeleted': false,
            'singleEvents': true,
            'maxResults': 2500,
            'orderBy': 'startTime'
        });

        // Mevcut etkinliklerin bir dizisini oluşturun
        const existingEventsMap = new Map();
        existingEvents.result.items.forEach((event, index) => {
            if (event.summary) {
                existingEventsMap.set(index, event.summary);
            }
        });

        const batch = gapi.client.newBatch();
        const dontAddedAppointments = new Map();
        events.forEach((event, index) => {
            let isEventExist = false; //takvime daha önce eklenmiş mi
            existingEventsMap.forEach(summary => {
                if(summary === event.summary){
                    isEventExist = true; //eklenmiş ise true
                }
            });
            if (!isEventExist) { //eklenmemiş ise ekle
                // E-mail doğrulaması
                event.attendees = event.attendees.filter(attendee => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(attendee.email));

                batch.add(gapi.client.calendar.events.insert({
                    'calendarId': 'primary',
                    'resource': event,
                }), { 'id': index.toString() });
            } else {
                dontAddedAppointments.set(index, event.summary);
            }
        });
        var tableRows = ""
        dontAddedAppointments.forEach(summary => {
            tableRows += "<tr><td>" + summary + "</td></tr>";
        });

        Swal.fire({
            title: "Bu randevular takviminize daha önce eklenmiş",
            icon: "warning",
            html: "<table class='d-flex justify-content-center'>" + tableRows + "</table>",
        });
        //const response = await batch;
        // Hangi etkinliklerin başarıyla eklendiğini kontrol edin.
        /*for (let key in response.result) {
            if (response.result[key].status !== 200) {
                // console.error(`Etkinlik "${events[key].summary}" eklenemedi: `, response.result[key].error.message);
            }
        }*/
        setTimeout(function(){
            Swal.fire({
                title:"Randevular Google Takviminize Eklendi",
                icon: "success",
            });
        }, 500)


        handleSignoutClick();
    } catch (err) {
        console.error('Hata oluştu: ', err);
    }
}
