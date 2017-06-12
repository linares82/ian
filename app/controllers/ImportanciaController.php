<?php

class ImportanciaController extends BaseController {

	/**
	 * Importancium Repository
	 *
	 * @var Importancium
	 */
	protected $importancium;

	public function __construct(Importancium $importancium)
	{
		$this->importancium = $importancium;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('importancia.index');
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

		$count_rows=$this->importancium->id($id)->count();

		$model=$this->importancium
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
		return View::make('importancia.create');
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
		$validation = Validator::make($input, Importancium::$rules, Importancium::$rulesMessages);

		if ($validation->passes())
		{
			$this->importancium->create($input);

			return Redirect::route('importancium.index');
		}

		return Redirect::route('importancium.create')
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
		$importancium = $this->importancium->findOrFail($id);

		return View::make('importancia.show', compact('importancium'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$importancium = $this->importancium->find($id);

		if (is_null($importancium))
		{
			return Redirect::route('importancia.index');
		}

		return View::make('importancia.edit', compact('importancium'));
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
		$validation = Validator::make($input, Importancium::$rules, Importancium::$rulesMessages);

		if ($validation->passes())
		{
			$importancium = $this->importancium->find($id);
			$importancium->update($input);

			return Redirect::route('importancium.show', $id);
		}

		return Redirect::route('importancium.edit', $id)
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
		if ($this->importancium->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->importancium->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
