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
        Schema::table('type_of_services', function (Blueprint $table) {
            // Ubah panjang kolom name jadi 100
            $table->string('service_name', 80)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('type_of_services', function (Blueprint $table) {
            // Kembalikan ke 255
            $table->string('service_name', 80)->change();
        });
    }
};
