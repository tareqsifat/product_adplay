<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Sku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    // Create a product
    $product = Product::create([
        'name' => 'Sample T-Shirt',
        'description' => 'A comfortable cotton t-shirt.',
    ]);

    // Create attributes
    $colorAttr = ProductAttribute::create([
        'product_id' => $product->id,
        'name' => 'Color',
    ]);
    $sizeAttr = ProductAttribute::create([
        'product_id' => $product->id,
        'name' => 'Size',
    ]);

    // Create SKUs
    $sku1 = Sku::create([
        'product_id' => $product->id,
        'sku' => 'TSHIRT-BLUE-M',
        'currency_code' => 'USD',
        'unit_amount' => 19.99, // base price (optional)
        'stock' => 10,
    ]);
    $sku2 = Sku::create([
        'product_id' => $product->id,
        'sku' => 'TSHIRT-RED-L',
        'currency_code' => 'USD',
        'unit_amount' => 21.99, // base price (optional)
        'stock' => 5,
    ]);

    // Link SKUs to attribute values with individual prices on pivot
    DB::table('product_attribute_sku')->insert([
        [
            'product_attribute_id' => $colorAttr->id,
            'sku_id' => $sku1->id,
            'value' => 'Blue',
            'price' => 2.00, // extra price for Blue
        ],
        [
            'product_attribute_id' => $sizeAttr->id,
            'sku_id' => $sku1->id,
            'value' => 'M',
            'price' => 0.00, // no extra price for M
        ],
        [
            'product_attribute_id' => $colorAttr->id,
            'sku_id' => $sku2->id,
            'value' => 'Red',
            'price' => 3.00, // extra price for Red
        ],
        [
            'product_attribute_id' => $sizeAttr->id,
            'sku_id' => $sku2->id,
            'value' => 'L',
            'price' => 1.00, // extra price for L
        ],
    ]);
}

}
