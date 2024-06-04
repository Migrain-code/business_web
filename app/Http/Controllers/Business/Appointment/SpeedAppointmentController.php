<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Personel\PersonelServiceResource;
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
        $rooms = $this->business->activeRooms;
        return view('business.appointment.close-clock', compact('rooms'));
    }
    public function getCustomerList(Request $request)
    {
        $customers = $this->business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $q->whereHas('customer', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->input('name') . '%');
                });
            })
            ->take(250)->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    public function getPersonelServiceList(Personel $personel)
    {
        $services = $personel->services;
        return response()->json(PersonelServiceResource::collection($services));
    }

    public function getPersonelClocks(Personel $personel, Request $request)
    {
        $getDate = Carbon::parse($request->appointment_date);

        $disabledDays[] = $this->findTimes($personel, $getDate);
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
                if ($personel->checkDateIsOff($getDate)) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Personel bu tarihte hizmet vermemektedir"
                    ], 200);
                } else {
                    //tüm koşullar sağlanmış ise personel saat takvimi
                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                        if (!in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0])) {
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

    public function appointmentCreate(AppointmentCreateRequest $request)
    {
        $business = $this->business;

        $appointment = new Appointment();
        $appointment->customer_id = $request->customer_id;
        $appointment->business_id = $business->id;
        $appointment->save();
        $approve_types = [];

        foreach ($request->service_id as $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $request->personel_id;
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = Carbon::parse($request->start_time)->toDateTimeString();
            $appointmentService->end_time = Carbon::parse($request->end_time)->toDateTimeString();
            $appointmentService->appointment_id = $appointment->id;
            $approve_types[] = $findService->approve_type;

            if ($appointmentService->start_time >= $appointmentService->end_time) {
                $appointment->delete();
                $appointment->services()->delete();
                return response()->json([
                    'status' => "error",
                    'message' => "Başlangıç saati bitiş saatinden küçük olmalıdır",
                ]);
            }
            $result = $this->checkPersonelClock($request->personel_id, $appointmentService->start_time, $appointmentService->end_time);

            if ($result) {
                $appointment->services()->delete();
                $appointment->delete();
                return response()->json([
                    'status' => "error",
                    'message' => "Seçmiş olduğunuz saat aralığında randevu bulunmaktadır."
                ]);
            } else {
                $appointmentService->save();
            }
        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        $calculateTotal = $appointment->calculateTotal();
        $appointment->total = $calculateTotal;

        $appointment->status = 1; // Otomatik onay ise
        foreach ($appointment->services as $service) {
            $service->status = 1;
            $service->save();
        }

        if ($appointment->save()) {
            $message = $business->name . " İşletmesine " . $appointment->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu.";
            $appointment->customer->sendSms($message);
            return response()->json([
                'status' => "success",
                'message' => "Randevunuz başarılı bir şekilde oluşturuldu",
            ]);
        }
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

    public function findTimes($personel, $appointment_date)
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

        // randevu almaya 30 dk öncesine kadar izin ver
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
