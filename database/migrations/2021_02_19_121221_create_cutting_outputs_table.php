<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuttingOutputsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cutting_outputs', function(Blueprint $table)
		{
			// $table->increments('id');

			$table->string('date')->nullable();

			$table->string('pro')->nullable();
			$table->string('sku')->nullable();

			$table->string('wc')->nullable();

			$table->float('qty_yield')->nullable();
			$table->float('qty_int')->nullable();
			$table->float('qty_delta')->nullable();

			$table->string('exporded')->nullable();
			$table->dateTime('exported_date')->nullable();

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
		Schema::drop('cutting_outputs');
	}

}

/*

			c.pro
			,c.qty_op
			,REPLACE(LEFT(ISNULL(x.StyCod,'')+'____',9), '_', ' ')+REPLACE(LEFT(ISNULL(LEFT(x.[Variant], CHARINDEX('-', x.[Variant]) - 1),'')+'____',4), '_', ' ')+REPLACE(LEFT(ISNULL(SUBSTRING(x.Variant,CHARINDEX('-',x.Variant)+1,LEN(x.Variant)),'')+ '____',5), '_', ' ') as int_sku
			--,CHARINDEX('-',c.pro)
			,CASE
				WHEN CHARINDEX('-',c.pro) > 0 THEN c.pro
				ELSE '000'+c.pro
			END as pro_final

			,x.POnum as pro_int
			,c.qty_yield
			,CASE
				WHEN x.sum_bb is NULL THEN 0
				ELSE x.sum_bb
			END as sum_bb_num
			--,x.sum_bb
			,CASE
				WHEN x.sum_bb is NULL THEN 0
				ELSE x.sum_bb
			END - c.qty_yield as delta