<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
public function show($id)
{
    $product = Product::with(['skus.attributeValues', 'attributes'])->findOrFail($id);

    // Collect attributes and their values with price from pivot
    $attributes = $product->attributes->map(function ($attribute) use ($product) {
        // Get all values for this attribute across SKUs
        $values = $product->skus->flatMap(function ($sku) use ($attribute) {
            return $sku->attributeValues
                ->where('id', $attribute->id)
                ->map(function ($attr) {
                    return [
                        'value' => $attr->pivot->value,
                        'price' => $attr->pivot->price,
                    ];
                });
        })->unique('value')->values();

        return [
            'id' => $attribute->id,
            'name' => $attribute->name,
            'values' => $values,
        ];
    });

    // Return SKUs as needed (if still useful)
    $skus = $product->skus->map(function ($sku) {
        $attributes = $sku->attributeValues->mapWithKeys(function ($attr) {
            return [
                $attr->name => [
                    'value' => $attr->pivot->value,
                    'price' => $attr->pivot->price,
                ],
            ];
        });

        return [
            'sku' => $sku->sku,
            'stock' => $sku->stock,
            'attributes' => $attributes,
        ];
    });

    return view('products.details', compact('product', 'attributes', 'skus'));
}


}
