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
        Schema::create('trans_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_customer');
            $table->string('order_code', 60)->nullable();
            $table->dateTime('order_date');
            $table->dateTime('order_end_date');
            $table->tinyInteger('order_status')->default(1);
            $table->integer('order_pay')->nullable();
            $table->integer('order_change')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_customer')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_order');
    }
};
