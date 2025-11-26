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

        Schema::editColumnsIfNotExists('products', ['warehouse_location_list'], function (Blueprint $table) {
            $table->renameColumn('location_list', 'warehouse_location_list');
        });

        if (Schema::hasColumn('products', 'warehouse_list')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('warehouse_list')->change();
            });
        }
        if (Schema::hasColumn('products', 'warehouse_location_list')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('warehouse_location_list')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
