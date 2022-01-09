<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMb52sTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mb52s', function(Blueprint $table)
		{
			
			$table->string('material')->nullable();
			$table->string('storage_location')->nullable();
			$table->string('batch')->nullable();
			$table->float('qty')->nullable();
			$table->float('qty_blocked')->nullable();

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
		Schema::drop('mb52s');
	}

}
