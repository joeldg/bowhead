<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBhConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bh_configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('item', 80)->nullable()->index('item');
			$table->string('value', 1500)->nullable();
			$table->integer('exchange_id')->nullable()->index('exchange_id');
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
		Schema::drop('bh_configs');
	}

}
