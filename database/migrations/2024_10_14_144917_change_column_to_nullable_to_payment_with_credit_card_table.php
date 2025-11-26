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
        Schema::editColumnsIfNotExists('payment_with_credit_card', ['data'], function (Blueprint $table) {
            $table->longText('data')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::editColumnsIfNotExists('payment_with_credit_card', ['data'], function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
};
