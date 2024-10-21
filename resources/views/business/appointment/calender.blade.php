@extends('business.layouts.master')
@section('title', 'İşletme Randevuları')
@section('styles')
    <link href="/business/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .fc-timegrid-event-harness-inset .fc-timegrid-event, .fc-timegrid-event.fc-event-mirror, .fc-timegrid-more-link {
            box-shadow: 0 0 0 1px #fff;
            box-shadow: 0 0 0 1px var(--fc-page-bg-color, #fff);
            min-height: 25px;
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('personel.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.appointment.index')}}"> Randevular </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Randevu Takvimi
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="card ">
            <!--begin::Card header-->
            <div class="card-header d-flex align-items-center">
                <h2 class="card-title fw-bold">
                    Randevu Takvimi
                </h2>
                {{-- <button id="authorize_button" onclick="handleAuthClick()">Randevuları Dışarı Aktar</button>
 --}}

            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Calendar-->
                <div id="kt_calendar_app"></div>
                <!--end::Calendar-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Modal - New Product--><!--begin::Modal - New Product-->
        <div class="modal fade" id="kt_modal_view_event" tabindex="-1" data-bs-focus="false" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Kapat" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>                </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body pt-0 pb-20 px-lg-17">
                        <!--begin::Row-->
                        <div class="d-flex">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-calendar-8 fs-1 text-muted me-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>                    <!--end::Icon-->

                            <div class="mb-9">
                                <!--begin::Event name-->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-3 fw-bold me-3" data-kt-calendar="event_name"></span> <span class="badge badge-light-success" data-kt-calendar="all_day"></span>
                                </div>
                                <!--end::Event name-->

                                <!--begin::Event description-->
                                <div class="fs-6" data-kt-calendar="event_description"></div>
                                <!--end::Event description-->
                            </div>
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot h-10px w-10px bg-success ms-2 me-7"></span>
                            <!--end::Bullet-->

                            <!--begin::Event start date/time-->
                            <div class="fs-6"><span class="fw-bold">Başlangıç Saati</span> <span data-kt-calendar="event_start_date"></span></div>
                            <!--end::Event start date/time-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="d-flex align-items-center mb-9">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot h-10px w-10px bg-danger ms-2 me-7"></span>
                            <!--end::Bullet-->

                            <!--begin::Event end date/time-->
                            <div class="fs-6"><span class="fw-bold">Bitiş Saati</span> <span data-kt-calendar="event_end_date"></span></div>
                            <!--end::Event end date/time-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-user fs-1 text-muted me-5"><span class="path1"></span><span class="path2"></span></i>                    <!--end::Icon-->

                            <!--begin::Event location-->
                            <div class="fs-6" data-kt-calendar="event_location"></div>
                            <!--end::Event location-->
                        </div>
                        <!--end::Row-->
                        <div class="d-flex align-items-center mt-3">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-chart-pie-3 fs-1 text-muted me-5"><span class="path1"></span><span class="path2"></span></i>                    <!--end::Icon-->

                            <!--begin::Event location-->
                            <div class="fs-6" data-kt-calendar="event_status"></div>
                            <!--end::Event location-->
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
            </div>
        </div>

        <div class="modal fade" id="kt_modal_import_appointment" tabindex="-1" data-bs-focus="false" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Kapat" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>                </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body pt-0 pb-20 px-lg-17">
                        <!--begin::Row-->
                        <div class="d-flex">
                            <div class="d-flex flex-column mb-7 w-100 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Aktarma Tipi Seçiniz</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Aktarma Tipi Seçiniz"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="import_type" id="import_type" aria-label="Aktarma Tipi Seçiniz" data-control="select2" data-placeholder="Aktarma Tipi Seçiniz..." data-dropdown-parent="#kt_modal_import_appointment" class="form-select form-select-solid fw-bold">
                                    <option value="">Aktarma Tipi Seçiniz</option>
                                    <option value="googleCalendar">Google Takvim</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Row-->

                    </div>
                    <!--end::Modal body-->
                </div>
            </div>
        </div>
        <pre id="content" style="white-space: pre-wrap;"></pre>

    </div>
@endsection
@section('scripts')
    <script src="/business/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>

    <script>
        var eventCollection = [];
        @foreach($appointments as $appointment)
        var newEvent = {
            id: "{{$appointment->id}}",
            title: "{{$appointment->services->count() > 1 ? $appointment->services->first()->service->subCategory->name." +". $appointment->services->count(): $appointment->services->first()->service->subCategory->name}}",
            start: "{{$appointment->start_time->format('Y-m-d H:i')}}",
            end: "{{$appointment->end_time->format('Y-m-d H:i')}}",
            description: "Toplam Tutar : "+ "{{$appointment->calculateTotal()}}",
            className: "fc-event-danger fc-event-solid-warning",
            username: "{{$appointment->customer->name}}",
            status: "{{$appointment->status("text")}}"
        };
        eventCollection.push(newEvent);

        @endforeach

    </script>
    <script src="/business/assets/js/project/calendar/calendar.js"></script>

    <script type="text/javascript">

        const CLIENT_ID = '414891486320-6ii8q9nq4h0gn637a9dlhg91aob1jjrp.apps.googleusercontent.com';
        const API_KEY = 'AIzaSyChZoNhAWfCk-QNlLYxoQjwegT_7JllyOg';

        // Discovery doc URL for APIs used by the quickstart
        const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

        // Authorization scopes required by the API; multiple scopes can be
        // included, separated by spaces.
        const SCOPES = 'https://www.googleapis.com/auth/calendar';

        let tokenClient;
        let gapiInited = false;
        let gisInited = false;
        var minDate = '{{now()->subDays(10)->startOfDay()->toIso8601String()}}';

        const eventsToAdd = [
            @forelse ($appointments as $appointment)
            @if($appointment->customer)
            {
                'summary': @json($appointment->customer->name . " " . "#" . $appointment->id),
                'location': @json($appointment->business->address),
                'description': '{{$appointment->note}}',
                'start': {
                    'dateTime': '{{\Illuminate\Support\Carbon::parse($appointment->services->first()->start_time)->toIso8601String()}}',
                    'timeZone': 'Europe/Istanbul'
                },
                'end': {
                    'dateTime': '{{\Illuminate\Support\Carbon::parse($appointment->services->last()->end_time)->toIso8601String()}}',
                    'timeZone': 'Europe/Istanbul'
                },
                'recurrence': [],
                'attendees': [
                        @foreach($appointment->services as $service)
                    {'email': '{{$service->personel->email}}'},
                    @endforeach
                ],
                'reminders': {
                    'useDefault': false,
                    'overrides': [
                        {'method': 'email', 'minutes': 120},
                        {'method': 'popup', 'minutes': 10}
                    ]
                }
            },
            @endif
            @empty
            @endforelse
        ];
        /**
         * Callback after api.js is loaded.
         */
        function gapiLoaded() {
            gapi.load('client', initializeGapiClient);
        }

        /**
         * Callback after the API client is loaded. Loads the
         * discovery doc to initialize the API.
         */
        async function initializeGapiClient() {
            await gapi.client.init({
                apiKey: API_KEY,
                discoveryDocs: [DISCOVERY_DOC],
            });
            gapiInited = true;
            maybeEnableButtons();
        }

        /**
         * Callback after Google Identity Services are loaded.
         */
        function gisLoaded() {
            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: CLIENT_ID,
                scope: SCOPES,
                callback: '', // defined later
            });
            gisInited = true;
            maybeEnableButtons();
        }

        /**
         * Enables user interaction after all libraries are loaded.
         */
        function maybeEnableButtons() {
            if (gapiInited && gisInited) {
              //  document.getElementById('authorize_button').style.visibility = 'visible';
            }
        }

        /**
         *  Sign in the user upon button click.
         */
        function handleAuthClick() {
            tokenClient.callback = async (resp) => {
                if (resp.error !== undefined) {
                    throw (resp);
                }


                addEventToCalendar();

            };

            if (gapi.client.getToken() === null) {
                // Prompt the user to select a Google Account and ask for consent to share their data
                // when establishing a new session.
                tokenClient.requestAccessToken({prompt: 'consent'});

            } else {
                // Skip display of account chooser and consent dialog for an existing session.
                tokenClient.requestAccessToken({prompt: ''});

            }
        }

        /**
         *  Sign out the user upon button click.
         */
        function handleSignoutClick() {
            const token = gapi.client.getToken();
            if (token !== null) {
                google.accounts.oauth2.revoke(token.access_token);
                gapi.client.setToken('');
                document.getElementById('content').innerText = '';
            }
        }

    </script>
    <script src="/business/assets/js/project/calendar/add.js"></script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>

@endsection
