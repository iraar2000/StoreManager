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
        Schema::create('payment_with_mobile_money', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer("payment_id")->nullable(false);
            $table->integer("momo_type_id")->nullable(false);
            $table->integer("momo_number_id")->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_with_mobile_money');
    }
};
