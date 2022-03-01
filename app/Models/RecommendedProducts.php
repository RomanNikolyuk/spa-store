<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RecommendedProducts
 *
 * @property int $id
 * @property int|null $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedProducts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RecommendedProducts extends Model
{
    use HasFactory;

    protected $fillable = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
