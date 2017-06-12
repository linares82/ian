<?php

class P_ambiental_correosController extends BaseController {

	/**
	 * P_ambiental_correo Repository
	 *
	 * @var P_ambiental_correo
	 */
	protected $p_ambiental_correo;

	public function __construct(P_ambiental_correo $p_ambiental_correo)
	{
		$this->p_ambiental_correo = $p_ambiental_correo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('p_ambiental_correos.index');
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

		$count_rows=$this->p_ambiental_correo->id($id)->withTrashed()->count();

		$model=$this->p_ambiental_correo
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
		return View::make('p_ambiental_correos.create');
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
		$validation = Validator::make($input, P_ambiental_correo::$rules, P_ambiental_correo::$rulesMessages);

		if ($validation->passes())
		{
			$this->p_ambiental_correo->create($input);

			return Redirect::route('p_ambiental_correo.index');
		}

		return Redirect::route('p_ambiental_correo.create')
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
		$p_ambiental_correo = $this->p_ambiental_correo->findOrFail($id);

		return View::make('p_ambiental_correos.show', compact('p_ambiental_correo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$p_ambiental_correo = $this->p_ambiental_correo->find($id);

		if (is_null($p_ambiental_correo))
		{
			return Redirect::route('p_ambiental_correos.index');
		}

		return View::make('p_ambiental_correos.edit', compact('p_ambiental_correo'));
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
		$validation = Validator::make($input, P_ambiental_correo::$rules, P_ambiental_correo::$rulesMessages);

		if ($validation->passes())
		{
			$p_ambiental_correo = $this->p_ambiental_correo->find($id);
			$p_ambiental_correo->update($input);

			return Redirect::route('p_ambiental_correo.show', $id);
		}

		return Redirect::route('p_ambiental_correo.edit', $id)
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
		if ($this->p_ambiental_correo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->p_ambiental_correo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
