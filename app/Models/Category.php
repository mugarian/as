<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    protected $table = 'categories';

    public function product() {
        return $this->hasMany(Product::class);
    }
}
