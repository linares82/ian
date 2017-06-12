<?php

class Tipo_impactosController extends BaseController {

	/**
	 * Tipo_impacto Repository
	 *
	 * @var Tipo_impacto
	 */
	protected $tipo_impacto;

	public function __construct(Tipo_impacto $tipo_impacto)
	{
		$this->tipo_impacto = $tipo_impacto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('tipo_impactos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$tipo_impacto = isset($_POST['tipo_impacto']) ? strval($_POST['tipo_impacto']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->tipo_impacto->id($id)->TipoImpacto($tipo_impacto)->withTrashed()->count();

		$model=$this->tipo_impacto
				->select('id', 'tipo_impacto', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->TipoImpacto($tipo_impacto)
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
		return View::make('tipo_impactos.create');
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
		$validation = Validator::make($input, Tipo_impacto::$rules, Tipo_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$this->tipo_impacto->create($input);

			return Redirect::route('tipo_impacto.index');
		}

		return Redirect::route('tipo_impacto.create')
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
		$tipo_impacto = $this->tipo_impacto->findOrFail($id);

		return View::make('tipo_impactos.show', compact('tipo_impacto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipo_impacto = $this->tipo_impacto->find($id);

		if (is_null($tipo_impacto))
		{
			return Redirect::route('tipo_impactos.index');
		}

		return View::make('tipo_impactos.edit', compact('tipo_impacto'));
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
		$validation = Validator::make($input, Tipo_impacto::$rules, Tipo_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$tipo_impacto = $this->tipo_impacto->find($id);
			$tipo_impacto->update($input);

			return Redirect::route('tipo_impacto.show', $id);
		}

		return Redirect::route('tipo_impacto.edit', $id)
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
		if ($this->tipo_impacto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->tipo_impacto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
