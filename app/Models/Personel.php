<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int|null $safe
 * @property int $status 0 => passive 1=> active
 * @property string $name
 * @property string|null $image
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property int|null $accept
 * @property int $rest_day
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $food_start
 * @property string|null $food_end
 * @property string $gender
 * @property int $rate
 * @property int $product_rate
 * @property string $range
 * @property string|null $description
 * @property int $accepted_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AppointmentRange|null $appointmentRange
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentServices> $appointments
 * @property-read int|null $appointments_count
 * @property-read \App\Models\Business|null $business
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessCost> $costs
 * @property-read int|null $costs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelRestDay> $restDays
 * @property-read int|null $rest_days_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelService> $services
 * @property-read int|null $services_count
 * @property-read \App\Models\PersonelStayOffDay|null $stayOffDays
 * @property-read \App\Models\BusinnessType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Personel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereAccept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereAcceptedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereFoodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereFoodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereProductRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereRestDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereSafe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Personel extends Authenticatable
{
    use HasFactory, Notifiable;

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'gender');
    }
    public function appointmentRange()
    {
        return $this->hasOne(AppointmentRange::class, 'id', 'range');
    }
    public function services()
    {
        return $this->hasMany(PersonelService::class, 'personel_id', 'id');
    }
    public function costs()
    {
        return $this->hasMany(BusinessCost::class, 'personel_id', 'id');
    }
    public function notifications()
    {
        return $this->hasMany(PersonelNotification::class, 'personel_id', 'id')->orderBy('created_at')->take(5);
    }
    public function restDays()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id')->where('status', 1);
    }
    public function restDayAll()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id');
    }
    public function appointments()
    {
        return $this->hasMany(AppointmentServices::class, 'personel_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'personel_id', 'id');
    }

    public function packages()
    {
        return $this->hasMany(PackageSale::class, 'personel_id', 'id');
    }

    public function getMonthlyPackageSales()
    {
        $sales = [];
        for ($i = 1; $i <= 12; $i++){
            $sales[]= $this->packages()->whereMonth('seller_date', $i)->count();
        }
        return $sales;
    }
    public function getMonthlyProductSales()
    {
        $sales = [];
        for ($i = 1; $i <= 12; $i++){
            $sales[]= $this->sales()->whereMonth('created_at', $i)->sum('piece');
        }
        return $sales;
    }
    public function stayOffDays()
    {
        return $this->hasMany(PersonelStayOffDay::class, 'personel_id', 'id');
    }
    /*public function checkDateIsOff($getDate)
    {
        // stayOffDays ilişkisini kullanarak izin tarihlerini alıyoruz.
        $offDays = $this->stayOffDays;

        if ($getDate >= $offDays->start_time && $getDate <= $offDays->end_time) {
            return true;
        }
        // Eğer tarih izin tarihleri arasında değilse,false döndürüyoruz.
        return false;
    }*/
    protected static function booted()
    {
        static::deleted(function ($personel) {
            $personel->notifications()->delete();
            $personel->restDays()->delete();
            $personel->services()->delete();
        });
    }
}
