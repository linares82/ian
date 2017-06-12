<?php

class A_comentarios_pendientesController extends BaseController {

	/**
	 * A_comentarios_pendiente Repository
	 *
	 * @var A_comentarios_pendiente
	 */
	protected $a_comentarios_pendiente;

	public function __construct(A_comentarios_pendiente $a_comentarios_pendiente)
	{
		$this->a_comentarios_pendiente = $a_comentarios_pendiente;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_comentarios_pendientes.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$bitacora_pendiente = isset($_REQUEST['bitacora_pendiente']) ? intval($_REQUEST['bitacora_pendiente']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_comentarios_pendiente->id($id)->BitacoraPendiente($bitacora_pendiente)->withTrashed()->count();

		$model=$this->a_comentarios_pendiente
				->select('a_comentarios_pendientes.id','a_comentarios_pendientes.comentario', 'st.estatus', 
					'u.username','a_comentarios_pendientes.created_at', 'a_comentarios_pendientes.updated_at', 'a_comentarios_pendientes.deleted_at')
				->join('bit_sts as st', 'st.id', '=', 'a_comentarios_pendientes.estatus_id')
				->join('users as u', 'u.id', '=', 'a_comentarios_pendientes.usu_alta_id')
				->Id($id)->BitacoraPendiente($bitacora_pendiente)
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
		return View::make('a_comentarios_pendientes.create');
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
		$validation = Validator::make($input, A_comentarios_pendiente::$rules, A_comentarios_pendiente::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_comentarios_pendiente->create($input);

			return Redirect::route('a_comentarios_pendiente.index');
		}

		return Redirect::route('a_comentarios_pendiente.create')
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
		$a_comentarios_pendiente = $this->a_comentarios_pendiente->findOrFail($id);

		return View::make('a_comentarios_pendientes.show', compact('a_comentarios_pendiente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_comentarios_pendiente = $this->a_comentarios_pendiente->find($id);

		if (is_null($a_comentarios_pendiente))
		{
			return Redirect::route('a_comentarios_pendientes.index');
		}

		return View::make('a_comentarios_pendientes.edit', compact('a_comentarios_pendiente'));
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
		$validation = Validator::make($input, A_comentarios_pendiente::$rules, A_comentarios_pendiente::$rulesMessages);

		if ($validation->passes())
		{
			$a_comentarios_pendiente = $this->a_comentarios_pendiente->find($id);
			$a_comentarios_pendiente->update($input);

			return Redirect::route('a_comentarios_pendiente.show', $id);
		}

		return Redirect::route('a_comentarios_pendiente.edit', $id)
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
		if ($this->a_comentarios_pendiente->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_comentarios_pendiente->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
