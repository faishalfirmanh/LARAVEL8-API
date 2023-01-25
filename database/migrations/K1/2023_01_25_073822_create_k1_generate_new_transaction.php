<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1GenerateNewTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_generate_new_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaction');
            $table->tinyInteger('id_setting_voucher')->default(1);
            $table->tinyInteger('status')->default(0);//0 create, 1->transaction, 2->struct /finish
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
        Schema::dropIfExists('k1_generate_new_transaction');
    }
}
