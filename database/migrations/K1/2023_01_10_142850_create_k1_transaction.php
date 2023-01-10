<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1Transaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaction_details');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->integer('kembalian');
            $table->integer('hemat')->nullable();
            $table->string('is_used_voucher')->nullable();
            $table->string('is_voucher')->nullable();
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
        Schema::dropIfExists('k1_transaction');
    }
}
