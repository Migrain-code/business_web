<?php

namespace App\Models;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
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
    public function devicePermission()
    {
        return $this->hasOne(BusinessDeviceNotificationPermission::class, 'business_id', 'id');
    }
    public function device()
    {
        return $this->hasOne(Device::class, 'customer_id', 'id')->where('type', 3);
    }
    public function notifications()
    {
        return $this->hasMany(BusinessNotification::class, 'business_id', 'id');
    }
    public function menuNotifications()
    {
        return $this->notifications()->where('status', 0)->latest()->take(10);
    }
    public function supportRequests()
    {
        return $this->hasMany(SupportRequest::class, 'user_id', 'id');
    }

    public function sendWelcomeMessage()
    {
        $notification = new BusinessNotification();
        $notification->business_id = $this->id;
        $notification->type = 0;
        $notification->title = "Merhaba ". $this->name;
        $notification->message = "
                Hızlı Randevu Rezervasyon Programımıza hoş geldiniz! Kaydınız başarıyla tamamlandı ve artık sistemimizi kullanmaya hazırsınız.
                Programımızı kullanarak kolayca randevu oluşturabilir, mevcut randevularınızı görüntüleyebilir ve yönetebilirsiniz. Ayrıca, size uygun olan tarih ve saatlerde randevu hatırlatıcıları alabilirsiniz.
                Programımız hakkında herhangi bir sorunuz veya geri bildiriminiz olursa, lütfen çekinmeden bizimle iletişime geçin. Size yardımcı olmaktan mutluluk duyarız.
                Saygılarımızla,
                Hızlı Randevu Ekibi 🙂
                ";
        $notification->link = uniqid();
        $notification->save();
    }
    public function sendNotification($title, $message)
    {
        $notification = new BusinessNotification();
        $notification->business_id = $this->id;
        $notification->type = 0;
        $notification->title = $title;
        $notification->message = $message;
        $notification->status = 0;
        $notification->link = uniqid();
        $notification->save();

        if (isset($this->device)){
            NotificationService::sendPushNotification($this->device->token, $title, $message);
        }
        return true;
    }
    public function setPermission($roleId)
    {
        $role = Role::findById($roleId);
        $permissions = $this->permissions;
        foreach ($permissions as $permission) {
            $this->revokePermissionTo($permission->name);
        }
        $rolePermissions = $role->permissions;
        foreach ($rolePermissions as $permission) {
            $this->givePermissionTo($permission->name);
        }
    }
}
