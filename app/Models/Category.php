<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
