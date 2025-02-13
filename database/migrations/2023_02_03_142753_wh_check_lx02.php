<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WhCheckLx02 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('wh_check_lx02', function(Blueprint $table)
		{
			// $table->increments('id');

			$table->string('storage_unit')->nullable();
			$table->string('gr_date')->nullable();
			$table->string('key')->nullable();

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
		//
	}

}