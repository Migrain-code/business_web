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
    protected $dates=['start_time', 'end_time'];

    const STATUS_LIST=[
        0 => [
            'html' => '<span class="badge light badge-warning fw-bolder px-2 py-2">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            'color_code' => "warning"
        ],
        1 => [
            'html' => '<span class="badge light badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            'color_code' => "primary"
        ],
        2 => [
            'html' => '<span class="badge light badge-info fw-bolder px-2 py-2">Randevu Zamanı</span>',
            'text' => 'Randevu Zamanı',
            'color_code' => "info"
        ],
        3 => [
            'html' => '<span class="badge badge-outline-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            'color_code' => "success"
        ],
        4 => [
            'html' => '<span class="badge badge-outline-info fw-bolder px-2 py-2">Ödeme Alındı</span>',
            'text' => 'Ödeme Alındı',
            'color_code' => "info"
        ],
        5 => [
            'html' => '<span class="badge light badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            'color_code' => "danger"
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

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
