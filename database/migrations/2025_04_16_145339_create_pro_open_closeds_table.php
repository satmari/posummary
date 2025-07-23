<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProOpenClosedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pro_open_closed', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('date')->nullable();
			$table->string('pro_material');
			$table->string('budgeting_plant');
			$table->integer('qty_from_pro_open');
			$table->integer('qty_from_pro_completedclosed');
			$table->integer('qty_from_pro_total');
			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('pro_open_closed');
	}

}
