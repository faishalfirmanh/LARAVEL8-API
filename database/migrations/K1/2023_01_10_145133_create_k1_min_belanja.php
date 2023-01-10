<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateK1MinBelanja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k1_min_belanja', function (Blueprint $table) {
            $table->id();
            $table->integer('price_min');
            $table->tinyInteger('is_active')->default(0);
            $table->integer('expired_voicher')->default(7);//
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
        Schema::dropIfExists('k1_min_belanja');
    }
}
