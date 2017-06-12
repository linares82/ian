<?php

class Duracion_accionsController extends BaseController {

	/**
	 * Duracion_accion Repository
	 *
	 * @var Duracion_accion
	 */
	protected $duracion_accion;

	public function __construct(Duracion_accion $duracion_accion)
	{
		$this->duracion_accion = $duracion_accion;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('duracion_accions.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->duracion_accion->id($id)->withTrashed()->count();

		$model=$this->duracion_accion
				->select('', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)
				->skip($offset)->take($rows)->orderBy($sort, $order)->withTrashed()->get();	
		
		$result["total"] = $count_rows;
		$result["rows"] = $model;

		echo json_encode($result);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('duracion_accions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Duracion_accion::$rules, Duracion_accion::$rulesMessages);

		if ($validation->passes())
		{
			$this->duracion_accion->create($input);

			return Redirect::route('duracion_accion.index');
		}

		return Redirect::route('duracion_accion.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$duracion_accion = $this->duracion_accion->findOrFail($id);

		return View::make('duracion_accions.show', compact('duracion_accion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$duracion_accion = $this->duracion_accion->find($id);

		if (is_null($duracion_accion))
		{
			return Redirect::route('duracion_accions.index');
		}

		return View::make('duracion_accions.edit', compact('duracion_accion'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Duracion_accion::$rules, Duracion_accion::$rulesMessages);

		if ($validation->passes())
		{
			$duracion_accion = $this->duracion_accion->find($id);
			$duracion_accion->update($input);

			return Redirect::route('duracion_accion.show', $id);
		}

		return Redirect::route('duracion_accion.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->duracion_accion->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->duracion_accion->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
