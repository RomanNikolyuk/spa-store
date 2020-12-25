<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(Image::class);
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


        return $return;
    }
}
