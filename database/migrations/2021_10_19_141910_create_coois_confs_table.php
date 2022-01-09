<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooisConfsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coois_confs', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('pro');
			$table->string('activity')->nullable();
			$table->integer('yield')->default(0);
			$table->date('entered_on');
			$table->string('entered_by')->nullable();
			
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
		Schema::drop('coois_confs');
	}

}
