<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarginAnalysisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('margin_analysis', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('date')->nullable();

			$table->string('material')->nullable();
			$table->string('plant_det')->nullable();
			$table->string('profit_center_summary')->nullable();

			$table->float('sales_value')->nullable();
			$table->float('sales_qty')->nullable();
			$table->float('sales_unit_price')->nullable();
			$table->float('std_cogs_mbew')->nullable();
			$table->float('std_pro_mat')->nullable();
			$table->float('std_pro_prd')->nullable();
			$table->float('std_cogs_pro')->nullable();
			$table->float('std_cogs')->nullable();
			$table->float('gross_std_margin')->nullable();
			$table->float('stdmarg')->nullable();

			$table->float('var_recipe_mat')->nullable();
			$table->float('var_recipe_prd')->nullable();
			$table->float('var_efficiency_mat')->nullable();
			$table->float('var_efficiency_prd')->nullable();
			$table->float('var_price_mat')->nullable();
			$table->float('var_price_prd')->nullable();
			$table->float('var_exc_rate')->nullable();
			$table->float('var_tot')->nullable();
			$table->float('gross_act_margin')->nullable();
			$table->float('actmarg')->nullable();

			$table->float('unit_std')->nullable();
			$table->float('unit_var')->nullable();

			$table->string('mtype')->nullable();
			$table->string('ck')->nullable();
			$table->string('mat_category')->nullable();
			$table->string('mat_brand')->nullable();
			$table->string('material_article')->nullable();

			$table->float('sales_min_tot')->nullable();
			$table->float('sales_min_special_ord')->nullable();
			$table->float('special_ord')->nullable();

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
		Schema::drop('margin_analysis');
	}

}
