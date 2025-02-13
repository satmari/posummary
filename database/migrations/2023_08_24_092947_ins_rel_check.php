<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsRelCheck extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('ins_rel_check', function(Blueprint $table)
		{
			// $table->increments('id');

			$table->string('material')->nullable();
			$table->string('storage_bin')->nullable();
			$table->string('dyelot_number')->nullable();
			$table->string('certificate_number')->nullable();
			$table->string('storage_unit')->nullable();
			$table->float('available_stock')->nullable();
			$table->string('approval_no')->nullable();
			$table->string('stock_category')->nullable();
			$table->string('batch')->nullable();
			$table->float('total_stock')->nullable();
			$table->string('plant')->nullable();
			$table->string('warehouse_number')->nullable();
			$table->string('storage_type')->nullable();
			$table->string('storage_unit_type')->nullable();
			$table->string('delivery')->nullable();
			$table->string('pref_origin')->nullable();
			$table->string('tpp')->nullable();
			$table->string('origin_crit')->nullable();
			$table->string('valuation_type')->nullable();
			$table->string('production_order_no')->nullable();
			$table->string('special_stock')->nullable();
			$table->string('special_stock_no')->nullable();
			$table->string('stock_segment')->nullable();
			$table->string('storage_location')->nullable();
			$table->string('uom')->nullable();

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