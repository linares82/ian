<?php

class A_comentarios_ncsController extends BaseController {

	/**
	 * A_comentarios_nc Repository
	 *
	 * @var A_comentarios_nc
	 */
	protected $a_comentarios_nc;

	public function __construct(A_comentarios_nc $a_comentarios_nc)
	{
		$this->a_comentarios_nc = $a_comentarios_nc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_comentarios_ncs.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$no_conformidad = isset($_REQUEST['no_conformidad']) ? intval($_REQUEST['no_conformidad']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_comentarios_nc->id($id)->NoConformidad($no_conformidad)->withTrashed()->count();

		$model=$this->a_comentarios_nc
				->select('a_comentarios_ncs.id', 'a_comentarios_ncs.comentario', 'a_comentarios_ncs.costo', 
					'st.estatus', 'u.username',
					'a_comentarios_ncs.created_at', 'a_comentarios_ncs.updated_at', 'a_comentarios_ncs.deleted_at')
				->join('a_st_ncs as st', 'st.id', '=', 'a_comentarios_ncs.estatus_id')
				->join('users as u', 'u.id', '=', 'a_comentarios_ncs.usu_alta_id')
				->Id($id)->NoConformidad($no_conformidad)
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
		return View::make('a_comentarios_ncs.create');
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
		$validation = Validator::make($input, A_comentarios_nc::$rules, A_comentarios_nc::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_comentarios_nc->create($input);

			return Redirect::route('a_comentarios_nc.index');
		}

		return Redirect::route('a_comentarios_nc.create')
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
		$a_comentarios_nc = $this->a_comentarios_nc->findOrFail($id);

		return View::make('a_comentarios_ncs.show', compact('a_comentarios_nc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_comentarios_nc = $this->a_comentarios_nc->find($id);

		if (is_null($a_comentarios_nc))
		{
			return Redirect::route('a_comentarios_ncs.index');
		}

		return View::make('a_comentarios_ncs.edit', compact('a_comentarios_nc'));
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
		$validation = Validator::make($input, A_comentarios_nc::$rules, A_comentarios_nc::$rulesMessages);

		if ($validation->passes())
		{
			$a_comentarios_nc = $this->a_comentarios_nc->find($id);
			$a_comentarios_nc->update($input);

			return Redirect::route('a_comentarios_nc.show', $id);
		}

		return Redirect::route('a_comentarios_nc.edit', $id)
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
		if ($this->a_comentarios_nc->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_comentarios_nc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
