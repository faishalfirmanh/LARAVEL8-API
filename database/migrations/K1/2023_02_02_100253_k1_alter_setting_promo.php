<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class K1AlterSettingPromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('k1_setting_promo_transaction', function (Blueprint $table) {
            $table->tinyInteger('percent_set_minimum_sell')->nullable()->after('is_active');//promo untuk minimal dijual berapa
            $table->tinyInteger('promo_percent')->nullable()->after('percent_set_minimum_sell');//promo potongan berapa persent
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('k1_setting_promo_transaction', function (Blueprint $table) {
            $table->dropColumn('percent_set_minimum_sell');
            $table->dropColumn('promo_percent');
        });
    }
}
