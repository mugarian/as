<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function buyer() {
        return $this->belongsTo(User::class);
    }

    public function billing() {
        return $this->hasMany(Billing::class);
    }

}
