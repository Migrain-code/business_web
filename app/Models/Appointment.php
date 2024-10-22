<?php

namespace App\Models;

use App\Jobs\SendReminderJob;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int|null $business_id
 * @property int|null $customer_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int|null $status
 * @property float $total
 * @property int $discount
 * @property int|null $campaign_id
 * @property float $point
 * @property float $earned_point kazanılan puan
 * @property string|null $note
 * @property int $comment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_verify_phone
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\CustomerCashPoint|null $cashPoint
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentCollectionEntry> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentPhoto> $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentReceivable> $receivables
 * @property-read int|null $receivables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentServices> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCommentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEarnedPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereIsVerifyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use HasFactory;

    protected $casts = ['start_time' => "datetime", 'end_time' => "datetime"];

    const STATUS_LIST = [
        0 => [
            'html' => '<span class="badge badge-warning fw-bolder px-2 py-2" style="color:#fff04f">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            "color" => "#fff04f"
        ],
        1 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            "color" => "#6aab73"
        ],
        2 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            "color" => "#4a7750"
        ],
        3 => [
            'html' => '<span class="badge badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            "color" => "#bf0d36"
        ],
        4 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Gelmedi</span>',
            'text' => 'Gelmedi',
            "color" => "#bf0d36"
        ],
        5 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Geldi</span>',
            'text' => 'Geldi',
            "color" => "#4a7750"
        ],
        6 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Tahsilatsız Kapatıldı</span>',
            'text' => 'Tahsilatsız Kapatıldı',
            "color" => "#2f4aaf"
        ],

    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri"
        ]);
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'id', 'campaign_id');
    }

    public function room()
    {
        return $this->hasOne(BusinessRoom::class, 'id', 'room_id');
    }

    public function services()
    {
        return $this->hasMany(AppointmentServices::class, 'appointment_id', 'id')->orderBy('start_time');
    }

    public function payments()
    {
        return $this->hasMany(AppointmentCollectionEntry::class, 'appointment_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(AppointmentPhoto::class, 'appointment_id', 'id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function cashPoint()
    {
        return $this->hasOne(CustomerCashPoint::class, 'appointment_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'appointment_id', 'id');
    }

    public function receivables()
    {
        return $this->hasMany(AppointmentReceivable::class, 'appointment_id', 'id');
    }

    public function addCashPoint()
    {
        if (isset($this->cashPoint)) {
            return false;
        }

        $customerCashPoint = new CustomerCashPoint();
        $customerCashPoint->appointment_id = $this->id;
        $customerCashPoint->customer_id = $this->customer_id;
        $customerCashPoint->business_id = $this->business_id;
        $customerCashPoint->price = $this->earned_point;
        $customerCashPoint->addition_date = now();
        if ($customerCashPoint->save()) {
            return true;

        }
    }

    public function scheduleReminder()
    {
        // Randevu başlangıç saatinden hatırlatma zamanını hesaplayın
        $reminderTime = $this->start_time->subMinutes($this->business->reminder_time);

        // Job'u dispatch et ve job ID'sini alın
        $job = new SendReminderJob($this);
        $jobId = app('queue')->push($job->delay($reminderTime));

        // Job ID'sini randevu kaydına kaydedin
        $this->job_id = $jobId;
        $this->save();
    }

    public function setStatus($statusCode = 1)
    {
        $appointment = $this;
        $appointment->status = $statusCode;
        $appointment->save();
        foreach ($appointment->services as $service) {
            $service->status = $statusCode;
            $service->save();
        }
    }

    public function setClocks()
    {
        $appointment = $this;
        //randevular tablosunda hizmetlerin başlangıç ve bitiş süresini hesaplayıp ekliyoruz.
        $appointment->start_time = $appointment->services()->first()->start_time;
        //hizmetlerdeki son hizmeti alıyoruz ve kayıt ediyoruz.
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        $appointment->save();
    }

    public function setStartTime($request)
    {
        if ($request->appointment_type == "addissionCreate"){ // tür adisyon oluşturma ise
            // randevu tarihi ile seçilen saati birleştirip başlangıç tarihi ve saati oluştur
            $appointmentStartTime = Carbon::parse($request->appointment_date." ".$request->start_time);
        } else{
            // normal randevu ise formdan seçilen start_time verisini kullan
            $appointmentStartTime = Carbon::parse($request->start_time);
        }
        return $appointmentStartTime;
    }
    public function setApproveType($request)
    {
        if ($request->appointment_type == "addissionCreate"){
            $this->setStatus(5);
        } else{
            // Manuel onay ve saat kapatma ise randevu onay bekliyor durumuna gelir
            if ($this->business->approve_type == 1 && $request->appointment_type == "closeClock") {
                $this->setStatus(0); // Onay bekliyor durumu
            } else {
                // randevu otomatik onay ise direk onaylanır
                $this->setStatus(1); // onaylandı durumu
            }
        }
    }

    public function sendMessages($sendCustomerSms = true, $sendCustomerNotification = true, $sendPersonelNotification = true, $sendBusinessNotification = true)
    {
        $title = "Randevunuz başarılı bir şekilde oluşturuldu";
        $message = $this->business->name . " İşletmesine " . $this->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu.";

        if ($sendCustomerSms) {
            $this->customer->sendSms($message);
        }

        if ($sendCustomerNotification) {
            $this->customer->sendNotification($title, $message);
        }

        if ($sendPersonelNotification) {
            $this->sendPersonelNotification();
        }

        if ($sendBusinessNotification) {
            // Business notification fonksiyonunuzu burada çağırın
            // Örneğin:
            // $this->business->sendNotification($title, $message);
        }
    }

    public function setServices($request, $personel, $appointmentStartTime)
    {
        $appointment = $this;
        foreach ($request->service_id as $serviceId) {//seçilen hizmetleri döngüye al
            $findService = BusinessService::find($serviceId); //seçilen hizmeti tabloda bul
            $appointmentService = new AppointmentServices(); // randevunun hizmet kaydını başlat
            $appointmentService->personel_id = $personel->id; // hangi personel seçilmişse fonksiyonun ilk parametresi
            $appointmentService->service_id = $serviceId; // dizideki index hizmet id'si
            $appointmentService->start_time = $appointmentStartTime->toDateTimeString(); // yukarıda belirlediğimiz başlangıç saati
            $appointmentService->appointment_id = $appointment->id; // yukarıda kaydını aldığımız randevu id ' si
            if ($request->appointment_type == "closeClock") { // saat kapatma ise
                //burada belirli saat aralığı kapatılacağı için direk seçilen bitiş süresini atama yapıyoruz
                $appointmentService->end_time = Carbon::parse($request->end_time)->toDateTimeString();
                if ($appointmentService->start_time >= $appointmentService->end_time) {
                    // başlngıç tarihi bitiş tarihinden büyükse randevuyu kaldırıyoruz. ve uyarı basıyoruz.
                    $appointment->delete();
                    $appointment->services()->delete();
                    return [
                        'status' => "error",
                        'message' => "Başlangıç saati bitiş saatinden küçük olmalıdır",
                    ];
                }
                $result = $this->checkPersonelClock($personel->id, $appointmentService->start_time, $appointmentService->end_time);
                // randevu türü saat kapatma olduğundan başlangıç ve bitiş aralığında başka randevu varmı diye sisteme kontrol yapıtıyoruz
                if ($result) {
                    $appointment->services()->delete();
                    $appointment->delete();
                    return [
                        'status' => "error",
                        'message' => "Seçmiş olduğunuz saat aralığında randevu bulunmaktadır."
                    ];
                } else {
                    //yoksa saat kapatmada hizmetleri kayıt ediyoruz
                    $appointmentService->save();
                }
            } else { // normal randevu ise
                // hizmetin bitiş süresine yukarıda arttırma yaptığımız başlangıç saatine hizmetin süresi kadar ekleme yapıyoruz.
                $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->toDateTimeString();
                $appointmentService->save();
            }

        }
    }

    public function sendPersonelNotification($title = "Yeni Bir Ranevunuz var", $message = "Müşteriniz %s, %s tarihinde %s hizmetiniz için bir randevu aldı.")
    {
        foreach ($this->services as $service){
            $personelNotification = new PersonelNotification();
            $personelNotification->business_id = $this->business_id;
            $personelNotification->personel_id = $service->personel_id;
            $personelNotification->title = $service->personel->name. " ". $title;
            $personelNotification->message = sprintf(
                $message,
                $this->customer->name,
                $service->start_time->format('d.m.Y H:i'),
                $service->service->subCategory->getName()
            );
            $personelNotification->link = uniqid();
            $personelNotification->save();

            if (isset($service->personel->device)){
                NotificationService::sendPushNotification($service->personel->device->token, $personelNotification->title, $personelNotification->message);
            }
        }
    }

    public function sendPersonelCreateNotification() //personel randevu oluştuduğunda işletme sahibine bildirim gönder
    {
        $official = $this->business->official;
        if (isset($official) && isset($official->devicePermission)){

            if ($official->devicePermission->is_personel == 1){
                //herkese alınan randevular için bildirimler
                foreach ($this->services as $service){
                    $title = "Personeliniz Bir Randevu Oluşturdu";
                    $message = sprintf(
                        '%s adlı Personeliniz %s adlı müşterinize, %s tarihine %s hizmetine randevu oluşturdu.',
                        $service->personel->name,
                        $this->customer->name,
                        $service->start_time->format('d.m.Y H:i'),
                        $service->service->subCategory->getName()
                    );
                    $official->sendNotification($title, $message);
                }
            }
        }

    }
    /** ------------------------- Calculate Area ----------------------------- **/
    public function setPrice()
    {
        $calculateTotal = $this->totalServiceAndProduct();
        $this->total = $calculateTotal;
        $this->save();
    }
    public function calculateAppointmentEarnedPoint()
    {
        $promossion = $this->business->promossions;
        $discountRate = 0;
        $discountRate = $promossion->cash;

        //dd($discountRate);
        $discountTotal = ($this->calculateTotal() * $discountRate) / 100;
        return $discountTotal;

    }

    public function calculateTotal() // toplam hizmet hiyatı
    {
        $total = 0;
        $rangePrice = false;
        foreach ($this->services as $service) {
            $servicePrice = $service->servicePrice();

            if (is_numeric($servicePrice) && is_numeric($total)){
                $total+= $servicePrice;
            } else{
                $rangePrice = true;
                $total = "Hesaplanacak";
            }
        }
        if ($rangePrice){
            return $total;
        }
        return $total;
    }

    function totalServiceAndProduct()
    { // toplam ürün ve hizmet satışı
        if (is_numeric($this->calculateTotal())){
            return $this->calculateTotal() + $this->sales->sum('total');
        }
        return 0;
    }

    public function calculateCampaignDiscount()
    { //kampanya indirimi
        $total = (($this->totalServiceAndProduct() * $this->discount) / 100);
        return $total;
    }

    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = $this->totalServiceAndProduct() - $this->calculateCampaignDiscount() - $this->point;
        return $total;
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
