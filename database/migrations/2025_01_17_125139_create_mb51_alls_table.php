<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMb51AllsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mb51_alls', function(Blueprint $table)
		{
			// $table->increments('id');

			$table->date('posting_date')->nullable();
			$table->string('material_document')->nullable();
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
		Schema::drop('mb51_alls');
	}

}
