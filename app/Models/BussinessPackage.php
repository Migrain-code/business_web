<?php

namespace App\Models;

use App\Models\BussinessPackagePropartie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinessPackage extends Model
{
    use HasFactory;
    public function proparties()
    {
        return $this->hasMany(BussinessPackagePropartie::class, 'package_id', 'id')->orderBy('order_number', 'asc');
    }

    public function disabledProparties()
    {
        return $this->hasMany(BussinessPackagePropartieDisabledList::class, 'package_id', 'id');
    }
}
