<?php

class Comentarios_bsController extends BaseController {

	/**
	 * Comentarios_b Repository
	 *
	 * @var Comentarios_b
	 */
	protected $comentarios_b;

	public function __construct(Comentarios_b $comentarios_b)
	{
		$this->comentarios_b = $comentarios_b;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('comentarios_bs.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$bitacora_seguridad = isset($_REQUEST['bitacora_seguridad']) ? intval($_REQUEST['bitacora_seguridad']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->comentarios_b->
				id($id)->BitacoraSeguridad($bitacora_seguridad)->withTrashed()->count();

		$model=$this->comentarios_b
				->select('comentarios_bs.id', 'comentarios_bs.comentario', 'comentarios_bs.costo', 
					'st.estatus', 'u.username',
					'comentarios_bs.created_at', 'comentarios_bs.updated_at', 'comentarios_bs.deleted_at')
				->join('s_st_bs as st', 'st.id', '=', 'comentarios_bs.estatus_id')
				->join('users as u', 'u.id', '=', 'comentarios_bs.usu_alta_id')
				->Id($id)->BitacoraSeguridad($bitacora_seguridad)
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
		return View::make('comentarios_bs.create');
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
		$validation = Validator::make($input, Comentarios_b::$rules, Comentarios_b::$rulesMessages);

		if ($validation->passes())
		{
			$this->comentarios_b->create($input);

			return Redirect::route('comentarios_b.index');
		}

		return Redirect::route('comentarios_b.create')
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
		$comentarios_b = $this->comentarios_b->findOrFail($id);

		return View::make('comentarios_bs.show', compact('comentarios_b'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$comentarios_b = $this->comentarios_b->find($id);

		if (is_null($comentarios_b))
		{
			return Redirect::route('comentarios_bs.index');
		}

		return View::make('comentarios_bs.edit', compact('comentarios_b'));
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
		$validation = Validator::make($input, Comentarios_b::$rules, Comentarios_b::$rulesMessages);

		if ($validation->passes())
		{
			$comentarios_b = $this->comentarios_b->find($id);
			$comentarios_b->update($input);

			return Redirect::route('comentarios_b.show', $id);
		}

		return Redirect::route('comentarios_b.edit', $id)
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
		if ($this->comentarios_b->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->comentarios_b->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
