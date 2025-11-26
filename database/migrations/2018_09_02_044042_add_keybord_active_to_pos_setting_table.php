<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKeybordActiveToPosSettingTable extends Migration
{
    public function up()
    {
        Schema::addColumnsIfNotExists('pos_setting', ['keybord_active'], function (Blueprint $table) {
            $table->boolean('keybord_active')->after('product_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::addColumnsIfNotExists('pos_setting', ['keybord_active'], function (Blueprint $table) {
            //
        });
    }
}
