<?php

class Ln_caracteristicasController extends BaseController {

	/**
	 * Ln_caracteristica Repository
	 *
	 * @var Ln_caracteristica
	 */
	protected $ln_caracteristica;

	public function __construct(Ln_caracteristica $ln_caracteristica)
	{
		$this->ln_caracteristica = $ln_caracteristica;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('ln_caracteristicas.index');
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

		$count_rows=$this->ln_caracteristica->id($id)->withTrashed()->count();

		$model=$this->ln_caracteristica
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
		return View::make('ln_caracteristicas.create');
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
		$validation = Validator::make($input, Ln_caracteristica::$rules, Ln_caracteristica::$rulesMessages);

		if ($validation->passes())
		{
			$this->ln_caracteristica->create($input);

			return Redirect::route('ln_caracteristica.index');
		}

		return Redirect::route('ln_caracteristica.create')
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
		$ln_caracteristica = $this->ln_caracteristica->findOrFail($id);

		return View::make('ln_caracteristicas.show', compact('ln_caracteristica'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ln_caracteristica = $this->ln_caracteristica->find($id);

		if (is_null($ln_caracteristica))
		{
			return Redirect::route('ln_caracteristicas.index');
		}

		return View::make('ln_caracteristicas.edit', compact('ln_caracteristica'));
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
		$validation = Validator::make($input, Ln_caracteristica::$rules, Ln_caracteristica::$rulesMessages);

		if ($validation->passes())
		{
			$ln_caracteristica = $this->ln_caracteristica->find($id);
			$ln_caracteristica->update($input);

			return Redirect::route('ln_caracteristica.show', $id);
		}

		return Redirect::route('ln_caracteristica.edit', $id)
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
		if ($this->ln_caracteristica->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ln_caracteristica->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
