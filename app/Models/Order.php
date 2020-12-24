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

    /*
     * Отримання кількості продуктів, що мають такий же status. Неодхідний у dashboard.blade
     */

    public function getCountAttribute()
    {
        return self::where('status', $this->status)->count();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
