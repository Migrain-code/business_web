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
        Schema::table('business_notifications', function (Blueprint $table) {
            $table->boolean('status')->default(0)->after('message')->comment('0 => okunmadı, 1=> okundu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_notifications', function (Blueprint $table) {
            //
        });
    }
};
