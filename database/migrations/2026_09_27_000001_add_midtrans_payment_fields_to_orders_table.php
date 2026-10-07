<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_status', 30)->default('unpaid')->after('status');
            $table->string('midtrans_order_id')->nullable()->index()->after('payment_status');
            $table->text('snap_redirect_url')->nullable()->after('midtrans_order_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'midtrans_order_id', 'snap_redirect_url']);
        });
    }
};