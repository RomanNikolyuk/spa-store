<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['small_text_1', 'small_text_2', 'big_text', 'button_text', 'url'];

    public function image() {
        return $this->hasOne(Image::class);
    }

    public function getImageAttribute() {
        return $this->image()->first()->title ?? '';
    }
}
