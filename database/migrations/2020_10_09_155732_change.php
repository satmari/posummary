<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Change extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('pro', function ($table) {

			// $table->string('tpp_shipments')->nullable();
			// $table->string('tpp_wastage')->nullable();
			// $table->string('skeda')->nullable();

			// $table->string('location_all')->nullable();
			// $table->string('skeda_status')->nullable();
			// $table->renameColumn('skeda_type','skeda_status');

			// $table->string('sku')->nullable();
			// // $table->string('deleted')->nullable();
			// $table->string('no_lines_by_pro')->nullable();
			// $table->string('no_lines_by_skeda')->nullable();
			// $table->string('no_lines_by_skeda')->nullable();
			// $table->string('po_new')->nullable();

			// $table->string('po_new')->nullable();
			// $table->date('skeda_status_updated_at')->nullable();

		});

		Schema::table('plo', function ($table) {

			// $table->string('tpp_shipments')->nullable();
			// $table->string('tpp_wastage')->nullable();
			// $table->string('skeda')->nullable();

			// $table->string('location_all')->nullable();
			// $table->string('skeda_status')->nullable();
			// $table->renameColumn('skeda_type','skeda_status');

			// $table->string('sku')->nullable();
			// $table->string('deleted')->nullable();
			// $table->string('batch')->nullable();
			// $table->dropColumn('batch');
		});

		Schema::table('mb51s', function ($table) {

			// $table->string('tpp_shipments')->nullable();
			// $table->string('tpp_wastage')->nullable();
			// $table->string('skeda')->nullable();

			// $table->string('location_all')->nullable();
			// $table->string('skeda_status')->nullable();
			// $table->renameColumn('skeda_type','skeda_status');

			// $table->string('sku')->nullable();
			// $table->string('deleted')->nullable();
			// $table->string('batch')->nullable();
		});

		Schema::table('coois_hes', function ($table) {

			// $table->string('pro_status')->nullable();
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
