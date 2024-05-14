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
        Schema::create('packet_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->integer('business_id');
            $table->double('price', 10, 2)->default(0);
            $table->double('tax', 10, 2)->default(0);
            $table->double('discount', 10, 2)->default(0);
            $table->integer('payment_id');
            $table->string('payment_type');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packet_orders');
    }
};
