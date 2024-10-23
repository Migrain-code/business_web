<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Requests\SpeedAppointment\SpeedAppointmentCreateRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Rooms\RoomsListResource;
use App\Http\Resources\SpeedAppointment\PersonelAppointmentServiceResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\BusinessRoom;
use App\Models\BusinessService;
use App\Models\Personel;
use App\Models\PersonelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SpeedAppointmentController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
            return $next($request);
        });
    }

    public function index()
    {
        $personels = $this->business->personels;
        return view('business.appointment.close-clock', compact('personels'));
    }
    public function getCustomerList(Request $request)
    {
        $customers = $this->business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%'])->orWhere('phone', 'like', '%' . $name . '%');
                });
            })
            ->take(150)->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    public function getPersonelServiceList(Personel $personel)
    {
        $services = $personel->services;
        $roomCount = $personel->rooms->count();
        if ($roomCount > 1){
            $rooms = $personel->rooms;
        } else{
            $rooms = [];
        }

        return response()->json([
            'services' => PersonelAppointmentServiceResource::collection($services),
            'rooms' => RoomsListResource::collection($rooms),
        ]);
    }

    public function getPersonelClocks(Personel $personel, Request $request)
    {
        $getDate = Carbon::parse($request->appointment_date);

        $disabledDays[] = $this->findTimes($personel, $getDate, $request->room_id);

        $business = $this->business;
        $clocks = [];
        if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
            return response()->json([
                "status" => "error",
                "message" => "İşletme bu tarihte hizmet vermemektedir"
            ], 200);
        } else {
            //işletme kapalı değilse personel izin kontrolü
            if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                return response()->json([
                    "status" => "error",
                    "message" => "Personel bu tarihte hizmet vermemektedir"
                ], 200);
            } else {
                //personel kapalı değilse personel izin gün kontrolü
                $personelRestDay = $personel->checkDateIsOff($getDate);
                if (isset($personelRestDay) && ($personelRestDay->end_time->format("Y-m-d") != $getDate->format('Y-m-d'))) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ], 200);
                } else {
                    //tüm koşullar sağlanmış ise personel saat takvimi
                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                        if (!in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0])){
                            $clocks[] = [
                                'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                'saat' => $i->format('H:i'),
                                'date' => $getDate->format('d.m.Y'),
                                'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                            ];
                        }


                    }
                }

            }
        }

        return $clocks;
    }

    public function getPersonelList(Request $request)
    {
        if ($request->filled('room_id')) {
            $personelIds = PersonelRoom::where('room_id', $request->room_id)->where('business_id', $this->business->id)->pluck('personel_id');
            $personels = Personel::whereIn('id', $personelIds)->get();
        } else {
            $personels = $this->business->personels;
        }
        return response()->json(PersonelListResource::collection($personels));
    }

    public function appointmentCreate(Personel $personel, SpeedAppointmentCreateRequest $request)
    {
        $business = $this->business;
        $roomId = null;
        if ($personel->rooms->count() > 0){ //personel oda sayısı varsa
            if ($personel->rooms->count() == 1){ // oda sayısı 1 ise 0 default index çünkü
                $roomId = $personel->rooms->first()->room_id;// burada oda seçimi aşamasında 1 oda varsa direk ilk odayı alıyoruz
            } else{
                $roomId = $request->room_id; //1 den fazla oda kaydı varsa formdan seçilen oda id alıyoruz
                if (!isset($roomId)){ // eğer boşsa oda seçimi uyarısı döndür
                    return response()->json([
                        'status' => "error",
                        'message' => "Oda Seçimi Alanı Gereklidir"
                    ]);
                }
            }
        }

        if ($request->appointment_type == "appointmentCreate") { //tür randevu oluşturma ise saat kontrolü yap
            $result = $this->checkClock($personel, $request->start_time, $request->service_id, $roomId);
            if ($result["status"] == "error"){
                return response()->json($result);
            }
        }
        $appointment = new Appointment(); // yeni randevu kaydı başlat
        $appointment->customer_id = $request->customer_id; //müşteri bilgisi
        $appointment->business_id = $business->id; // işletme bilgisi
        $appointment->room_id = $roomId; // oda bilgisi
        $appointment->save(); // kaydet

        $appointmentStartTime = $appointment->setStartTime($request); //randevu başlagnıç saatlerini setle
        $serviceResult = $appointment->setServices($request, $personel, $appointmentStartTime); // randevu hizmetlerini setle
        if (isset($serviceResult["status"]) && $serviceResult["status"] == "error"){
            return response()->json($serviceResult);
        }

        $appointment->setClocks(); //randevu saatlerini kayıt et
        $appointment->setApproveType($request); // onay durumunu kayıt et
        $appointment->setPrice();
        if ($appointment->save()) {
            $appointment->scheduleReminder(); // hatırlatma işi ekle
            $appointment->sendMessages(false); // bildirimleri ve smsleri gönder
            return response()->json([
                'status' => "success",
                'message' => "Randevunuz başarılı bir şekilde oluşturuldu",
            ]);
        }
    }
    public function checkClock($personel, $startTime, $serviceIds, $roomId = 0)
    {
        $appointmentStartTime = Carbon::parse($startTime);

        $appointmentId = rand(100000, 999999);

        foreach ($serviceIds as $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $personel->id;
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->toDateTimeString();
            $appointmentService->appointment_id = $appointmentId;
            //$appointmentService->save();
            /**------------------Saat Kontrolü------------------*/
            $result = $this->checkPersonelClock($personel->id, $appointmentService->start_time, $appointmentService->end_time, $roomId);

            if ($result) {
                return [
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ];
            }
        }
        return [
            'status' => "success",
            'message' => "Saat seçim işleminiz onaylandı. Randevu Oluşturabilirsiniz"
        ];

    }

    public function checkPersonelClock($personelId, $startTime, $endTime)
    {
        $findPersonel = Personel::find($personelId);
        $disabledTimes = $this->findTimes($findPersonel, $startTime);

        $disableds = [];
        $currentDateTime = $startTime->copy();

        while ($currentDateTime < $endTime) {
            $disableds[] = $currentDateTime->format('d.m.Y H:i');
            $currentDateTime->addMinutes(intval($findPersonel->appointmentRange->time));
        }

        foreach ($disableds as $disabledTime) {
            if (in_array($disabledTime, $disabledTimes)) {
                return true;
            }
        }

        return false;
    }

    public function findTimes($personel, $appointment_date, $room_id = null)
    {
        $disableds = [];

        // personelin dolu randevu saatlerini al iptal edilmişleri de dahil et
        $appointments = $personel->appointments()
            ->whereDate('start_time', Carbon::parse($appointment_date)->toDateString())
            ->whereNotIn('status', [3])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime < $endDateTime) {

                $disableds[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }
        // Personelin izinli olduğu saat aralıklarını kontrol et ve disableds dizisine ekle
        $offDays = $personel->stayOffDays()
            ->whereDate('start_time', '<=', Carbon::parse($appointment_date))
            ->whereDate('end_time', '>=', Carbon::parse($appointment_date))->get();

        foreach ($offDays as $offDay) {
            $leaveStart = Carbon::parse($offDay->start_time);
            $leaveEnd = Carbon::parse($offDay->end_time);

            $leaveDateTime = $leaveStart->copy();
            while ($leaveDateTime < $leaveEnd) {
                $disableds[] = $leaveDateTime->format('d.m.Y H:i');
                $leaveDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }
        // randevu almaya 5 dk öncesine kadar izin ver
        $startTime = Carbon::parse($personel->start_time);
        $endTime = Carbon::parse($personel->end_time);
        for ($i = $startTime; $i < $endTime; $i->addMinutes(intval($personel->appointmentRange->time))) {
            if ($i < now()->addMinutes(5)) {
                $disableds[] = $i->format('d.m.Y H:i');
            }
        }
        $business = $personel->business;

        if (isset($room_id) && $room_id > 0) {
            // oda tipi seçilmşse o odadaki randevuları al ve disabled dizisine ata
            $appointmentsBusiness = $business->appointments()->where('room_id', $room_id)->whereNotIn('status', [3])->get();

            foreach ($appointmentsBusiness as $appointment) {
                $businessStartDateTime = Carbon::parse($appointment->start_time);
                $businessEndDateTime = Carbon::parse($appointment->end_time);

                $businessCurrenDateTime = $businessStartDateTime->copy();
                while ($businessCurrenDateTime <= $businessEndDateTime) {

                    $disableds[] = $businessCurrenDateTime->format('d.m.Y H:i');

                    $businessCurrenDateTime->addMinutes(intval($business->range->time));
                }
            }
        }
        return $disableds;
    }

}
