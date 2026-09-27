<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY product_type ENUM('lens', 'frame', 'accessory') NOT NULL");
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->string('product_key')->nullable()->after('product_id');
            $table->string('product_name')->nullable()->after('product_key');
            $table->string('product_category')->nullable()->after('product_name');
            $table->string('transaction_code')->nullable()->after('product_category')->index();
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['product_key', 'product_name', 'product_category', 'transaction_code']);
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY product_type ENUM('lens', 'frame') NOT NULL");
        }
    }
};