<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 *
 *
 * @property int $id
 * @property int $is_admin
 * @property string|null $company_id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string $password
 * @property int $password_status
 * @property string $verify_phone
 * @property int $business_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\OfficialCreatidCard|null $card
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OfficialCreatidCard> $cards
 * @property-read int|null $cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\BusinessNotificationPermission|null $permission
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial wherePasswordStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessOfficial whereVerifyPhone($value)
 * @mixin \Eloquent
 */
class BusinessOfficial extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = ['official'];

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function cards()
    {
        return $this->hasMany(OfficialCreatidCard::class, 'official_id', 'id')->latest('is_default');
    }

    public function card()
    {
        return $this->hasOne(OfficialCreatidCard::class, 'official_id', 'id');
    }
    public function permission()
    {
        return $this->hasOne(BusinessNotificationPermission::class, 'business_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(BusinessNotification::class, 'business_id', 'id');
    }

    public function supportRequests()
    {
        return $this->hasMany(SupportRequest::class, 'user_id', 'id');
    }
}
