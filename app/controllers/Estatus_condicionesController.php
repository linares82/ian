<?php

class Estatus_condicionesController extends BaseController {

	/**
	 * Estatus_condicione Repository
	 *
	 * @var Estatus_condicione
	 */
	protected $estatus_condicione;

	public function __construct(Estatus_condicione $estatus_condicione)
	{
		$this->estatus_condicione = $estatus_condicione;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('estatus_condiciones.index');
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

		$count_rows=$this->estatus_condicione->id($id)->count();

		$model=$this->estatus_condicione
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
		return View::make('estatus_condiciones.create');
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
		$validation = Validator::make($input, Estatus_condicione::$rules, Estatus_condicione::$rulesMessages);

		if ($validation->passes())
		{
			$this->estatus_condicione->create($input);

			return Redirect::route('estatus_condicione.index');
		}

		return Redirect::route('estatus_condicione.create')
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
		$estatus_condicione = $this->estatus_condicione->findOrFail($id);

		return View::make('estatus_condiciones.show', compact('estatus_condicione'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$estatus_condicione = $this->estatus_condicione->find($id);

		if (is_null($estatus_condicione))
		{
			return Redirect::route('estatus_condiciones.index');
		}

		return View::make('estatus_condiciones.edit', compact('estatus_condicione'));
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
		$validation = Validator::make($input, Estatus_condicione::$rules, Estatus_condicione::$rulesMessages);

		if ($validation->passes())
		{
			$estatus_condicione = $this->estatus_condicione->find($id);
			$estatus_condicione->update($input);

			return Redirect::route('estatus_condicione.show', $id);
		}

		return Redirect::route('estatus_condicione.edit', $id)
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
		if ($this->estatus_condicione->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->estatus_condicione->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
