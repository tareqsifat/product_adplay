<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['product_id', 'name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

public function skus()
{
    return $this->belongsToMany(Sku::class, 'product_attribute_sku')->withPivot('value', 'price');
}
}
