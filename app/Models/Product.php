<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title
 * @property string $small_desc
 * @property int $category_id
 * @property string $big_desc
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read mixed $category_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \App\Models\RecommendedProducts|null $recommended
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBigDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSmallDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'small_desc', 'category_id', 'big_desc', 'price'];

    /*protected $casts = [
        'image' => Product::class.':title'
    ];*/

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /*    public static function castUsing(array $arguments)
        {
            return new class implements CastsAttributes
            {
                public function get($model, $key, $value, $attributes)
                {

                    return new Product(
                        $attributes
                    );
                }

                public function set($model, $key, $value, $attributes)
                {
                    return [
                        'address_line_one' => $value->lineOne,
                        'address_line_two' => $value->lineTwo,
                    ];
                }
            };
        }*/

    public function delete()
    {
        foreach ($this->images()->get() as $image) {
            $image->product_id = 0;
            $image->save();
        }

        return parent::delete();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        $searched_cat = Category::find($this->category_id);

        if ($searched_cat->parent_id !== 0) {
            $parent_cat = Category::find($searched_cat->parent_id);
            $output = $parent_cat->title . ' -> ' . $searched_cat->title;
        } else {
            $output = $searched_cat->title;
        }

        return $output;
    }

    public function getImagesAttribute()
    {
        $images = $this->images()->get();

        foreach ($images as $image) {
            $return[] = $image->title;
        }

        return $return ?? [];
    }

    public function recommended()
    {
        return $this->hasOne(RecommendedProducts::class);
    }
}
