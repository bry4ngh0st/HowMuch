<?php

class UbicacionTableSeeder extends Seeder
{
	public function run()
	{
		Ubicacion::create(array(
			'descripcion' => 'Lima, Per�' 			
		));
		
		Ubicacion::create(array(
			'descripcion' => 'San Miguel, Per�'
		));
	}
}