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

    public function getImagesAttribute()
    {
        $images = $this->images()->get();

        foreach ($images as $image) {
            $return[] = $image->title;
        }


        return $return;
    }
}
