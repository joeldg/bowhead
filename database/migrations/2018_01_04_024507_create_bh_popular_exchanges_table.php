<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhPopularExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bh_popular_exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exch_id')->nullable();
            $table->string('exchange', 50)->nullable();
            $table->boolean('public_api')->nullable()->default(0);
            $table->boolean('coinigy')->nullable()->default(0);
            $table->boolean('ccxt')->nullable()->default(0);
            $table->string('link')->nullable();
            $table->text('about', 65535)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bh_popular_exchanges');
    }
}
