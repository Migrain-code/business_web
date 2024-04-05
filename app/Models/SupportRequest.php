<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(BusinessOfficial::class, 'id', 'user_id');
    }
    public function responses()
    {
        return $this->hasMany(SupportResponse::class);
    }
}
