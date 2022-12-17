<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P1LinkOnlineShopProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //1 product only have 1 link marketplace in 1 site marketplace
        Schema::create('p1_productlinkonlineshop', function (Blueprint $table) {
            $table->id();
            $table->integer('id_onlineshop');
            $table->integer('id_product');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p1_productlinkonlineshop');
    }
}
