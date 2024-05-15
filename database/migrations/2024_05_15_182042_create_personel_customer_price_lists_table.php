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
        Schema::create('personel_customer_price_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('personel_id');
            $table->integer('business_service_id');
            $table->string('price')->nullable();
            $table->boolean('status')->default(0)->comment('0 => pasif; 1 => aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personel_customer_price_lists');
    }
};
