<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // primary key (bigint unsigned)

            // tanggal order
            $table->date('tanggal');

            // total harga
            $table->integer('total');

            // status (opsional tapi disarankan)
            $table->enum('status', ['pending', 'paid', 'cancel'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
