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
        Schema::addColumnsIfNotExists('pos_setting', ['thermal_invoice_size'], function (Blueprint $table) {
            $table->string('paypal_live_api_username')->default(191)->after('stripe_secret_key');
            $table->string('paypal_live_api_password')->default(191)->after('paypal_live_api_username');
            $table->string('paypal_live_api_secret')->default(191)->after('paypal_live_api_password');
            $table->text('payment_options')->after('paypal_live_api_secret');
            $table->string('invoice_option')->default(10)->after('payment_options');
            $table->string('thermal_invoice_size')->default('80')->after('invoice_option');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_setting', function (Blueprint $table) {
            $table->dropColumn('thermal_invoice_size');
        });
    }
};
