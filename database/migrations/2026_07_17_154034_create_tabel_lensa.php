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
        Schema::create('tabel_lensa', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("sph");
            $table->string("cyl");
            $table->string("add");
            $table->string("stok");
            $table->string("harga");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_lensa');
    }
};
