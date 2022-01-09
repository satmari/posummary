<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pro', function(Blueprint $table)
		{
			$table->increments('id');

			//FR
			$table->string('pro')->unique();
			$table->string('pro_fr');
			$table->string('po');
			$table->string('plo_fr')->nullable();

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

			//Inteos
			$table->string('brand')->nullable();
			$table->string('tpp')->nullable();
			$table->string('approval')->nullable();
			$table->string('eur1')->nullable();
			$table->string('status_int')->nullable();
			$table->string('location')->nullable();

			//Manual
			$table->string('pdm')->nullable();
			$table->string('flash_type')->nullable();

			//Activity
			$table->string('ec_cost')->nullable();
			$table->string('pref_origin')->nullable();
			$table->string('release')->nullable();
			$table->string('sent_to_inteos')->nullable();
	
			$table->timestamps();

			$table->string('tpp_shipments')->nullable();
			$table->string('tpp_wastage')->nullable();

			$table->string('skeda')->nullable();
			$table->string('location_all')->nullable();

			$table->string('skeda_status')->nullable();

			$table->string('sku')->nullable();
			$table->string('deleted')->nullable();

			$table->string('no_lines_by_pro')->nullable();
			$table->string('no_lines_by_skeda')->nullable();
			
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pro');
	}

}


/*

pro
pro_fr
po

material
style
color
size
color_desc

prod_type
season
flash
status_fr
segment
timetable_name
pdm_bom
pdm_bom_alt

created_fr
delivery_date
delivery_date_orig

qty

*/