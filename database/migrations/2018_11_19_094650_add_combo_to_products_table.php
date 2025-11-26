<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComboToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::addColumnsIfNotExists('products', ['product_list', 'qty_list', 'price_list'], function (Blueprint $table) {
            $table->string('product_list')->after('featured')->nullable();
            $table->string('qty_list')->after('product_list')->nullable();
            $table->string('price_list')->after('qty_list')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
