<?php

class Ca_tpo_inconformidadesController extends BaseController {

	/**
	 * Ca_tpo_inconformidade Repository
	 *
	 * @var Ca_tpo_inconformidade
	 */
	protected $ca_tpo_inconformidade;

	public function __construct(Ca_tpo_inconformidade $ca_tpo_inconformidade)
	{
		$this->ca_tpo_inconformidade = $ca_tpo_inconformidade;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('ca_tpo_inconformidades.index');
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

		$count_rows=$this->ca_tpo_inconformidade->id($id)->withTrashed()->count();

		$model=$this->ca_tpo_inconformidade
				->select('id', 'tpo_inconformidad', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('ca_tpo_inconformidades.create');
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
		$validation = Validator::make($input, Ca_tpo_inconformidade::$rules, Ca_tpo_inconformidade::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_tpo_inconformidade->create($input);

			return Redirect::route('ca_tpo_inconformidad.index');
		}

		return Redirect::route('ca_tpo_inconformidad.create')
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
		$ca_tpo_inconformidade = $this->ca_tpo_inconformidade->findOrFail($id);

		return View::make('ca_tpo_inconformidades.show', compact('ca_tpo_inconformidade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_tpo_inconformidade = $this->ca_tpo_inconformidade->find($id);

		if (is_null($ca_tpo_inconformidade))
		{
			return Redirect::route('ca_tpo_inconformidad.index');
		}

		return View::make('ca_tpo_inconformidades.edit', compact('ca_tpo_inconformidade'));
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
		$validation = Validator::make($input, Ca_tpo_inconformidade::$rules, Ca_tpo_inconformidade::$rulesMessages);

		if ($validation->passes())
		{
			$ca_tpo_inconformidade = $this->ca_tpo_inconformidade->find($id);
			$ca_tpo_inconformidade->update($input);

			return Redirect::route('ca_tpo_inconformidad.show', $id);
		}

		return Redirect::route('ca_tpo_inconformidad.edit', $id)
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
		if ($this->ca_tpo_inconformidade->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_tpo_inconformidade->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
