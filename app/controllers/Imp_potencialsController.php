<?php

class Imp_potencialsController extends BaseController {

	/**
	 * Imp_potencial Repository
	 *
	 * @var Imp_potencial
	 */
	protected $imp_potencial;

	public function __construct(Imp_potencial $imp_potencial)
	{
		$this->imp_potencial = $imp_potencial;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('imp_potencials.index');
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

		$count_rows=$this->imp_potencial->id($id)->count();

		$model=$this->imp_potencial
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
		return View::make('imp_potencials.create');
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
		$validation = Validator::make($input, Imp_potencial::$rules, Imp_potencial::$rulesMessages);

		if ($validation->passes())
		{
			$this->imp_potencial->create($input);

			return Redirect::route('imp_potencial.index');
		}

		return Redirect::route('imp_potencial.create')
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
		$imp_potencial = $this->imp_potencial->findOrFail($id);

		return View::make('imp_potencials.show', compact('imp_potencial'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$imp_potencial = $this->imp_potencial->find($id);

		if (is_null($imp_potencial))
		{
			return Redirect::route('imp_potencials.index');
		}

		return View::make('imp_potencials.edit', compact('imp_potencial'));
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
		$validation = Validator::make($input, Imp_potencial::$rules, Imp_potencial::$rulesMessages);

		if ($validation->passes())
		{
			$imp_potencial = $this->imp_potencial->find($id);
			$imp_potencial->update($input);

			return Redirect::route('imp_potencial.show', $id);
		}

		return Redirect::route('imp_potencial.edit', $id)
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
		if ($this->imp_potencial->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->imp_potencial->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
