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
        Schema::createIfNotExists('storage_location', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("name", 255);
            $table->integer("warehouse_id");
            $table->boolean("is_full");
            $table->string("capacity", 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_location');
    }
};
