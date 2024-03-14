<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $slug
 * @property string $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $descriptions
 * @property string $meta_titles
 * @property string $titles
 * @property int $category_id
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereDescriptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereMetaTitles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereTitles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessBlog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessBlog extends Model
{
    use HasFactory;
}
