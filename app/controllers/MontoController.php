<?php

class MontoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('monto.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('monto.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	public function search()
	{
		$s = Input::get('s');
		$in = Input::get('in');
		
		$data = Monto::all();
		
		foreach($data as $key => $monto){
			
			if($monto->entidad_id){
				$entidad = Entidad::find($monto->entidad_id);
				
				$monto->etiquetas = $entidad->categoria.', '.$entidad->subcategoria.', '.$entidad->nombre;			 	
			}else{
				$monto->etiquetas = "Otros";
			}
		}
		
		return View::make('monto.search')->with('question', $s.' en '.$in)->with('results', $data);
	}
}