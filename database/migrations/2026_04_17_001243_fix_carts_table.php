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
    Schema::table('carts', function (Blueprint $table) {
        // 1. hapus foreign key dulu
        $table->dropForeign(['category_id']);

        // 2. baru hapus kolomnya
        $table->dropColumn('category_id');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
