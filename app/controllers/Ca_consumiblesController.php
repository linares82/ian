<?php

class Ca_consumiblesController extends BaseController {

	/**
	 * Ca_consumible Repository
	 *
	 * @var Ca_consumible
	 */
	protected $ca_consumible;

	public function __construct(Ca_consumible $ca_consumible)
	{
		$this->ca_consumible = $ca_consumible;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('ca_consumibles.index');
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

		$count_rows=$this->ca_consumible->id($id)->withTrashed()->count();

		$model=$this->ca_consumible
				->select('id', 'consumible', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('ca_consumibles.create');
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
		$validation = Validator::make($input, Ca_consumible::$rules, Ca_consumible::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_consumible->create($input);

			return Redirect::route('ca_consumible.index');
		}

		return Redirect::route('ca_consumible.create')
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
		$ca_consumible = $this->ca_consumible->findOrFail($id);

		return View::make('ca_consumibles.show', compact('ca_consumible'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_consumible = $this->ca_consumible->find($id);

		if (is_null($ca_consumible))
		{
			return Redirect::route('ca_consumibles.index');
		}

		return View::make('ca_consumibles.edit', compact('ca_consumible'));
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
		$validation = Validator::make($input, Ca_consumible::$rules, Ca_consumible::$rulesMessages);

		if ($validation->passes())
		{
			$ca_consumible = $this->ca_consumible->find($id);
			$ca_consumible->update($input);

			return Redirect::route('ca_consumible.show', $id);
		}

		return Redirect::route('ca_consumible.edit', $id)
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
		if ($this->ca_consumible->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_consumible->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
