<?php

class S_comentarios_procedimientosController extends BaseController {

	/**
	 * S_comentarios_procedimiento Repository
	 *
	 * @var S_comentarios_procedimiento
	 */
	protected $s_comentarios_procedimiento;

	public function __construct(S_comentarios_procedimiento $s_comentarios_procedimiento)
	{
		$this->s_comentarios_procedimiento = $s_comentarios_procedimiento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('s_comentarios_procedimientos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$s_procedimiento = isset($_REQUEST['s_procedimiento']) ? intval($_REQUEST['s_procedimiento']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->s_comentarios_procedimiento
				->id($id)->procedimiento($s_procedimiento)->withTrashed()->count();

		$model=$this->s_comentarios_procedimiento
				->select('s_comentarios_procedimientos.id', 's_comentarios_procedimientos.comentario', 'st.estatus', 'u.username',
					's_comentarios_procedimientos.created_at', 's_comentarios_procedimientos.updated_at', 's_comentarios_procedimientos.deleted_at')
				->join('s_estatus_procedimientos as st', 'st.id', '=', 's_comentarios_procedimientos.estatus_id')
				->join('users as u', 'u.id', '=', 's_comentarios_procedimientos.usu_alta_id')
				->Id($id)->procedimiento($s_procedimiento)
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
		return View::make('s_comentarios_procedimientos.create');
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
		$validation = Validator::make($input, S_comentarios_procedimiento::$rules, S_comentarios_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$this->s_comentarios_procedimiento->create($input);

			return Redirect::route('s_comentarios_procedimiento.index');
		}

		return Redirect::route('s_comentarios_procedimiento.create')
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
		$s_comentarios_procedimiento = $this->s_comentarios_procedimiento->findOrFail($id);

		return View::make('s_comentarios_procedimientos.show', compact('s_comentarios_procedimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_comentarios_procedimiento = $this->s_comentarios_procedimiento->find($id);

		if (is_null($s_comentarios_procedimiento))
		{
			return Redirect::route('s_comentarios_procedimientos.index');
		}

		return View::make('s_comentarios_procedimientos.edit', compact('s_comentarios_procedimiento'));
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
		$validation = Validator::make($input, S_comentarios_procedimiento::$rules, S_comentarios_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$s_comentarios_procedimiento = $this->s_comentarios_procedimiento->find($id);
			$s_comentarios_procedimiento->update($input);

			return Redirect::route('s_comentarios_procedimiento.show', $id);
		}

		return Redirect::route('s_comentarios_procedimiento.edit', $id)
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
		if ($this->s_comentarios_procedimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_comentarios_procedimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
