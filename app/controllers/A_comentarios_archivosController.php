<?php

class A_comentarios_archivosController extends BaseController {

	/**
	 * A_comentarios_archivo Repository
	 *
	 * @var A_comentarios_archivo
	 */
	protected $a_comentarios_archivo;

	public function __construct(A_comentarios_archivo $a_comentarios_archivo)
	{
		$this->a_comentarios_archivo = $a_comentarios_archivo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_comentarios_archivos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$archivo = isset($_REQUEST['a_archivo']) ? intval($_REQUEST['a_archivo']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_comentarios_archivo->id($id)->Archivo($archivo)->withTrashed()->count();

		$model=$this->a_comentarios_archivo
				->select('a_comentarios_archivos.id', 'a_comentarios_archivos.comentario','st.estatus', 
					'u.username','a_comentarios_archivos.created_at', 'a_comentarios_archivos.updated_at', 
					'a_comentarios_archivos.deleted_at')
				->join('a_st_archivos as st', 'st.id', '=', 'a_comentarios_archivos.a_st_archivo_id')
				->join('users as u', 'u.id', '=', 'a_comentarios_archivos.usu_alta_id')
				->Id($id)->Archivo($archivo)
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
		return View::make('a_comentarios_archivos.create');
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
		$validation = Validator::make($input, A_comentarios_archivo::$rules, A_comentarios_archivo::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_comentarios_archivo->create($input);

			return Redirect::route('a_comentarios_archivo.index');
		}

		return Redirect::route('a_comentarios_archivo.create')
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
		$a_comentarios_archivo = $this->a_comentarios_archivo->findOrFail($id);

		return View::make('a_comentarios_archivos.show', compact('a_comentarios_archivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_comentarios_archivo = $this->a_comentarios_archivo->find($id);

		if (is_null($a_comentarios_archivo))
		{
			return Redirect::route('a_comentarios_archivos.index');
		}

		return View::make('a_comentarios_archivos.edit', compact('a_comentarios_archivo'));
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
		$validation = Validator::make($input, A_comentarios_archivo::$rules, A_comentarios_archivo::$rulesMessages);

		if ($validation->passes())
		{
			$a_comentarios_archivo = $this->a_comentarios_archivo->find($id);
			$a_comentarios_archivo->update($input);

			return Redirect::route('a_comentarios_archivo.show', $id);
		}

		return Redirect::route('a_comentarios_archivo.edit', $id)
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
		if ($this->a_comentarios_archivo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_comentarios_archivo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
