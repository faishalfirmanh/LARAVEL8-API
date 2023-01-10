<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1ProductPromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_product_promo', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product');
            $table->tinyInteger('type_discount')->default(0);//0 for amount 1->percent
            $table->float('potongan_harga');
            $table->float('final_harga');
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
        Schema::dropIfExists('k1_product_promo');
    }
}
