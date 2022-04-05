<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $small_text_1
 * @property string $small_text_2
 * @property string $big_text
 * @property string $button_text
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Image|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereBigText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereButtonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSmallText1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSmallText2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUrl($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['small_text_1', 'small_text_2', 'big_text', 'button_text', 'url'];

    public function image()
    {
        return $this->hasOne(Image::class);
    }
}
