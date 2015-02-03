<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('valor', 16, 2);
			$table->decimal('seguro', 16, 2);
			$table->dateTime('fecha_pago');
			$table->string('forma_pago');
			$table->integer('user_id')->unsigned();
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('NO ACTION')
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
		Schema::drop('pagos');
	}

}
