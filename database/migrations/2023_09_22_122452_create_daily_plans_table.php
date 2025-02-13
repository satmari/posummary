<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('daily_plans', function(Blueprint $table)
		{
			$table->increments('id');

			$table->date('date');
			$table->string('module');
			$table->string('pro');
			$table->string('style');
			$table->integer('qty');

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
		Schema::drop('daily_plans');
	}

}
