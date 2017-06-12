<?php

class Ca_residuosController extends BaseController {

	/**
	 * Ca_residuo Repository
	 *
	 * @var Ca_residuo
	 */
	protected $ca_residuo;

	public function __construct(Ca_residuo $ca_residuo)
	{
		$this->ca_residuo = $ca_residuo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd', 'id');
		return View::make('ca_residuos.index', array('bnds_ls'=>$bnds_ls));
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

		$count_rows=$this->ca_residuo->id($id)->withTrashed()->count();

		$model=$this->ca_residuo
				->select('id', 'residuo', 'created_at', 'updated_at', 'deleted_at')
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
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd', 'id');
		return View::make('ca_residuos.create', array('bnds_ls'=>$bnds_ls));
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
		$validation = Validator::make($input, Ca_residuo::$rules, Ca_residuo::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_residuo->create($input);

			return Redirect::route('ca_residuo.index');
		}

		return Redirect::route('ca_residuo.create')
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
		$ca_residuo = $this->ca_residuo->findOrFail($id);

		return View::make('ca_residuos.show', compact('ca_residuo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_residuo = $this->ca_residuo->find($id);

		if (is_null($ca_residuo))
		{
			return Redirect::route('ca_residuos.index');
		}
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd', 'id');
		return View::make('ca_residuos.edit', array('ca_residuo'=>$ca_residuo, 'bnds_ls'=>$bnds_ls));
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
		$validation = Validator::make($input, Ca_residuo::$rules, Ca_residuo::$rulesMessages);

		if ($validation->passes())
		{
			$ca_residuo = $this->ca_residuo->find($id);
			$ca_residuo->update($input);

			return Redirect::route('ca_residuo.show', $id);
		}

		return Redirect::route('ca_residuo.edit', $id)
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
		if ($this->ca_residuo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_residuo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
