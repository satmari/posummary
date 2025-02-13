<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMb51ConsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mb51_cons', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('mat_doc');
			$table->string('g_bin')->nullable();
			$table->string('material')->nullable();
			$table->float('qty')->nullable();
			$table->string('uom')->nullable();
			$table->string('batch')->nullable();
			$table->string('order')->nullable();
			$table->dateTime('posting')->nullable();
			$table->dateTime('entered')->nullable();

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
		Schema::drop('mb51_cons');
	}

}
