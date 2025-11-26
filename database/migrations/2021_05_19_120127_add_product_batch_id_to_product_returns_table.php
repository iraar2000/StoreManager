<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductBatchIdToProductReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::addColumnsIfNotExists('product_returns', ['product_batch_id'], function (Blueprint $table) {
            $table->integer('product_batch_id')->after('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_returns', function (Blueprint $table) {
            //
        });
    }
}
