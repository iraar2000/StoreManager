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
        Schema::addColumnsIfNotExists('mobile_money_accounts', ['transactions'], function (Blueprint $table) {
            $table->integer('transactions')->after('number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('mobile_money_accounts', 'transactions')) {
            Schema::dropColumns('mobile_money_accounts', 'transactions');
        }
    }
};
