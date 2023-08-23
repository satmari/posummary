<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSapSecondQualitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sap_second_qualities', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('pro')->unique();
			$table->string('sku');
			$table->string('batch');
			$table->integer('qty');
			$table->string('approval');

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
		Schema::drop('sap_second_qualities');
	}

}
