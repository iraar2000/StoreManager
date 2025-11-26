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
        Schema::addColumnsIfNotExists('sales', ['currency_id', 'exchange_rate'], function (Blueprint $table) {
            $table->integer("currency_id")->after('warehouse_id');
            $table->string("exchange_rate")->after('currency_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sales', "currency_id")) {
            Schema::dropColumns('sales', "currency_id");
        }
        if (Schema::hasColumn('sales', "exchange_rate")) {
            Schema::dropColumns('sales', "exchange_rate");
        }
    }
};
