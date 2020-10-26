<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plo', function(Blueprint $table)
		{
			$table->increments('id');

			//FR
			$table->string('plo')->unique();
			$table->string('plo_fr');
			$table->string('pro_fr')->nullable();

			$table->string('material');
			$table->string('style')->nullable();
			$table->string('color')->nullable();
			$table->string('size')->nullable();
			$table->string('color_desc')->nullable();

			$table->string('prod_type')->nullable();
			$table->string('season')->nullable();
			$table->string('flash')->nullable();
			$table->string('status_fr')->nullable();
			$table->string('segment')->nullable();
			$table->string('timetable_name')->nullable();
			$table->string('pdm_bom')->nullable();
			$table->string('pdm_bom_alt')->nullable();

			$table->dateTime('created_fr')->nullable();
			$table->dateTime('delivery_date')->nullable();
			$table->dateTime('delivery_date_orig')->nullable();

			$table->integer('qty');

			//Manual
			$table->string('bom')->nullable();
			$table->string('routing')->nullable();
			$table->string('prod_version')->nullable();

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
		Schema::drop('plo');
	}

}
