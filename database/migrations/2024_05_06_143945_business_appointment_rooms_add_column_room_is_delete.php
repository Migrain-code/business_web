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
        Schema::table('business_rooms', function (Blueprint $table) {
            $table->boolean('is_delete')->default(0)->after('is_main')->comment('0 => akitf, 1 => silinmiş');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_rooms', function (Blueprint $table) {
            //
        });
    }
};
