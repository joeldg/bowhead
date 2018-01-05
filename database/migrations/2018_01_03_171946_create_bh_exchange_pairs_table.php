<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhExchangePairsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bh_exchange_pairs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->nullable();
			$table->integer('market_id')->nullable()->default(0);
			$table->string('exchange_pair', 90)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->index(['exchange_id','market_id','exchange_pair'], 'exchange_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bh_exchange_pairs');
	}

}
