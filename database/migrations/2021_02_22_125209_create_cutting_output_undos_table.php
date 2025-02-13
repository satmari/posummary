<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuttingOutputUndosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cutting_output_undos', function(Blueprint $table)
		{
			// $table->increments('id');

			$table->string('date')->nullable();

			$table->string('pro')->nullable();
			$table->string('sku')->nullable();

			$table->string('wc')->nullable();

			$table->float('qty_yield')->nullable();
			$table->float('qty_int')->nullable();
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
		Schema::drop('cutting_output_undos');
	}

}
