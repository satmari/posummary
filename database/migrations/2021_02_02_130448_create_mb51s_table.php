<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMb51sTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mb51s', function(Blueprint $table)
		{
			
			$table->string('material')->nullable();
			$table->string('storage_location')->nullable();
			$table->string('movement_type')->nullable();
			$table->string('pro')->nullable();
			$table->float('qty')->nullable();
			$table->string('batch')->nullable();

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
		Schema::drop('mb51s');
	}

}
