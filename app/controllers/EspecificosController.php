<?php

class EspecificosController extends BaseController {

	/**
	 * Especifico Repository
	 *
	 * @var Especifico
	 */
	protected $especifico;

	public function __construct(Especifico $especifico)
	{
		$this->especifico = $especifico;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('especificos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$especifico = isset($_POST['especifico']) ? intval($_POST['especifico']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->especifico->id($id)->Especifico($especifico)->withTrashed()->count();

		$model=$this->especifico
				->select('id', 'especifico', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Especifico($especifico)
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
		return View::make('especificos.create');
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
		$validation = Validator::make($input, Especifico::$rules, Especifico::$rulesMessages);

		if ($validation->passes())
		{
			$this->especifico->create($input);

			return Redirect::route('especifico.index');
		}

		return Redirect::route('especifico.create')
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
		$especifico = $this->especifico->findOrFail($id);

		return View::make('especificos.show', compact('especifico'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$especifico = $this->especifico->find($id);

		if (is_null($especifico))
		{
			return Redirect::route('especificos.index');
		}

		return View::make('especificos.edit', compact('especifico'));
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
		$validation = Validator::make($input, Especifico::$rules, Especifico::$rulesMessages);

		if ($validation->passes())
		{
			$especifico = $this->especifico->find($id);
			$especifico->update($input);

			return Redirect::route('especifico.show', $id);
		}

		return Redirect::route('especifico.edit', $id)
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
		if ($this->especifico->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->especifico->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
