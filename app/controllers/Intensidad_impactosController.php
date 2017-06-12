<?php

class Intensidad_impactosController extends BaseController {

	/**
	 * Intensidad_impacto Repository
	 *
	 * @var Intensidad_impacto
	 */
	protected $intensidad_impacto;

	public function __construct(Intensidad_impacto $intensidad_impacto)
	{
		$this->intensidad_impacto = $intensidad_impacto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('intensidad_impactos.index');
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

		$count_rows=$this->intensidad_impacto->id($id)->withTrashed()->count();

		$model=$this->intensidad_impacto
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
		return View::make('intensidad_impactos.create');
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
		$validation = Validator::make($input, Intensidad_impacto::$rules, Intensidad_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$this->intensidad_impacto->create($input);

			return Redirect::route('intensidad_impacto.index');
		}

		return Redirect::route('intensidad_impacto.create')
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
		$intensidad_impacto = $this->intensidad_impacto->findOrFail($id);

		return View::make('intensidad_impactos.show', compact('intensidad_impacto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$intensidad_impacto = $this->intensidad_impacto->find($id);

		if (is_null($intensidad_impacto))
		{
			return Redirect::route('intensidad_impactos.index');
		}

		return View::make('intensidad_impactos.edit', compact('intensidad_impacto'));
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
		$validation = Validator::make($input, Intensidad_impacto::$rules, Intensidad_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$intensidad_impacto = $this->intensidad_impacto->find($id);
			$intensidad_impacto->update($input);

			return Redirect::route('intensidad_impacto.show', $id);
		}

		return Redirect::route('intensidad_impacto.edit', $id)
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
		if ($this->intensidad_impacto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->intensidad_impacto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
