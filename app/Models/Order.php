<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function getStatusColorAttribute()
    {
        if ($this->status === 2) {
            return 'green';
        } elseif ($this->status === 1) {
            return 'orange';
        } else {
            return 'red';
        }
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
