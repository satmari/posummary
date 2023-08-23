<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuttingBansekOutputsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cutting_bansek_outputs', function(Blueprint $table)
		{
			// $table->increments('id');

			$table->string('date')->nullable();

			$table->string('pro')->nullable();
			$table->string('sku')->nullable();

			$table->string('wc')->nullable();

			$table->float('qty_yield')->nullable();
			$table->float('qty_pulse')->nullable();
			$table->float('qty_delta')->nullable();

			$table->string('exporded')->nullable();
			$table->dateTime('exported_date')->nullable();

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
		Schema::drop('cutting_bansek_outputs');
	}

}
