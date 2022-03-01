<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property string $alias
 * @property string $url
 * @property string $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $children
 * @property-read mixed $parent
 * @property-read \App\Models\Image|null $image
 * @property-read \App\Models\MainPageCategory|null $main_page
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'title', 'alias'];


    public function products()
    {
        if (request('order_by')) {
            return $this->hasMany(Product::class)->orderBy('price', request('order_by'));
        }
        return $this->hasMany(Product::class);
    }

    public function getChildrenAttribute()
    {
        return self::where('parent_id', $this->id)->get();
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }

    public function getParentAttribute()
    {
        return $this->find($this->parent_id);
    }

    public function main_page()
    {
        return $this->hasOne(MainPageCategory::class);
    }
}
