<?php

namespace App\Http\Controllers\Business\Personel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonalAddRequest;
use App\Http\Requests\Personel\PersonalUpdateRequest;
use App\Http\Requests\Personel\PersonelCostAddRequest;
use App\Http\Requests\Personel\PersonelNotificationAddRequest;
use App\Http\Requests\Personel\PersonelStayOffDayAddRequest;
use App\Models\AppointmentRange;
use App\Models\BusinessCost;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelNotification;
use App\Models\PersonelNotificationPermission;
use App\Models\PersonelRestDay;
use App\Models\PersonelRoom;
use App\Models\PersonelService;
use App\Models\PersonelStayOffDay;
use App\Services\Sms;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

/**
 * @group PersonelInfo
 *
 * */
class PersonelController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(['permission:case.view'])->only(['case']);
        $this->middleware(['permission:cost.view'])->only(['payments']);

        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }

    /**
     * Personel Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('business.personel.index');
    }

    public function create()
    {
        $personelCount = Session::get('personelCount');
        if(isset($personelCount)){
            if ($personelCount == $this->business->personels->count() || $this->business->personels->count() > $personelCount){
                abort(403);
            }
        }
        $dayList = DayList::all();
        $services = $this->business->services;
        $ranges = AppointmentRange::all();
        $types = BusinnessType::all();
        return view('business.personel.create.index', compact('dayList', 'services', 'ranges', 'types'));
    }

    public function existPhone($phone)
    {
        $existPhone = Personel::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Personel Ekle
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonalAddRequest $request)
    {
        if ($this->existPhone(clearPhone($request->phone))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı personel bulunmakta"
            ]);
        }
        $personel = new Personel();
        $personel->business_id = $this->business->id;
        $personel->name = $request->input('name');
        $personel->image = "business/team.png";
        $personel->email = $request->email;
        $personel->password = Hash::make($request->password);
        $personel->phone = clearPhone($request->phone);
        $personel->accepted_type = $request->approve_type;
        //$personel->accept = $request->accept;
        if ($request->filled('is_case')) {
            $personel->safe = boolval($request->is_case);
        } else {
            $personel->safe = 0;
        }
        $personel->start_time = $request->start_time;
        $personel->end_time = $request->end_time;
        $personel->food_start = $request->food_start_time;
        $personel->food_end = $request->food_end_time;
        $personel->gender = $request->gender_type;
        if (authUser()->hasPermissionTo('case.view')) {
            $personel->product_rate = $request->product_rate;
            $personel->rate = $request->rate;
        }
        $personel->range = $request->range;
        $personel->description = $request->description;
        $personel->rest_day = 0;
        $dayList = DayList::all();

        if ($request->hasFile('avatar')) {
            $response = UploadFile::uploadFile($request->file('avatar'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            $this->savePermission($personel->id);
            foreach ($dayList as $day) {
                $restDay = new PersonelRestDay();
                $restDay->personel_id = $personel->id;
                $restDay->day_id = $day->id;
                $restDay->status = isset($request->restDay) ? in_array($day->id, $request->restDay) ? 1 : 0 : 0;
                $restDay->save();
            }

            foreach ($request->services as $service) {
                $personelService = new PersonelService();
                $personelService->service_id = $service;
                $personelService->personel_id = $personel->id;
                $personelService->save();
            }
            $message = "Hızlı Randevu sistemine personel kaydınız tamamlandı. Hesabınıza bu https://hizliappy.com/personel/login linkten girebilirsiniz. Kullanıcı bilgileriniz telefon numaranız: ". $personel->phone. " Şifreniz: ". $request->password;
            Sms::send($personel->phone, $message);

            if ($request->ajax()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Personel Kayıt Edildi",
                ]);
            }
            return to_route('business.personel.index')->with('response', [
                'status' => "success",
                'message' => "Personel Kayıt Edildi",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Personel Eklenirken Bir Hata Oluştu Lütfen Tekrar Deneyin",
        ]);
    }

    public function savePermission($personelId): void
    {
        $notificationPermission = new PersonelNotificationPermission();
        $notificationPermission->personel_id = $personelId;
        $notificationPermission->save();
    }

    /**
     * Personel Detayı
     *
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function show(Personel $personel)
    {
        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);

        return view('business.personel.edit.appointment.index', compact('personel', 'insideBalance'));
    }

    /**
     * Personel Düzenle
     *
     * @param Personel $personel
     */
    public function edit(Personel $personel)
    {

        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        $appointments = $personel->appointments()->whereDate('start_time', now())->get();
        $packageSales = $personel->packages()->whereDate('seller_date', now()->toDateString())->get();
        $productSales = $personel->sales()->whereDate('created_at', now()->toDateString())->get();

        return view('business.personel.edit.index', compact('packageSales', 'productSales', 'insideBalance', 'personel', 'appointments'));
    }

    /**
     * Personel Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function update(PersonalUpdateRequest $request, Personel $personel)
    {
        if ($personel->phone != clearPhone($request->phone)) {
            if ($this->existPhone(clearPhone($request->phone))) {
                return response()->json([
                    'status' => "error",
                    'message' => "Bu telefon numarası ile kayıtlı personel bulunmakta"
                ]);
            }
        }
        if($request->has('salons')){
           $personel->rooms()->delete();

           foreach ($request->salons as $salonId){
               $personelRoom = new PersonelRoom();
               $personelRoom->business_id = $this->business->id;
               $personelRoom->personel_id = $personel->id;
               $personelRoom->room_id = $salonId;
               $personelRoom->save();
           }

        }
        $personel->business_id = $this->business->id;
        $personel->name = $request->input('name');
        $personel->email = $request->email;
        if ($request->filled('password')) {
            $personel->password = Hash::make($request->password);
        }
        $personel->phone = clearPhone($request->phone);
        $personel->accepted_type = $request->approve_type;
        if ($request->filled('is_case')) {
            $personel->safe = boolval($request->is_case);
        } else {
            $personel->safe = 0;
        }
        $personel->start_time = $request->start_time;
        $personel->end_time = $request->end_time;
        $personel->food_start = $request->food_start_time;
        $personel->food_end = $request->food_end_time;
        $personel->gender = $request->gender_type;

        if (authUser()->hasPermissionTo('case.view')) {
            $personel->product_rate = $request->product_rate;
            $personel->rate = $request->rate;
        }
        $personel->range = $request->range;
        $personel->description = $request->description;
        $personel->rest_day = 0;
        $personel->safe_gender = $request->input('is_case_gender');
        if ($request->hasFile('avatar')) {
            $response = UploadFile::uploadFile($request->file('avatar'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            if (isset($request->restDay)){
                $this->saveRestDay($personel, $request->restDay);
            } else{
                $this->saveRestDay($personel, []);
            }

            return to_route('business.personel.setting', $personel->id)->with('response', [
                'status' => "success",
                'message' => "Personel Bilgileri Güncellendi",
            ]);
        }

    }

    public function services(Personel $personel)
    {
        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        $services = $this->business->services;
        return view('business.personel.edit.services.index', compact('personel', 'insideBalance', 'services'));
    }

    public function updateServices(Request $request, Personel $personel)
    {
        $this->saveService($personel, $request->services);
        return back()->with('response', [
            'status' => "success",
            'message' => "Personelin Hizmetleri Güncellendi"
        ]);
    }

    public function saveRestDay($personel, $restDayId): void
    {
        $this->checkDayControl($personel);
        $personel->restDayAll()->update(['status' => 0]);

        foreach ($restDayId as $day_id) {
            $restDay = $personel->restDayAll()->where('day_id', $day_id)->first();
            if ($restDay) {
                $restDay->status = 1;
                $restDay->save();
            } else {
                $restDay->status = 0;
                $restDay->save();
            }

        }
    }

    public function checkDayControl($personel): void
    {
        if ($personel->restDayAll->count() == 0) {
            $dayList = DayList::all();
            foreach ($dayList as $day) {
                $newRestDay = new PersonelRestDay();
                $newRestDay->personel_id = $personel->id;
                $newRestDay->day_id = $day->id;
                $newRestDay->status = 0;
                $newRestDay->save();
            }
        }

    }

    public function saveService($personel, $services): void
    {
        foreach ($services as $serviceId) {
            $existPersonelService = $personel->services()->where('service_id', $serviceId)->first();
            if (!$existPersonelService) {
                $personelService = new PersonelService();
                $personelService->service_id = $serviceId;
                $personelService->personel_id = $personel->id;
                $personelService->save();
            }
        }
        $personel->services()->whereNotIn('service_id', $services)->delete();
    }

    /**
     * Personel Sil
     *
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personel $personel)
    {
        if ($personel) {
            $personel->delete();
            return response()->json([
                'status' => "success",
                'message' => "Personel Silindi",
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Personel Bulunamadı",
        ]);
    }

    public function stayOffDays(Personel $personel)
    {
        $stayOffDays = $personel->stayOffDays;

        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        return view('business.personel.edit.stay-off-day.index', compact('stayOffDays', 'personel', 'insideBalance'));

    }

    public function addStayOffDays(PersonelStayOffDayAddRequest $request, Personel $personel)
    {
        if ($this->checkStayOffDayControl($personel->id, $request->start_time, $request->end_time)) {
            return response()->json([
                'status' => "error",
                'message' => "Bu Tarihlerde " . $personel->name . " Personeline İzin Eklediniz. Personeli Listeden Çıkarıp Sonradan Sadece Bu Personeli Seçerek Ekleyebilirsiniz.",
            ]);
        }

        $personelStayOffDay = new PersonelStayOffDay();
        $personelStayOffDay->business_id = $this->business->id;
        $personelStayOffDay->personel_id = $personel->id;
        $personelStayOffDay->start_time = $request->start_time;
        $personelStayOffDay->end_time = $request->end_time;
        $personelStayOffDay->save();
        if ($personelStayOffDay->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Personele İzin Eklendi.",
            ]);
        }

    }

    public function checkStayOffDayControl($personel_id, $secilen_tarih_baslangic, $secilen_tarih_bitis)
    {
        return PersonelStayOffDay::where('personel_id', $personel_id)
            ->where(function ($query) use ($secilen_tarih_baslangic, $secilen_tarih_bitis) {
                $query->whereBetween('start_time', [$secilen_tarih_baslangic, $secilen_tarih_bitis])
                    ->orWhereBetween('end_time', [$secilen_tarih_baslangic, $secilen_tarih_bitis]);
            })
            ->exists();
    }

    public function notifications(Personel $personel)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();

        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        $monthNotifications = $personel->notifications()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $yearNotifications = $personel->notifications()->whereBetween('created_at', [$startOfYear, $endOfYear])->get();
        $weekNotifications = $personel->notifications()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $dayNotifications = $personel->notifications()->whereDate('created_at', now()->toDateString())->get();

        return view('business.personel.edit.notification.index', compact('personel', 'insideBalance', 'dayNotifications', 'weekNotifications', 'monthNotifications', 'yearNotifications'));
    }

    /**
     * Personel Bildirim
     *
     * örnek : {
     * "title": "Test Bildirimi app",
     * "message": "Test Bildirimi app içerik",
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotify(Personel $personel, PersonelNotificationAddRequest $request)
    {
        $lastNotify = $personel->notifications()->latest()->first();

        if ($lastNotify && now()->diffInMinutes($lastNotify->created_at) < 3) {
            return response()->json([
                'status' => "error",
                'message' => "Yeni Bildirim Göndermek için 3 Dakikada Beklemeniz Gerekmektedir",
            ]);
        } else {
            $personelNotification = new PersonelNotification();
            $personelNotification->title = $request->title;
            $personelNotification->message = $request->message;
            $personelNotification->personel_id = $personel->id;
            $personelNotification->business_id = $this->business->id;
            $personelNotification->link = uniqid(20);
            if ($personelNotification->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Personellere Bildirim Gönderildi",
                ]);
            }
            return response()->json([
                'status' => "error",
                'message' => "Sistemsel Bir Hata Oluştu Lütfen Sayfayı Yenileyin",
            ]);
        }


    }

    public function payments(Personel $personel)
    {
        $payments = $this->calculatePayedBalance($personel);
        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        $paymentTypes = BusinessCost::PAYMENT_TYPES;
        return view('business.personel.edit.payment.index', compact('personel', 'payments', 'insideBalance', 'paymentTypes'));
    }

    public function setting(Personel $personel)
    {
        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        $dayList = DayList::all();
        $services = $this->business->services;
        $ranges = AppointmentRange::all();
        $types = BusinnessType::all();
        $roomIds = $personel->rooms()->pluck('room_id')->toArray();

        return view('business.personel.edit.setting.index', compact('personel', 'insideBalance', 'dayList', 'services', 'ranges', 'types', 'roomIds'));
    }

    public function paymentsAdd(PersonelCostAddRequest $request, Personel $personel)
    {
        $cost = new BusinessCost();
        $cost->business_id = $this->business->id;
        $cost->cost_category_id = 1;
        $cost->personel_id = $personel->id;
        $cost->payment_type_id = $request->paymentType;
        $cost->price = $request->price;
        $cost->operation_date = $request->operationDate;
        $cost->description = $request->description;
        $cost->note = $request->note;
        if ($cost->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Ödeme Barşarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Personel Kasası
     *
     * listType değişkeninde gönderilecek
     * <ul>
     *     <li>yesterday</li>
     *     <li>thisWeek</li>
     *     <li>thisMonth</li>
     * </ul>
     * @param Personel $personel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function case(Personel $personel, Request $request)
    {
        $appoinments = $personel->appointments()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('start_time', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('start_time', now()->subDays(1)->toDateString());
            }
        })->get();
        $servicePrice = 0;
        foreach ($appoinments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $hizmetHakedis = $servicePrice - ($servicePrice * $personel->rate) / 100;
        $productPrice = $personel->sales()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('created_at', now()->subDays(1)->toDateString());
            }
        })->sum('total');

        $urunHakedis = $productPrice - (($productPrice * $personel->product_rate) / 100);

        $totalCiro = number_format($servicePrice + $productPrice, 2);
        $progressPayment = number_format($hizmetHakedis + $urunHakedis, 2);
        $insideBalance = number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'), 2);
        $balancePayed = number_format($this->calculatePayedBalance($personel)->sum('price'), 2);

        return view('business.personel.edit.case.index', compact('personel', 'totalCiro', 'progressPayment', 'insideBalance', 'balancePayed'));

    }

    public function totalBalance($personel)
    {
        $productPrice = $personel->sales->sum('total');
        $servicePrice = 0;
        foreach ($personel->appointments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $hizmetHakedis = $servicePrice - ($servicePrice * $personel->rate) / 100;
        $urunHakedis = $productPrice - (($productPrice * $personel->product_rate) / 100);

        return $hizmetHakedis + $urunHakedis;
    }

    public function calculatePayedBalance($personel)
    {
        $costs = $personel->costs()->where('cost_category_id', 1)->get();
        return $costs;
    }

    public function datatable(Request $request)
    {
        $personelCount = Session::get('personelCount');
        if (isset($personelCount)){
            $personels = $this->business->personels()->take($personelCount)->get();
        } else{
            $personels = $this->business->personels;
        }

        return DataTables::of($personels)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'Personel', 'Personelleri', '', false);
            })
            ->editColumn('name', function ($q) {
                return createName(route('business.personel.edit', $q->id), $q->name);
            })
            ->editColumn('phone', function ($q) {
                return createPhone($q->phone, formatPhone($q->phone));
            })
            ->editColumn('safe', function ($q) {
                return create_switch($q->id, $q->safe == 1 ? true : false, 'Personel', 'safe', 'Kasa Yetkisi Verilsin mi?');
            })
            ->editColumn('start_time', function ($q) {
                return $q->start_time . " - " . $q->end_time;
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'Personel', 'status', 'Personel Randevu Alabilsin mi?');
            })
            ->addColumn('range', function ($q) {
                return $q->appointmentRange->time . " .DK";
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.personel.edit', $q->id));
                $html .= create_delete_button('Personel', $q->id, 'Personel', 'Personel Kaydını Silmek İstediğinize Eminmisiniz? Personelin sadece kişisel kayıtları silinecektir.', 'false', '/isletme/ajax/delete/object', false);

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
