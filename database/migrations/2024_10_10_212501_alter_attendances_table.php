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
        Schema::editColumnsIfNotExists('attendances', ['date', 'employee_id', 'checkin'], function (Blueprint $table) {
            $table->dropColumn(['date', 'employee_id', 'checkin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
