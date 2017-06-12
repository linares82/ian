<?php

class Ca_tpo_bitacorasController extends BaseController {

	/**
	 * Ca_tpo_bitacora Repository
	 *
	 * @var Ca_tpo_bitacora
	 */
	protected $ca_tpo_bitacora;

	public function __construct(Ca_tpo_bitacora $ca_tpo_bitacora)
	{
		$this->ca_tpo_bitacora = $ca_tpo_bitacora;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('ca_tpo_bitacoras.index');
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

		$count_rows=$this->ca_tpo_bitacora->id($id)->count();

		$model=$this->ca_tpo_bitacora
				->select('id', 'tpo_bitacora', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('ca_tpo_bitacoras.create');
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
		$validation = Validator::make($input, Ca_tpo_bitacora::$rules, Ca_tpo_bitacora::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_tpo_bitacora->create($input);

			return Redirect::route('ca_tpo_bitacora.index');
		}

		return Redirect::route('ca_tpo_bitacora.create')
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
		$ca_tpo_bitacora = $this->ca_tpo_bitacora->findOrFail($id);

		return View::make('ca_tpo_bitacoras.show', compact('ca_tpo_bitacora'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_tpo_bitacora = $this->ca_tpo_bitacora->find($id);

		if (is_null($ca_tpo_bitacora))
		{
			return Redirect::route('ca_tpo_bitacoras.index');
		}

		return View::make('ca_tpo_bitacoras.edit', compact('ca_tpo_bitacora'));
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
		$validation = Validator::make($input, Ca_tpo_bitacora::$rules, Ca_tpo_bitacora::$rulesMessages);

		if ($validation->passes())
		{
			$ca_tpo_bitacora = $this->ca_tpo_bitacora->find($id);
			$ca_tpo_bitacora->update($input);

			return Redirect::route('ca_tpo_bitacora.show', $id);
		}

		return Redirect::route('ca_tpo_bitacora.edit', $id)
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
		if ($this->ca_tpo_bitacora->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_tpo_bitacora->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
