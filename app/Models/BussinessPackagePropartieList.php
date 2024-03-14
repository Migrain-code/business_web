<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList query()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackagePropartieList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BussinessPackagePropartieList extends Model
{
    use HasFactory;
}
