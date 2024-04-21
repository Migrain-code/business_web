"use strict";

const KTAppCalendar = (() => {
    const eventModal = document.getElementById("kt_modal_view_event");
    const viewEventModal = new bootstrap.Modal(eventModal);

    const calendar = new FullCalendar.Calendar(document.getElementById("kt_calendar_app"), {
        headerToolbar: {
            left: 'customPrev,customNext today',
            center: 'title',
            right: 'customMonth,customWeek,customDay'
        },
        customButtons: {
            customPrev: {
                text: 'Önceki',
                click: function () {
                    calendar.prev();
                }
            },
            customNext: {
                text: 'Sonraki',
                click: function () {
                    calendar.next();
                }
            },
            today: {
                text: 'Bugün',
                click: function () {
                    calendar.today();
                }
            },
            customMonth: {
                text: 'Ay',
                click: function () {
                    calendar.changeView('dayGridMonth');
                }
            },
            customWeek: {
                text: 'Hafta',
                click: function () {
                    calendar.changeView('timeGridWeek');
                }
            },
            customDay: {
                text: 'Gün',
                click: function () {
                    calendar.changeView('timeGridDay');
                }
            }
        },

        views: {
            dayGridMonth: {
                titleFormat: {year: 'numeric', month: 'long'} // Ay görünümünün başlığını Türkçe yapmak için
            },
            timeGridWeek: {
                titleFormat: {year: 'numeric', month: 'long', day: 'numeric'} // Hafta görünümünün başlığını Türkçe yapmak için
            },
            timeGridDay: {
                titleFormat: {year: 'numeric', month: 'long', day: 'numeric'} // Gün görünümünün başlığını Türkçe yapmak için
            }
        },
        initialView: 'timeGridWeek',
        timeZone: 'Europe/Istanbul',
        locale: 'tr',

        initialDate: moment().format("YYYY-MM-DD"),
        navLinks: true,
        selectable: false,
        selectMirror: true,
        select: function (selectionInfo) {
        },
        eventDrop: function(info) {
            //"Olayın eski başlangıç tarihi: " + info.oldEvent.start);
            //"Olayın yeni başlangıç tarihi: " + info.event.start);
            //"Olayın eski bitiş tarihi: " + info.oldEvent.end);
            //"Olayın yeni bitiş tarihi: " + info.event.end);
            //"Olayın yeni ID'si: " + info.event.id);
            info.event.setStart(info.event.start);
            info.event.setEnd(info.event.end);
            var formData = new FormData();
            formData.append("_token", csrf_token);
            formData.append("appointment_id", info.event.id);
            formData.append("start_time", clockFormatter(info.event.start));
            formData.append("end_time", clockFormatter(info.event.end));
            $.ajax({
                url: '/personel/appointment/update',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        text: res.message,
                        icon: res.status,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                },
                error: function (xhr) {
                    var errorMessage = "<ul>";
                    xhr.responseJSON.errors.forEach(function (error) {
                        errorMessage += "<li>" + error + "</li>";
                    });
                    errorMessage += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        html: errorMessage,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });

        },
        eventClick: function (e) {
                var id = e.event.id;
                var title = e.event.title;
                var description = e.event.extendedProps.description;
                var location = e.event.extendedProps.username;
                var status = e.event.extendedProps.status;
                var startStr = e.event.startStr;
                var endStr = e.event.endStr;
                var allDay = e.event.allDay;

                var event_name = eventModal.querySelector('[data-kt-calendar="event_name"]');
                var all_day = eventModal.querySelector('[data-kt-calendar="all_day"]');
                var event_description = eventModal.querySelector('[data-kt-calendar="event_description"]');
                var event_location = eventModal.querySelector('[data-kt-calendar="event_location"]');
                var event_start_date = eventModal.querySelector('[data-kt-calendar="event_start_date"]');
                var event_end_date = eventModal.querySelector('[data-kt-calendar="event_end_date"]');
                var event_status = eventModal.querySelector('[data-kt-calendar="event_status"]');

                event_name.innerText = title;
                event_description.innerText = description;
                event_location.innerText = location;
                event_start_date.innerText = clockFormatter(startStr);
                event_end_date.innerText = clockFormatter(endStr);
                event_status.innerText = status;

                viewEventModal.show();

        },
        editable: true,
        dayMaxEvents: true,
        events: [{
            id: 1,
            title: "Saç Kesimi",
            start: "2024-04-21 18:00",
            end:"2024-04-21 19:00",
            description: "",
            className: "fc-event-danger fc-event-solid-warning",
            username: "Muhammet",
            status: "Onaylandı"
        },
        ],
        datesSet: function () {},
        windowResize: function (view) {
            if (window.innerWidth < 768) {
                calendar.changeView('timeGridDay');
            } else {
                // Ekran genişliği 768 piksel veya daha fazlaysa, varsayılan görünümü kullan
                calendar.changeView('timeGridWeek');
            }
        },
    });
    function checkScreenWidth(calendar) {
        if (window.innerWidth < 768) {
            calendar.changeView('timeGridDay');
        } else {
            // Ekran genişliği 768 piksel veya daha fazlaysa, varsayılan görünümü kullan
            calendar.changeView('timeGridWeek');
        }
    }
    function clockFormatter(formattedDate){
        var startDate = new Date(formattedDate);
        let monthFormat = (startDate.getMonth() + 1);

        if (monthFormat < 10){
             monthFormat = "0" + monthFormat;
        }
        var startFormatted = startDate.getDate() + '.' + monthFormat + '.' + startDate.getFullYear() + ' ' + startDate.getHours() + ':' + ('0' + startDate.getMinutes()).slice(-2);
        return startFormatted;
    }
    const generateEventId = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();

    const openEditEventModal = (event) => {
        // Edit event logic
    };

    const deleteEvent = (eventId) => {
        // Delete event logic
    };

    const cancelEvent = () => {
        // Cancel event logic
    };

    const init = () => {
        calendar.render();
        // Additional initialization logic
    };

    return {
        init,
        openEditEventModal,
        deleteEvent,
        cancelEvent
    };
})();

KTUtil.onDOMContentLoaded(() => {
    KTAppCalendar.init();
});
