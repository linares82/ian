<?php

class MchecksController extends BaseController {

	/**
	 * Mcheck Repository
	 *
	 * @var Mcheck
	 */
	protected $mcheck;

	public function __construct(Mcheck $mcheck)
	{
		$this->mcheck = $mcheck;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');
		$normas_ls=['0' => 'Seleccionar'] + Norma::lists('norma','id');
		return View::make('mchecks.index', array('areas_ls'=>$areas_ls, 'normas_ls'=>$normas_ls));
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
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->mcheck->id($id)->Area($area)->Norma($norma)->orderBy($sort, $order)
					->withTrashed()->count();

		$model=$this->mcheck
				->select('mchecks.id', 'n.norma', 'a.area', 'mchecks.no_conformidad', 'mchecks.requisito', 'mchecks.rnc', 
						 'mchecks.minimo_vsm', 'mchecks.maximo_vsm', 'mchecks.orden', 'mchecks.created_at', 
						 'mchecks.updated_at', 'mchecks.deleted_at')
				->join('achecks as a', 'a.id', '=', 'mchecks.a_chequeo' )
				->join('normas as n', 'n.id', '=', 'mchecks.norma_id')
				->Id($id)->Area($area)->Norma($norma)
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
		$achecks_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');
		$normas_ls=['0' => 'Seleccionar'] + Norma::lists('norma','id');
		return View::make('mchecks.create', array('achecks_ls'=>$achecks_ls, 'normas_ls'=>$normas_ls));
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
		$validation = Validator::make($input, Mcheck::$rules, Mcheck::$rulesMessages);

		if ($validation->passes())
		{
			$this->mcheck->create($input);

			return Redirect::route('mcheck.index');
		}

		return Redirect::route('mcheck.create')
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
		$mcheck = $this->mcheck->findOrFail($id);

		return View::make('mchecks.show', compact('mcheck'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$mcheck = $this->mcheck->find($id);

		if (is_null($mcheck))
		{
			return Redirect::route('mchecks.index');
		}

		$achecks_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');
		$normas_ls=['0' => 'Seleccionar'] + Norma::lists('norma','id');
		return View::make('mchecks.edit', array('mcheck'=>$mcheck, 'achecks_ls'=>$achecks_ls, 'normas_ls'=>$normas_ls));
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
		$validation = Validator::make($input, Mcheck::$rules, Mcheck::$rulesMessages);

		if ($validation->passes())
		{
			$mcheck = $this->mcheck->find($id);
			$mcheck->update($input);

			return Redirect::route('mcheck.show', $id);
		}

		return Redirect::route('mcheck.edit', $id)
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
		if ($this->mcheck->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->mcheck->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
