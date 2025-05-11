<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
