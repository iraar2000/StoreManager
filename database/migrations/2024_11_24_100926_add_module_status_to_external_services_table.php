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

        Schema::addColumnsIfNotExists('external_services', ['module_status'], function (Blueprint $table) {
            $table->json('module_status')->after('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::editColumnsIfNotExists('external_services', ['module_status'], function (Blueprint $table) {
            $table->dropColumn('module_status');
        });
    }
};
