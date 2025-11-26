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
        Schema::addColumnsIfNotExists('users', ['is_active', 'company_name', 'role_id', 'biller_id', 'warehouse_id', 'is_active', 'is_deleted'], function (Blueprint $table) {
            $table->string("phone")->after("remember_token")->nullable();
            $table->string("company_name")->after("phone")->nullable();
            $table->string("role_id")->after("company_name")->nullable();
            $table->string("biller_id")->after("role_id")->nullable();
            $table->string("warehouse_id")->after("biller_id")->nullable();
            $table->boolean("is_active")->after("warehouse_id")->nullable();
            $table->string("is_deleted")->after("is_active")->nullable();
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
