<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('pagare');
			$table->string('estado');
			$table->integer('capital');
			$table->integer('intereses');
			$table->integer('mora');
			$table->integer('seguro');
			$table->integer('idiferido');
			$table->integer('asistencia');
			$table->integer('cinversion');
			$table->integer('icausado');
			$table->integer('total');
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('CASCADE')
				->onUpdate('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estados');
	}

}
