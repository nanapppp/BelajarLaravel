<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_keranjangs', function (Blueprint $table) {
            $table->id(); // id detail keranjang
            $table->unsignedBigInteger('keranjang_id'); // id keranjang
            $table->unsignedBigInteger('product_id'); // id product
            $table->integer('quantity'); // jumlah
            $table->timestamps();

            // relasi ke keranjang (carts)
            $table->foreign('keranjang_id')
                  ->references('id')
                  ->on('carts')
                  ->onDelete('cascade');

            // relasi ke products
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_keranjangs');
    }
};
