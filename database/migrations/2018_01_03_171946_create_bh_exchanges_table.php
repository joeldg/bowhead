<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bh_exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exchange', 50)->nullable()->unique('exchange');
            $table->boolean('ccxt')->nullable()->default(0);
            $table->boolean('coinigy')->nullable()->default(0)->index('coinigy');
            $table->integer('coinigy_id')->nullable();
            $table->string('coinigy_exch_code', 10)->nullable()->index('coinigy_exch_code');
            $table->float('coinigy_exch_fee', 10, 0)->nullable();
            $table->boolean('coinigy_trade_enabled')->nullable()->default(0)->index('trade_enabled');
            $table->boolean('coinigy_balance_enabled')->nullable()->default(0)->index('balance_enabled');
            $table->boolean('hasFetchTickers')->nullable()->default(0);
            $table->boolean('hasFetchOHLCV')->nullable()->default(0);
            $table->integer('use')->nullable()->default(0);
            $table->text('data', 65535)->nullable();
            $table->string('url', 200)->nullable();
            $table->string('url_api', 200)->nullable();
            $table->string('url_doc', 200)->nullable();
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
        Schema::drop('bh_exchanges');
    }
}
