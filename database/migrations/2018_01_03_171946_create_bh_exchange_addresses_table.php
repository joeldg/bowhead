<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhExchangeAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bh_exchange_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('exchange_id')->nullable()->index('exchange_id');
			$table->string('currency', 24)->nullable();
			$table->string('address')->nullable();
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
		Schema::drop('bh_exchange_addresses');
	}

}
