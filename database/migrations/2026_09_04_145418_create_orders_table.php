<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('product_type', ['lens', 'frame']);
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('pending');
            $table->decimal('total_price', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
