<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhOhlcvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bh_ohlcvs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bh_exchanges_id')->nullable();
            $table->string('symbol', 90)->nullable();
            $table->bigInteger('timestamp')->nullable();
            $table->dateTime('datetime')->nullable()->index('datetime_ohlcvs');
            $table->float('open', 10, 0)->nullable();
            $table->float('high', 10, 0)->nullable();
            $table->float('low', 10, 0)->nullable();
            $table->float('close', 10, 0)->nullable();
            $table->float('volume', 10, 0)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['bh_exchanges_id', 'symbol', 'timestamp'], 'bh_exchanges_id_ohlcvs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bh_ohlcvs');
    }
}
