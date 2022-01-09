<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooisOpXmlsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coois_op_xmls', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('pro')->nullable();
			$table->string('wc')->nullable();
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
		Schema::drop('coois_op_xmls');
	}

}
