<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->on('purchase_request')->cascadeOnDelete()->cascadeOnUpdate()->nullable();
            $table->foreignId('product_id')->on('products')->cascadeOnDelete()->cascadeOnUpdate()->nullable();
            $table->float('quantity');
            $table->float('price')->nullable();
            $table->string('description')->nullable();
            $table->string('product_responsible')->nullable();
            $table->float('total_price')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_product');
    }
};
