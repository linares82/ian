<?php

class S_estatus_procedimientosController extends BaseController {

	/**
	 * S_estatus_procedimiento Repository
	 *
	 * @var S_estatus_procedimiento
	 */
	protected $s_estatus_procedimiento;

	public function __construct(S_estatus_procedimiento $s_estatus_procedimiento)
	{
		$this->s_estatus_procedimiento = $s_estatus_procedimiento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('s_estatus_procedimientos.index');
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

		$count_rows=$this->s_estatus_procedimiento->id($id)->withTrashed()->count();

		$model=$this->s_estatus_procedimiento
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
		return View::make('s_estatus_procedimientos.create');
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
		$validation = Validator::make($input, S_estatus_procedimiento::$rules, S_estatus_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$this->s_estatus_procedimiento->create($input);

			return Redirect::route('s_estatus_procedimiento.index');
		}

		return Redirect::route('s_estatus_procedimiento.create')
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
		$s_estatus_procedimiento = $this->s_estatus_procedimiento->findOrFail($id);

		return View::make('s_estatus_procedimientos.show', compact('s_estatus_procedimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_estatus_procedimiento = $this->s_estatus_procedimiento->find($id);

		if (is_null($s_estatus_procedimiento))
		{
			return Redirect::route('s_estatus_procedimientos.index');
		}

		return View::make('s_estatus_procedimientos.edit', compact('s_estatus_procedimiento'));
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
		$validation = Validator::make($input, S_estatus_procedimiento::$rules, S_estatus_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$s_estatus_procedimiento = $this->s_estatus_procedimiento->find($id);
			$s_estatus_procedimiento->update($input);

			return Redirect::route('s_estatus_procedimiento.show', $id);
		}

		return Redirect::route('s_estatus_procedimiento.edit', $id)
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
		if ($this->s_estatus_procedimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_estatus_procedimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
