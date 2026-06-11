<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_orders', function (Blueprint $table) {
            $table->dropColumn('qty');
        });
    }

    public function down(): void
    {
        Schema::table('detail_orders', function (Blueprint $table) {
            $table->integer('qty')->default(1);
        });
    }
};
