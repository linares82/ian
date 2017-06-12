<?php

class Estatus_requisitosController extends BaseController {

	/**
	 * Estatus_requisito Repository
	 *
	 * @var Estatus_requisito
	 */
	protected $estatus_requisito;

	public function __construct(Estatus_requisito $estatus_requisito)
	{
		$this->estatus_requisito = $estatus_requisito;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('estatus_requisitos.index');
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

		$count_rows=$this->estatus_requisito->id($id)->count();

		$model=$this->estatus_requisito
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
		return View::make('estatus_requisitos.create');
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
		$validation = Validator::make($input, Estatus_requisito::$rules, Estatus_requisito::$rulesMessages);

		if ($validation->passes())
		{
			$this->estatus_requisito->create($input);

			return Redirect::route('estatus_requisito.index');
		}

		return Redirect::route('estatus_requisito.create')
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
		$estatus_requisito = $this->estatus_requisito->findOrFail($id);

		return View::make('estatus_requisitos.show', compact('estatus_requisito'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$estatus_requisito = $this->estatus_requisito->find($id);

		if (is_null($estatus_requisito))
		{
			return Redirect::route('estatus_requisitos.index');
		}

		return View::make('estatus_requisitos.edit', compact('estatus_requisito'));
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
		$validation = Validator::make($input, Estatus_requisito::$rules, Estatus_requisito::$rulesMessages);

		if ($validation->passes())
		{
			$estatus_requisito = $this->estatus_requisito->find($id);
			$estatus_requisito->update($input);

			return Redirect::route('estatus_requisito.show', $id);
		}

		return Redirect::route('estatus_requisito.edit', $id)
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
		if ($this->estatus_requisito->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->estatus_requisito->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
