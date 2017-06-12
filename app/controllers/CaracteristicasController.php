<?php

class CaracteristicasController extends BaseController {

	/**
	 * Caracteristica Repository
	 *
	 * @var Caracteristica
	 */
	protected $caracteristica;

	public function __construct(Caracteristica $caracteristica)
	{
		$this->caracteristica = $caracteristica;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('caracteristicas.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$caracteristica = isset($_POST['caracteristica']) ? strval($_POST['caracteristica']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->caracteristica->id($id)->Caracteristica($caracteristica)->withTrashed()->count();

		$model=$this->caracteristica
				->select('id', 'caracteristica', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Caracteristica($caracteristica)
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
		return View::make('caracteristicas.create');
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
		$validation = Validator::make($input, Caracteristica::$rules, Caracteristica::$rulesMessages);

		if ($validation->passes())
		{
			$this->caracteristica->create($input);

			return Redirect::route('caracteristica.index');
		}

		return Redirect::route('caracteristica.create')
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
		$caracteristica = $this->caracteristica->findOrFail($id);

		return View::make('caracteristicas.show', compact('caracteristica'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$caracteristica = $this->caracteristica->find($id);

		if (is_null($caracteristica))
		{
			return Redirect::route('caracteristicas.index');
		}

		return View::make('caracteristicas.edit', compact('caracteristica'));
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
		$validation = Validator::make($input, Caracteristica::$rules, Caracteristica::$rulesMessages);

		if ($validation->passes())
		{
			$caracteristica = $this->caracteristica->find($id);
			$caracteristica->update($input);

			return Redirect::route('caracteristica.show', $id);
		}

		return Redirect::route('caracteristica.edit', $id)
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
		if ($this->caracteristica->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->caracteristica->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
