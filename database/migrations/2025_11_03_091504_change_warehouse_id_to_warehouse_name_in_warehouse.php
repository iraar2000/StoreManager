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
        Schema::editColumnsIfNotExists('storage_location', ['warehouse_name'], function (Blueprint $table) {
            $table->renameColumn('warehouse_id', 'warehouse_name');
        });

        if (Schema::hasColumn('storage_location', 'warehouse_name')) {
            Schema::table('storage_location', function (Blueprint $table) {
                $table->string('warehouse_name')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            //
        });
    }
};
