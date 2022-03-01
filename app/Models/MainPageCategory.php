<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MainPageCategory
 *
 * @property int $id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainPageCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MainPageCategory extends Model
{
    use HasFactory;

    public $table = 'mainpage_categories';

    protected $fillable = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
