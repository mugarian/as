<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function seller() {
        return $this->belongsTo(User::class);
    }

    public function order() {
        return $this->hasMany(Order::class);
    }
}
