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
        Schema::create('tabel_cabang', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("kode");
            $table->string("alamat");
            $table->string("telepon");
            $table->string("email");
            $table->string("pj");
            $table->boolean("status");
            $table->timestamps();

            $table->unsignedBigInteger('area_id');

$table->foreign('area_id')
      ->references('id')
      ->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_cabang');
    }
};
