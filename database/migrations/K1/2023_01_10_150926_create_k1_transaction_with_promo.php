<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1TransactionWithPromo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_transaction_with_promo', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->integer('price_before_promo');
            $table->integer('price_after_promo');
            $table->string('jenis_promo');//1 atau 2
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
        Schema::dropIfExists('k1_transaction_with_promo');
    }
}
