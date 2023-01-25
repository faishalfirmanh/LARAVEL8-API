<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_transaction_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');//wajib
            $table->integer('id_product');//wajib
            $table->integer('total_product')->default(1);//wajib
            $table->integer('harga_total_tiap_product');//
            $table->string('kode_transaction');//diambil dari generate new transaction
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
        Schema::dropIfExists('k1_transaction_detail');
    }
}
