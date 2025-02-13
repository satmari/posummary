<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMblbsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mblbs', function(Blueprint $table)
		{
			$table->string('material')->nullable();
			$table->string('plant')->nullable();
			$table->string('batch')->nullable();
			$table->float('qty')->nullable();
			$table->string('destination')->nullable();

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
		Schema::drop('mblbs');
	}

}
