<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooisHesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coois_hes', function(Blueprint $table)
		{
			
			$table->string('pro')->nullable();
			$table->string('material')->nullable();	
			$table->float('qty_order')->nullable();
			$table->float('qty_delivered')->nullable();

			$table->string('pro_status')->nullable();

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
		Schema::drop('coois_hes');
	}

}
