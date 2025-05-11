<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $fillable = ['product_id', 'sku', 'currency_code', 'unit_amount', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_attribute_sku')->withPivot('value', 'price');
    }
}
