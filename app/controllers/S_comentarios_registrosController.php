<?php

class S_comentarios_registrosController extends BaseController {

	/**
	 * S_comentarios_registro Repository
	 *
	 * @var S_comentarios_registro
	 */
	protected $s_comentarios_registro;

	public function __construct(S_comentarios_registro $s_comentarios_registro)
	{
		$this->s_comentarios_registro = $s_comentarios_registro;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('s_comentarios_registros.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$s_registro = isset($_REQUEST['s_registro']) ? intval($_REQUEST['s_registro']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->s_comentarios_registro->id($id)->Registro($s_registro)->withTrashed()->count();

		$model=$this->s_comentarios_registro
				->select('s_comentarios_registros.id', 's_comentarios_registros.comentario', 'st.estatus', 'u.username',
					's_comentarios_registros.created_at', 's_comentarios_registros.updated_at', 's_comentarios_registros.deleted_at')
				->join('s_estatus_procedimientos as st', 'st.id', '=', 's_comentarios_registros.estatus_id')
				->join('users as u', 'u.id', '=', 's_comentarios_registros.usu_alta_id')
				->Id($id)->Registro($s_registro)
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
		return View::make('s_comentarios_registros.create');
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
		$validation = Validator::make($input, S_comentarios_registro::$rules, S_comentarios_registro::$rulesMessages);

		if ($validation->passes())
		{
			$this->s_comentarios_registro->create($input);

			return Redirect::route('s_comentarios_registro.index');
		}

		return Redirect::route('s_comentarios_registro.create')
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
		$s_comentarios_registro = $this->s_comentarios_registro->findOrFail($id);

		return View::make('s_comentarios_registros.show', compact('s_comentarios_registro'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_comentarios_registro = $this->s_comentarios_registro->find($id);

		if (is_null($s_comentarios_registro))
		{
			return Redirect::route('s_comentarios_registros.index');
		}

		return View::make('s_comentarios_registros.edit', compact('s_comentarios_registro'));
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
		$validation = Validator::make($input, S_comentarios_registro::$rules, S_comentarios_registro::$rulesMessages);

		if ($validation->passes())
		{
			$s_comentarios_registro = $this->s_comentarios_registro->find($id);
			$s_comentarios_registro->update($input);

			return Redirect::route('s_comentarios_registro.show', $id);
		}

		return Redirect::route('s_comentarios_registro.edit', $id)
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
		if ($this->s_comentarios_registro->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_comentarios_registro->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
