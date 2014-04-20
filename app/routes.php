<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

interface GreetableInterface
{
	public function greet();
}

class HelloWorld implements GreetableInterface 
{
	public function greet()
	{
		return 'Hello World!';
	}
}

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/container', function()
{
	// Get Application instance
	$app = App::getFacadeRoot();
	
	$app->bind('GreetableInterface', function()
	{
		return new HelloWorld;		
	});
	
	$greeter = $app->make('GreetableInterface');
	
	return $greeter->greet();;
});

Route::resource('ubicacion', 'UbicacionController');

Route::get('api/search', 'SearchController@index');

Route::get('search/categoria', 'SearchController@categoria');
Route::get('search/entidad', 'SearchController@entidad');

Route::post(
	'ubicacion/search',
	array(
		'as' => 'ubicacion.search',
		'uses' => 'UbicacionController@ubicacionSearch'
	)
);

Route::get('/', 'MontoController@index');

Route::get('crear-monto', 'MontoController@create');
Route::get('search', 'MontoController@search');
Route::post('search', 'MontoController@search');
