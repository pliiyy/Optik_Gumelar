<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('branch_id')->nullable()->index();
            $table->string('branch_name')->nullable();
            $table->decimal('branch_distance_km', 8, 2)->nullable();
            $table->decimal('buyer_latitude', 10, 7)->nullable();
            $table->decimal('buyer_longitude', 10, 7)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'branch_id',
                'branch_name',
                'branch_distance_km',
                'buyer_latitude',
                'buyer_longitude',
            ]);
        });
    }
};