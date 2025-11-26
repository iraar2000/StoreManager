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
        Schema::addColumnsIfNotExists('products', ['warehouse_id', 'location_id'], function (Blueprint $table) {
            $table->integer('warehouse_id')->after('alert_quantity');
            $table->integer('location_id')->after('alert_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::editColumnsIfNotExists('products', ['warehouse_id', 'location_id'], function (Blueprint $table) {
            $table->dropColumn('warehouse_id')->change();
            $table->dropColumn('location_id')->change();
        });
    }
};
