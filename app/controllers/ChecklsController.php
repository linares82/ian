<?php

class ChecklsController extends BaseController {

	/**
	 * Checkl Repository
	 *
	 * @var Checkl
	 */
	protected $checkl;

	public function __construct(Checkl $checkl)
	{
		$this->checkl = $checkl;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$check=$_GET['id'];
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');
		$cumplimiento_ls=['0' => 'Seleccionar'] + Cumplimiento::lists('cumplimiento','id');
		$normas_ls=['0' => 'Seleccionar'] + Norma::lists('norma','id');
		return View::make('checkls.index', array('check'=>$check, 'areas_ls'=>$areas_ls, 
												 'cumplimiento_ls'=>$cumplimiento_ls, 'normas_ls'=>$normas_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$area = isset($_POST['area']) ? intval($_POST['area']) : 0;
		$norma = isset($_POST['norma']) ? intval($_POST['norma']) : 0;
		$cumplimiento = isset($_POST['cumplimiento']) ? intval($_POST['cumplimiento']) : 0;
		$check=isset($_REQUEST['check']) ? intval($_REQUEST['check']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->checkl->id($id)
				->Check($check)->Area($area)->Norma($norma)->Cumplimiento($cumplimiento)
				->withTrashed()->count();

		$model=$this->checkl
				->select('checkls.id', 'checkls.check_id', 'a.area', 'n.norma', 'checkls.no_conformidad', 'checkls.especifico', 
						 'checkls.requisito', 'checkls.rnc', 'checkls.minimo_vsm', 'checkls.maximo_vsm', 'c.cumplimiento',
						 'checkls.monto_min', 'checkls.monto_medio', 'checkls.monto_max', 'checkls.created_at', 
						 'checkls.updated_at', 'checkls.deleted_at')
				->join('achecks as a', 'a.id', '=', 'checkls.a_chequeo')
				->join('normas as n', 'n.id', '=', 'checkls.norma_id')
				->join('cumplimientos as c', 'c.id', '=', 'checkls.cumplimiento')
				->Id($id)->Check($check)->Area($area)->Norma($norma)->Cumplimiento($cumplimiento)
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
	public function create($id)
	{
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');
		$cumplimiento_ls=['0' => 'Seleccionar'] + Cumplimiento::lists('cumplimiento','id');
		$normas_ls=['0' => 'Seleccionar'] + Norma::lists('norma','id');
		$check=$id;
		return View::make('checkls.create', array('areas_ls'=>$areas_ls, 'check'=>$check, 
												  'cumplimiento_ls'=>$cumplimiento_ls,
												  'normas_ls'=>$normas_ls));
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
		$validation = Validator::make($input, Checkl::$rules, Checkl::$rulesMessages);

		if ($validation->passes())
		{
			$this->checkl->create($input);

			return Redirect::route('checkl.index');
		}

		return Redirect::route('checkl.create')
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
		$checkl = $this->checkl->findOrFail($id);

		return View::make('checkls.show', compact('checkl'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$checkl = $this->checkl->find($id);

		if (is_null($checkl))
		{
			return Redirect::route('checkls.index');
		}
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');
		$cumplimiento_ls=['0' => 'Seleccionar'] + Cumplimiento::lists('cumplimiento','id');
		$normas_ls=['0' => 'Seleccionar'] + Norma::lists('norma','id');
		return View::make('checkls.edit', array('checkl'=>$checkl, 'areas_ls'=>$areas_ls, 
												'cumplimiento_ls'=>$cumplimiento_ls, 'normas_ls'=>$normas_ls));
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
		$validation = Validator::make($input, Checkl::$rules, Checkl::$rulesMessages);

		if ($validation->passes())
		{
			$checkl = $this->checkl->find($id);
			$checkl->update($input);

			return Redirect::route('checkl.show', $id);
		}

		return Redirect::route('checkl.edit', $id)
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
		if ($this->checkl->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->checkl->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
