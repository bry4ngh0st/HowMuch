<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moneda', function($table){			
			$table->string('codigo', 3);
			$table->string('nombre');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->primary('codigo');
		});
		
		Schema::create('monto', function($table){
			$table->increments('id');
			$table->integer('entidad_id')->unsigned();
			$table->string('moneda_codigo', 3)->default('USD');
			$table->decimal('latitud', 10, 7);
			$table->decimal('longitud', 10, 7);
			$table->string('ubicacion');
			$table->decimal('monto', 10, 2);
			$table->string('descripcion');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->foreign('entidad_id')
			->references('id')->on('entidad')
			->onDelete('restrict');
			$table->foreign('moneda_codigo')
			->references('codigo')->on('moneda')
			->onDelete('restrict');
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
