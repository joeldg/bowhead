<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhExchangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bh_exchanges', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('exchange', 50)->nullable()->unique('exchange');
			$table->boolean('hasFetchTickers')->nullable()->default(0);
			$table->boolean('hasFetchOHLCV')->nullable()->default(0);
			$table->boolean('use')->nullable()->default(0);
			$table->text('data', 65535)->nullable();
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
