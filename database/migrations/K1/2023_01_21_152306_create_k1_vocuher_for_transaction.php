<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1VocuherForTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_vocuher_for_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaction');
            $table->string('kode_voucher');
            $table->tinyInteger('is_used')->default(0);
            $table->date('expired_voucher');
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
        Schema::dropIfExists('k1_vocuher_for_transaction');
    }
}
