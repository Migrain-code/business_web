<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int|null $appointment_id
 * @property int|null $personel_id
 * @property int|null $service_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Appointment|null $appointment
 * @property-read \App\Models\Personel|null $personel
 * @property-read \App\Models\BusinessService|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentServices whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentServices extends Model
{
    use HasFactory;
    protected $casts=['start_time' => "datetime", 'end_time' => "datetime"];

    const STATUS_LIST=[
        0 => [
            'html' => '<span class="badge badge-warning fw-bolder px-2 py-2" style="color:#fff04f">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            'color_code' => "warning"
        ],
        1 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            'color_code' => "primary"
        ],
        2 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            'color_code' => "success"
        ],
        3 => [
            'html' => '<span class="badge badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            'color_code' => "danger"
        ],
        4 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Gelmedi</span>',
            'text' => 'Gelmedi',
            'color_code' => "danger"
        ],
        5 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Geldi</span>',
            'text' => 'Geldi',
            'color_code' => "success"
        ],
        6 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Tahsilatsız Kapatıldı</span>',
            'text' => 'Tahsilatsız Kapatıldı',
            'color_code' => "warning"
        ],

    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }
    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }
    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }

    public function getPersonelPrice()
    {
        return $this->hasOne(PersonelCustomerPriceList::class ,'business_service_id', 'service_id')->where('personel_id', $this->personel_id);
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }

    public function servicePrice()
    {
        $service = $this->service;
        $personnelPrice = $this->getPersonelPrice;
        $room = $this->appointment->room ?? null;

        if ($this->isIntervalPrice($service)) {
            return $this->formatPriceRange($service);
        } else {
            if ($this->total > 0) {
                $servicePrice = $this->adjustPriceByRoom($this->total, $room);
            } else {
                $basePrice = $personnelPrice->price ?? $service->price;
                $servicePrice = $this->adjustPriceByRoom($basePrice, $room);
            }
        }

        return $servicePrice;
    }

    private function isIntervalPrice($service)
    {
        return $service->price_type_id == 1 && $this->total == 0;
    }

    private function formatPriceRange($service)
    {
        return $service->price . " - ". $service->max_price;
    }

    private function adjustPriceByRoom($basePrice, $room)
    {
        if ($room && $room->increase_type !== null) {
            if ($room->increase_type == 0) {
                return $basePrice + $room->price; // TL fiyat arttırma
            } else {
                return $basePrice + (($basePrice * $room->price) / 100); // Yüzde fiyat arttırma
            }
        }

        return $basePrice;
    }
}
