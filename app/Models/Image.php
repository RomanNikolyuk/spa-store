<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $title
 * @property int $product_id
 * @property int $slider_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ImageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereSliderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slider_id', 'category_id', 'product_id'];

    public static function put(object $image, int $id, string $type): string
    {
        $image_name = Str::slug($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

        $image_path = '/images/';
        $image_path .= match ($type) {
            'product' => 'products/',
            'slider' => 'sliders/',
            'category' => 'categories/'
        };

        $image_row = self::where('title', 'LIKE', "%$image_name")->first();

        if (!is_null($image_row)) {
            $image_name = Str::random(12) . '.' . $image->getClientOriginalExtension();
        }

        $image->move(public_path() . $image_path, $image_name);

        // Removing all previous values
        self::where($type . '_id', $id)
            ->update([$type . '_id' => 0]);
        self::create(['title' => $image_path . $image_name, $type . '_id' => $id]);

        return $image_path . $image_name;
    }
}
