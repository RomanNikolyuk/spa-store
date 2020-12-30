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
        return $this->hasMany(Product::class);
    }

    public function getChildrenAttribute()
    {
        return self::where('parent_id', $this->id)->get();
    }
}
