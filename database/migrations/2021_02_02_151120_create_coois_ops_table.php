<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooisOpsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coois_ops', function(Blueprint $table)
		{
			$table->string('pro')->nullable();
			$table->string('activity')->nullable();
			$table->string('wc')->nullable();
			$table->string('op_text')->nullable();
			$table->float('qty_op')->nullable();
			$table->float('qty_yield')->nullable();

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
		Schema::drop('coois_ops');
	}

}
