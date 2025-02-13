<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlmCostingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plm_costings', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('fg_item')->nullable();
			$table->string('key_fg_pv_size_color_flash')->nullable();
			$table->string('color_code')->nullable();
			$table->string('color')->nullable();
			$table->string('stylecolor')->nullable();
			$table->string('latest_version_status')->nullable();
			$table->string('ordertype')->nullable();

			$table->float('operations_cost_eur')->nullable();
			$table->float('operations_cost')->nullable();
			$table->float('material_cost_eur')->nullable();
			$table->float('material_cost')->nullable();
			$table->float('total_cost')->nullable();

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
		Schema::drop('plm_costings');
	}

}
