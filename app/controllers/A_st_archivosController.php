<?php

class A_st_archivosController extends BaseController {

	/**
	 * A_st_archivo Repository
	 *
	 * @var A_st_archivo
	 */
	protected $a_st_archivo;

	public function __construct(A_st_archivo $a_st_archivo)
	{
		$this->a_st_archivo = $a_st_archivo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_st_archivos.index');
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

		$count_rows=$this->a_st_archivo->id($id)->withTrashed()->count();

		$model=$this->a_st_archivo
				->select('','a_st_archivos.created_at', 'a_st_archivos.updated_at', 
					'a_st_archivos.deleted_at')
				->join('a_st_archivos as st', 'st.id', '=', 'a_st_archivos.estatus_id')
				->join('users as u', 'ud.id', '=', 'a_st_archivos.usu_alta_id')
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
		return View::make('a_st_archivos.create');
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
		$validation = Validator::make($input, A_st_archivo::$rules, A_st_archivo::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_st_archivo->create($input);

			return Redirect::route('a_st_archivo.index');
		}

		return Redirect::route('a_st_archivo.create')
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
		$a_st_archivo = $this->a_st_archivo->findOrFail($id);

		return View::make('a_st_archivos.show', compact('a_st_archivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_st_archivo = $this->a_st_archivo->find($id);

		if (is_null($a_st_archivo))
		{
			return Redirect::route('a_st_archivos.index');
		}

		return View::make('a_st_archivos.edit', compact('a_st_archivo'));
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
		$validation = Validator::make($input, A_st_archivo::$rules, A_st_archivo::$rulesMessages);

		if ($validation->passes())
		{
			$a_st_archivo = $this->a_st_archivo->find($id);
			$a_st_archivo->update($input);

			return Redirect::route('a_st_archivo.show', $id);
		}

		return Redirect::route('a_st_archivo.edit', $id)
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
		if ($this->a_st_archivo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_st_archivo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
