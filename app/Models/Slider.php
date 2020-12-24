<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    public function image() {
        return $this->hasOne(Image::class);
    }

    public function getImageAttribute() {
        return $this->image()->first()->title;
    }
}