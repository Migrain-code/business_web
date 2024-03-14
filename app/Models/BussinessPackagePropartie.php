<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $package_id
 * @property int $propartie_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BussinessPackagePropartieList|null $list
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie query()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie wherePropartieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BussinessPackagePropartie extends Model
{
    use HasFactory;
    public function list()
    {
        return $this->hasOne(BussinessPackagePropartieList::class, 'id', 'propartie_id');
    }
}
