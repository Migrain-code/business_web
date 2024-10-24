<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Requests\Appointment\AppointmentSummaryRequest;
use App\Http\Requests\Appointment\PersonelDateGetRequest;
use App\Http\Requests\Appointment\ServicePersonelGetRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessCustomer;
use App\Models\BusinessRoom;
use App\Models\BusinessService;
use App\Models\Customer;
use App\Models\CustomerNotificationPermission;
use App\Models\Personel;
use App\Models\PersonelRoom;
use App\Services\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group AppointmentCreate
 *
 */
class AppointmentCreateController extends Controller
{

    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    public function index()
    {
        $business = $this->business;
        //kadın türündeki hizmetleri
        $womanServicesArray = $business->services()->where('type', 1)->with('categorys')->get();
        $womanServiceCategories = $womanServicesArray->groupBy('categorys.name');
        $womanServices = $this->transformServices($womanServiceCategories);

        $manServicesArray = $business->services()->where('type', 2)->with('categorys')->get();
        $manServiceCategories = $manServicesArray->groupBy('categorys.name');
        $manServices = $this->transformServices($manServiceCategories);

        $unisexServicesArray = $business->services()->where('type', 3)->with('categorys')->get();
        $unisexServiceCategories = $unisexServicesArray->groupBy('categorys.name');
        $unisexServices = $this->transformServices($unisexServiceCategories);

        $rooms = $business->activeRooms;

        return view('business.appointment-create.index', compact('rooms', 'womanServices', 'manServices', 'unisexServices', 'business'));
    }

    /**
     *
     * Personel Listesi
     * @param Request $request
     * @return void
     */
    public function getPersonel(Request $request)
    {
        $roomPersonelIds = [];
        $getData = $request->services;


        $ap_services = [];
        foreach ($getData as $id) {
            $service = BusinessService::find($id);
            $business = Business::find($service->business_id);
            $selectedRoomId = $request->input('selectedRoomId');
            if ($request->has('selectedRoomId') && $selectedRoomId != "null") {
                $roomPersonelIds = PersonelRoom::where('business_id', $business->id)->where('room_id', $request->input('selectedRoomId'))->pluck('personel_id')->toArray();
            }
            $servicePersonels = [];
            foreach ($service->personels as $item) {
                if ($item->personel && $item->personel->status == 1) {
                    if ($request->filled('selectedRoomId') && $selectedRoomId != "null") {
                        if (in_array($item->personel->id, $roomPersonelIds)) {
                            $servicePersonels[] = [
                                'id' => $item->personel?->id . "_" . $service->id,
                                'name' => $item->personel?->name,
                            ];
                        }
                    } else {
                        $servicePersonels[] = [
                            'id' => $item->personel?->id . "_" . $service->id,
                            'name' => $item->personel?->name,
                        ];
                    }

                }

            }


            $ap_services[] = [
                'id' => $id,
                'title' => $service->subCategory->getName() . " için personel seçiniz",
                'personels' => $servicePersonels,
            ];
        }
        return response()->json($ap_services);
    }

    /**
     *
     * Müşteri Listesi
     * @param Request $request
     * @return JsonResponse
     */
    public function getCustomer(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $customers = $business->customers()->whereHas('customer', function ($q) use ($request) {
            $name = strtolower($request->input('searchedName'));
            $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
        })->take(20)->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    /**
     * Randevuda Müşteri Ekle
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function newCustomer(Request $request)
    {
        $phone = clearPhone($request->input('phone'));
        if (strlen($phone) != 11) {
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Telefon Numarasını 11 Haneli olarak giriş yapın"
            ]);
        }
        if ($this->existPhone($phone)) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı müşteri bulunuyor lütfen başka bir numara giriniz"
            ]);
        }
        $generatePassword = rand(100000, 999999);
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->phone = clearPhone($request->input('phone'));
        $customer->password = Hash::make($generatePassword);
        $customer->status = 1;
        $customer->verify_phone = 1;
        if ($customer->save()) {
            $message = "Merhaba ".$customer->name.", Hızlı Randevu'ya Hoşgeldiniz.
                        Giriş Bilgileriniz: Tel: ".$customer->phone." Şifre: ".$generatePassword."
                        İyi günler dileriz
                        ".$this->business->name."
                        (Hızlı Randevu)";
            //Sms::send($customer->phone, $message);
            $this->addPermission($customer->id);
            $this->addBusinessCustomerList($customer->id);
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    public function existPhone($phone)
    {
        $existPhone = Customer::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function addPermission($id)
    {
        $permission = new CustomerNotificationPermission();
        $permission->customer_id = $id;
        $permission->save();

        return $permission;
    }

    public function addBusinessCustomerList($id)
    {
        $businessCustomer = new BusinessCustomer();
        $businessCustomer->business_id = $this->business->id;
        $businessCustomer->customer_id = $id;
        $businessCustomer->type = 1;
        $businessCustomer->status = 1;
        $businessCustomer->save();
        return $businessCustomer;
    }

    /**
     *
     * Tarih Listesi
     * @param Request $request
     * @return void
     */
    public function getDate()
    {
        $i = 0;
        $remainingDate = [];

        while ($i <= 30) {
            $remainingDate[] = Carbon::now()->addDays($i);
            $i++;
        }

        foreach ($remainingDate as $date) {
            $dateStartOfDay = clone $date;
            $dateStartOfDay->startOfDay();

            $today = Carbon::now()->startOfDay();
            $tomorrow = Carbon::now()->addDays(1)->startOfDay();

            if ($dateStartOfDay->eq($today)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Bugün",
                    'month' => $date->translatedFormat('F'),
                    'text' => "Bugün",
                    'value' => $date->toDateString(),
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'month' => $date->translatedFormat('F'),
                    'value' => $date->toDateString(),
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'month' => $date->translatedFormat('F'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date->toDateString(),
                ];
            }
        }

        return response()->json([
            'dates' => $dates,
        ]);
    }

    /**
     *
     * Saat Listesi
     * @param Request $request
     * @return void
     */

    public function getClock(Request $request)
    {
        $getDate = Carbon::parse($request->date);
        $business = $this->business;
        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personelIds as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }
        $uniquePersonals = array_unique($personelIds);

        // personelleri gelen id lere göre db den collection olarak al
        $personels = [];
        foreach ($uniquePersonals as $id) {
            $personels[] = Personel::find($id);
        }
        $clocks = [];
        if (count($uniquePersonals) == 1) {
            foreach ($personels as $personel) {

                $disabledDays[] = $this->findTimes($personel, $request->room_id);
                if ($business->isClosed($request->date)) {
                    return response()->json([
                        'status' => "error",
                        'message' => "İşletme bu tarihte hizmet vermemektedir"
                    ]);
                }
                //işletme kapalı gün kontrolü
                if (isset($business->off_day) && Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
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
                            $checkCustomWorkTime = $personel->isCustomWorkTime($request->date);

                            if (isset($checkCustomWorkTime)) {
                                if (Carbon::parse($checkCustomWorkTime->start_time) < Carbon::parse($checkCustomWorkTime->end_time)) {
                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }
                                } else {
                                    $lastTime = "";
                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                        $lastTime = $i->format('H:i');
                                    }

                                    $newStartTime = $getDate->addDays(1);

                                    for ($i = $newStartTime; $i < Carbon::parse($newStartTime->toDateString() . $checkCustomWorkTime->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $i->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $i->format('d.m.Y'),
                                            'value' => $i->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($i->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }

                                }

                            } else {
                                if (Carbon::parse($personel->start_time) < Carbon::parse($personel->end_time)) {
                                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }
                                } else {
                                    $lastTime = "";
                                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                        $lastTime = $i->format('H:i');
                                    }

                                    $newStartTime = $getDate->addDays(1);

                                    for ($i = $newStartTime; $i < Carbon::parse($newStartTime->toDateString() . $personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $i->format('d_m_Y_H_i'),
                                            'saat' => $i->format('H:i'),
                                            'date' => $i->format('d.m.Y'),
                                            'value' => $i->format('d.m.Y H:i'),
                                            'durum' => in_array($i->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }

                                }

                            }


                        }

                    }
                }


            }

        } else { // birden fazla ve farklı personel seçilmişse
            if ($business->isClosed($request->date)) {
                return response()->json([
                    'status' => "error",
                    'message' => "İşletme bu tarihte hizmet vermemektedir"
                ]);
            }
            if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                $clocks[] = [
                    'id' => $getDate->format('d_m_Y_'),
                    'saat' => 'İşletme bu tarihte hizmet vermemektedir',
                    'date' => $getDate->format('d.m.Y'),
                    'value' => $getDate->format('d.m.Y '),
                    'durum' => false,
                ];
                return response()->json([
                    "status" => "error",
                    "message" => "İşletme bu tarihte hizmet vermemektedir"
                ], 200);
            } else {
                // işletme çalışma saatlerine randevu aralığına göre diziye ekle
                $businessClocks = [];
                for ($i = \Illuminate\Support\Carbon::parse($business->start_time); $i < \Illuminate\Support\Carbon::parse($business->end_time); $i->addMinute($business->range->time)) {
                    $businessClocks[] = $getDate->format('d.m.Y ' . $i->format('H:i'));
                }
                // personellerin dolu saatlerini bul
                $disabledClocks = [];
                foreach ($personels as $personel) {
                    $disabledClocks[] = $this->findTimes($personel, $request->room_id);
                }
                // diziyi tek boyuta düşür
                $flattenedArray = [];
                foreach ($disabledClocks as $subArray) {
                    $flattenedArray = array_merge($flattenedArray, $subArray);
                }
                // dizi deki aynı olan verileri kaldır
                $disabledTimes = array_unique($flattenedArray);

                // hizmetlerin sürelerini al ve toplam süreye ekle
                $totalMinute = 0;
                foreach ($serviceIds as $serviceId) {
                    $service = BusinessService::find($serviceId);
                    $totalMinute += $service->time;
                }
                $totalMinutes = $totalMinute;

                foreach ($businessClocks as $index => $clock) {

                    $i = Carbon::parse($clock);
                    $clocks[] = array(
                        'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                        'saat' => $i->format('H:i'),
                        'date' => $getDate->format('d.m.Y'),
                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                        // işletmenin çalışma saatleri ile personelin çalışma saatlerini karşılaştır aynı olanları false yap
                        'durum' => !in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledTimes),
                    );
                }
                $found = false;
                $startTime = null;
                $currentTime = null;
                $totalTime = 0;
                foreach ($clocks as $clock) {
                    if ($clock['durum']) {
                        if ($currentTime === null) {
                            $currentTime = Carbon::parse($clock['value']);
                            $startTime = $currentTime;
                        } else {
                            $nextTime = Carbon::parse($clock['value']);
                            $timeDifference = $nextTime->diffInMinutes($currentTime);
                            $totalTime += $timeDifference;

                            // Eğer toplam süre  60 dakika veya daha fazla ise, durumu false olarak ayarla
                            if ($totalTime >= $totalMinutes) {
                                $found = true;
                                break;
                            }

                            $currentTime = $nextTime;
                        }
                    } else {
                        $currentTime = null;
                        $totalTime = 0; // Boş alan başladığında toplam süreyi sıfırlayın
                    }
                }

                if (!$found) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Seçtiğiniz Hizmetler için uygun randevu aralığı bulunmamaktadır. Randevu Gününü,Personeli veya Hizmeti Değiştirerek Yeniden Saat Arayabilirsiniz."
                    ], 200);
                }
            }
        }
        return response()->json($clocks);


    }

    public function checkClock(Request $request)
    {
        $appointmentStartTime = Carbon::parse($request->appointment_time);
        $appointmentId = rand(100000, 999999);

        foreach ($request->services as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $request->personels[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->format('Y-m-d H:i:s');
            $appointmentService->appointment_id = $appointmentId;
            //$appointmentService->save();
            /**------------------Saat Kontrolü------------------*/
            $result = $this->checkPersonelClock($request->personels[$index], $appointmentService->start_time, $appointmentService->end_time, $request->room_id);

            if ($result) {
                return response()->json([
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ]);
            }
        }
        return response()->json([
            'status' => "success",
            'message' => "Saat seçim işleminiz onaylandı. Müşteri Seçebilirsiniz"
        ]);

    }

    public function findDisabledTimes($personel, $appointmentStartTime, $roomId)
    {
        $appointments = $personel->appointments()->whereDate('start_time', $appointmentStartTime->toDateString())->whereNotIn('status', [3])->get();
        $disabledTimes = [];
        foreach ($appointments as $appointment) {
            $startDateTime = $appointment->start_time;
            $endDateTime = $appointment->end_time;

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime < $endDateTime) {

                $disabledTimes[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }

        $business = $this->business;
        if (isset($roomId) && $roomId > 0) {
            // oda tipi seçilmşse o odadaki randevuları al ve disabled dizisine ata
            $appointmentsBusiness = $business->appointments()->where('room_id', $roomId)
                ->whereDate('start_time', $appointmentStartTime->toDateString())
                ->whereNotIn('status', [3])->get();
            foreach ($appointmentsBusiness as $appointment) {
                $businessStartDateTime = Carbon::parse($appointment->start_time);
                $businessEndDateTime = Carbon::parse($appointment->end_time);

                $businessCurrenDateTime = $businessStartDateTime->copy();
                while ($businessCurrenDateTime < $businessEndDateTime) {

                    $disabledTimes[] = $businessCurrenDateTime->format('d.m.Y H:i');

                    $businessCurrenDateTime->addMinutes(intval($business->range->time));
                }
            }
        }
        return $disabledTimes;
    }

    public function checkPersonelClock($personelId, $startTime, $endTime, $roomId)
    {

        $findPersonel = Personel::find($personelId);
        $disabledTimes = $this->findDisabledTimes($findPersonel, $startTime, $roomId);

        $disableds = [];
        $currentDateTime = $startTime->copy();

        while ($currentDateTime < $endTime) {
            $disableds[] = $currentDateTime->format('d.m.Y H:i');
            $currentDateTime->addMinutes(intval($findPersonel->appointmentRange->time));
        }
        $disabledConfig = [];
        foreach ($disableds as $disabledTime) {
            if (in_array($disabledTime, $disabledTimes)) {
                $disabledConfig[] = 1;
            } else {
                $disabledConfig[] = 0;
            }
        }

        return in_array(1, $disabledConfig);
    }

    public function findTimes($personel, $room_id)
    {
        $disableds = [];

        // personelin dolu randevu saatlerini al iptal edilmişleri de dahil et
        $appointments = $personel->appointments()->whereNotIn('status', [3])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = $appointment->start_time;
            $endDateTime = $appointment->end_time;

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
                while ($businessCurrenDateTime < $businessEndDateTime) {

                    $disableds[] = $businessCurrenDateTime->format('d.m.Y H:i');

                    $businessCurrenDateTime->addMinutes(intval($business->range->time));
                }
            }
        }
        return $disableds;
    }

    /**
     *
     * Randevu Oluştur
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function appointmentCreate(Request $request)
    {
        $request->validate([
            'customer_id' => "required",
        ], [], [
            'customer_id' => "Müşteri Seçimi",
        ]);
        $business = $this->business;

        $appointment = new Appointment();
        $appointment->customer_id = $request->customer_id;
        $appointment->business_id = $business->id;
        $appointment->room_id = $request->room_id;
        $appointment->save();

        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personel as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }

        $appointmentStartTime = Carbon::parse($request->clock);
        $approve_types = [];
        foreach ($serviceIds as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $personelIds[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time);
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->save();
            $result = $this->checkPersonelClock($personelIds[$index], $appointmentService->start_time, $appointmentService->end_time, $request->room_id);

            /*if ($result) {
                $appointment->services()->delete();
                $appointment->delete();
                return response()->json([
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ]);
            }*/
            $approve_types[] = $findService->approve_type;

        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        $calculateTotal = $appointment->calculateTotal();
        $appointment->total = $calculateTotal;
        if (in_array(1, $approve_types)) { // hizmet maneul onay ise
            $appointment->status = 0; // Otomatik onay
            foreach ($appointment->services as $service) {
                $service->status = 0;
                $service->save();
            }
            $message = $business->name . " İşletmesine Randevunuz talebiniz alınmıştır. İşletmemiz en kısa sürede sizi bilgilendirecektir.";

        } else {
            $appointment->status = 1; // Otomatik onay ise
            foreach ($appointment->services as $service) {
                $service->status = 1;
                $service->save();
            }
            $message = $business->name . " İşletmesine " . $appointment->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu.";

        }
        if ($appointment->save()) {
            $appointment->customer->sendSms($message);
            return to_route('business.appointment.index')->with('response', [
                'status' => "success",
                'message' => "Randevunuz başarılı bir şekilde oluşturuldu",
            ]);
        }

        return to_route('business.appointment.index')->with('response', [
            'status' => "error",
            'message' => "Bir hata sebebiyle randevunuz oluşturulamadı lütfen tekrar deneyiniz",
        ]);

    }


    function transformServices($womanServiceCategories)
    {
        $transformedDataWoman = [];
        foreach ($womanServiceCategories as $category => $services) {

            $transformedServices = [];
            foreach ($services as $service) {
                if ($service->personels->count() > 0) { //hizmeti veren personel sayısı birden fazla ise listede göster
                    $isActive = false;
                    foreach ($service->personels as $personelService) {
                        if (isset($personelService->personel) && $personelService->personel->status == 1) {
                            $isActive = true;
                        }
                    }
                    if ($isActive) {
                        $transformedServices[] = [
                            'id' => $service->id,
                            'name' => $service->subCategory->getName(),
                            'price' => $service->price_type_id == 0 ? $service->price : $service->price . " - " . $service->max_price,
                        ];
                    }

                }
            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
            ];
        }
        return $transformedDataWoman;
    }
}
