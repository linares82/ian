<?php

class S_comentarios_documentosController extends BaseController {

	/**
	 * S_comentarios_documento Repository
	 *
	 * @var S_comentarios_documento
	 */
	protected $s_comentarios_documento;

	public function __construct(S_comentarios_documento $s_comentarios_documento)
	{
		$this->s_comentarios_documento = $s_comentarios_documento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('s_comentarios_documentos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$s_documento = isset($_REQUEST['s_documento']) ? intval($_REQUEST['s_documento']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->s_comentarios_documento->id($id)->Documento($s_documento)->withTrashed()->count();

		$model=$this->s_comentarios_documento
				->select('s_comentarios_documentos.id', 's_comentarios_documentos.comentario', 'st.estatus', 'u.username',
					's_comentarios_documentos.created_at', 's_comentarios_documentos.updated_at', 's_comentarios_documentos.deleted_at')
				->join('s_estatus_procedimientos as st', 'st.id', '=', 's_comentarios_documentos.estatus_id')
				->join('users as u', 'u.id', '=', 's_comentarios_documentos.usu_alta_id')
				->Id($id)->Documento($s_documento)
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
		return View::make('s_comentarios_documentos.create');
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
		$validation = Validator::make($input, S_comentarios_documento::$rules, S_comentarios_documento::$rulesMessages);

		if ($validation->passes())
		{
			$this->s_comentarios_documento->create($input);

			return Redirect::route('s_comentarios_documento.index');
		}

		return Redirect::route('s_comentarios_documento.create')
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
		$s_comentarios_documento = $this->s_comentarios_documento->findOrFail($id);

		return View::make('s_comentarios_documentos.show', compact('s_comentarios_documento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_comentarios_documento = $this->s_comentarios_documento->find($id);

		if (is_null($s_comentarios_documento))
		{
			return Redirect::route('s_comentarios_documentos.index');
		}

		return View::make('s_comentarios_documentos.edit', compact('s_comentarios_documento'));
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
		$validation = Validator::make($input, S_comentarios_documento::$rules, S_comentarios_documento::$rulesMessages);

		if ($validation->passes())
		{
			$s_comentarios_documento = $this->s_comentarios_documento->find($id);
			$s_comentarios_documento->update($input);

			return Redirect::route('s_comentarios_documento.show', $id);
		}

		return Redirect::route('s_comentarios_documento.edit', $id)
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
		if ($this->s_comentarios_documento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_comentarios_documento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
