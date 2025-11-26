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
        Schema::addColumnsIfNotExists('product_warehouse', ['location_id'], function (Blueprint $table) {
            $table->int('location_id')->after('warehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('product_warehouse', 'location_id')) {
            Schema::table('product_warehouse', function (Blueprint $table) {
                $table->drop('location_id');
            });
        }
    }
};
