<?php

class Ca_tpo_noconformidadesController extends BaseController {

	/**
	 * Ca_tpo_noconformidade Repository
	 *
	 * @var Ca_tpo_noconformidade
	 */
	protected $ca_tpo_noconformidade;

	public function __construct(Ca_tpo_noconformidade $ca_tpo_noconformidade)
	{
		$this->ca_tpo_noconformidade = $ca_tpo_noconformidade;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Ca_tpo_bitacora::lists('tpo_bitacora','id');
		return View::make('ca_tpo_noconformidades.index', compact(['tpo_bitacoras_ls']));
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

		$count_rows=$this->ca_tpo_noconformidade->id($id)->count();

		$model=$this->ca_tpo_noconformidade
				->select('ca_tpo_noconformidades.id','tb.tpo_bitacora', 'ca_tpo_noconformidades.tpo_inconformidad', 
					'ca_tpo_noconformidades.created_at', 'ca_tpo_noconformidades.updated_at', 'ca_tpo_noconformidades.deleted_at')
				->join('ca_tpo_bitacoras as tb', 'tb.id', '=', 'ca_tpo_noconformidades.tpo_bitacora_id')
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
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Ca_tpo_bitacora::lists('tpo_bitacora','id');
		return View::make('ca_tpo_noconformidades.create', compact(['tpo_bitacoras_ls']));
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
		$validation = Validator::make($input, Ca_tpo_noconformidade::$rules, Ca_tpo_noconformidade::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_tpo_noconformidade->create($input);

			return Redirect::route('ca_tpo_noconformidade.index');
		}

		return Redirect::route('ca_tpo_noconformidade.create')
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
		$ca_tpo_noconformidade = $this->ca_tpo_noconformidade->findOrFail($id);
		
		return View::make('ca_tpo_noconformidades.show', compact('ca_tpo_noconformidade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_tpo_noconformidade = $this->ca_tpo_noconformidade->find($id);

		if (is_null($ca_tpo_noconformidade))
		{
			return Redirect::route('ca_tpo_noconformidade.index');
		}
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Ca_tpo_bitacora::lists('tpo_bitacora','id');
		return View::make('ca_tpo_noconformidades.edit', compact('ca_tpo_noconformidade', 'tpo_bitacoras_ls'));
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
		$validation = Validator::make($input, Ca_tpo_noconformidade::$rules, Ca_tpo_noconformidade::$rulesMessages);

		if ($validation->passes())
		{
			$ca_tpo_noconformidade = $this->ca_tpo_noconformidade->find($id);
			$ca_tpo_noconformidade->update($input);

			return Redirect::route('ca_tpo_noconformidade.show', $id);
		}

		return Redirect::route('ca_tpo_noconformidade.edit', $id)
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
		if ($this->ca_tpo_noconformidade->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_tpo_noconformidade->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
