<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            $table->string('catalog_key')->nullable()->unique();
        });

        Schema::table('lenses', function (Blueprint $table) {
            $table->string('catalog_key')->nullable()->unique();
        });

        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->string('catalog_key')->nullable()->unique();
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accessories');

        Schema::table('lenses', function (Blueprint $table) {
            $table->dropUnique(['catalog_key']);
            $table->dropColumn('catalog_key');
        });

        Schema::table('frames', function (Blueprint $table) {
            $table->dropUnique(['catalog_key']);
            $table->dropColumn('catalog_key');
        });
    }
};
