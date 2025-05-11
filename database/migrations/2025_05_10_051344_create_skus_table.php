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
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('currency_code', 3);
            $table->decimal('unit_amount', 10, 2);
            $table->integer('stock')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skus');
    }
};
