<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_attribute_sku', function (Blueprint $table) {
            $table->foreignId('product_attribute_id')->constrained()->onDelete('cascade');
            $table->foreignId('sku_id')->constrained()->onDelete('cascade');
            $table->string('value');
            $table->decimal('price', 10, 2)->nullable(); // <-- Add this line
            $table->primary(['product_attribute_id', 'sku_id']);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('product_attribute_sku');
    }
};
