<?php

class Aa_procesosController extends BaseController {

	/**
	 * Aa_proceso Repository
	 *
	 * @var Aa_proceso
	 */
	protected $aa_proceso;

	public function __construct(Aa_proceso $aa_proceso)
	{
		$this->aa_proceso = $aa_proceso;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('aa_procesos.index');
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

		$count_rows=$this->aa_proceso->id($id)->withTrashed()->count();

		$model=$this->aa_proceso
				->select('id', 'proceso', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('aa_procesos.create');
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
		$validation = Validator::make($input, Aa_proceso::$rules, Aa_proceso::$rulesMessages);

		if ($validation->passes())
		{
			$this->aa_proceso->create($input);

			return Redirect::route('aa_proceso.index');
		}

		return Redirect::route('aa_proceso.create')
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
		$aa_proceso = $this->aa_proceso->findOrFail($id);

		return View::make('aa_procesos.show', compact('aa_proceso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$aa_proceso = $this->aa_proceso->find($id);

		if (is_null($aa_proceso))
		{
			return Redirect::route('aa_procesos.index');
		}

		return View::make('aa_procesos.edit', compact('aa_proceso'));
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
		$validation = Validator::make($input, Aa_proceso::$rules, Aa_proceso::$rulesMessages);

		if ($validation->passes())
		{
			$aa_proceso = $this->aa_proceso->find($id);
			$aa_proceso->update($input);

			return Redirect::route('aa_proceso.show', $id);
		}

		return Redirect::route('aa_proceso.edit', $id)
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
		if ($this->aa_proceso->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->aa_proceso->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
