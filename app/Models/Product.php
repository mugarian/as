<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Product extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    protected $table = 'products';

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
