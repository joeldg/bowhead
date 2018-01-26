<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhExchangeBalancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bh_exchange_balances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('auth_id')->nullable()->index('auth_id1');
			$table->string('exch_name')->nullable()->index('exch_name1');
			$table->integer('exch_id')->nullable()->index('exch_id1');
			$table->string('balance_curr_code', 80)->nullable();
			$table->float('balance_amount_avail', 10, 0)->nullable();
			$table->float('balance_amount_held', 10, 0)->nullable();
			$table->float('balance_amount_total', 10, 0)->nullable();
			$table->float('btc_balance', 10, 0)->nullable();
			$table->float('last_price', 10, 0)->nullable();
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
		Schema::drop('bh_exchange_balances');
	}

}
