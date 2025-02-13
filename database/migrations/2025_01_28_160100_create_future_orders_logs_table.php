<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFutureOrdersLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('future_orders_logs', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('tda')->nullable();
			$table->string('season')->nullable();
			$table->string('sku')->nullable();
			$table->string('description')->nullable();
			$table->integer('qty')->nullable();
			$table->float('smv')->nullable();
			$table->float('total_minutes')->nullable();
			$table->date('delivery')->nullable();
			$table->date('rma_standard')->nullable();
			$table->string('flash_price')->nullable();
			$table->string('order_group_macro')->nullable();
			$table->string('order_group')->nullable();
			$table->string('status')->nullable();
			$table->string('main_mat')->nullable();
			$table->float('smv_fr')->nullable();

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
		Schema::drop('future_orders_logs');
	}

}
