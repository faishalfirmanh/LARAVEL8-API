<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionStruck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_transaction_struck', function (Blueprint $table) {
            $table->id();
            $table->integer('total_harga');//total semua harga
            $table->string('kode_transaction');
            $table->integer('total_bayar');// yang dibayar
            $table->integer('kembalian');
            $table->string('is_voucher_code')->nullable();
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
        Schema::dropIfExists('k1_transaction_struck');
    }
}
