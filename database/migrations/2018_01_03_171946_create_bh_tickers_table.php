<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhTickersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bh_tickers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('bh_exchanges_id')->nullable()->index('bh_exchanges_id3');
			$table->string('symbol', 90)->nullable()->index('symbol');
			$table->bigInteger('timestamp')->nullable()->index('timestamp');
			$table->dateTime('datetime')->nullable()->index('datetime1');
			$table->float('high', 10, 0)->nullable();
			$table->float('low', 10, 0)->nullable();
			$table->float('bid', 10, 0)->nullable();
			$table->float('ask', 10, 0)->nullable();
			$table->float('vwap', 10, 0)->nullable();
			$table->float('open', 10, 0)->nullable();
			$table->float('close', 10, 0)->nullable();
			$table->float('first', 10, 0)->nullable();
			$table->float('last', 10, 0)->nullable();
			$table->float('change', 10, 0)->nullable();
			$table->float('percentage', 10, 0)->nullable();
			$table->float('average', 10, 0)->nullable();
			$table->float('baseVolume', 10, 0)->nullable();
			$table->float('quoteVolume', 10, 0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->unique(['bh_exchanges_id','symbol','timestamp'], 'bh_exchanges_id_23');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bh_tickers');
	}

}
