<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1TransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('id_product');
            $table->string('total_product');
            $table->string('harga_satuan');
            $table->string('list_code_voucher')->nullable();
            $table->integer('id_min_belanja')->nullable();
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
        Schema::dropIfExists('k1_transaction_details');
    }
}
