<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CuttingBansekOutputError extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	

		Schema::create('cutting_bansek_output_errors', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('POnum')->nullable();
			$table->string('itemNo')->nullable();
			$table->string('variantCode')->nullable();
			$table->float('qty_pulse')->nullable();
			$table->string('po_in_posum')->nullable();
			$table->string('sap_pro')->nullable();
			$table->float('sap_pro_op_qty')->nullable();

			$table->timestamps();
		});

		//
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
