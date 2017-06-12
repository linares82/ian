<?php

class M_tpo_riesgosController extends BaseController {

	/**
	 * M_tpo_riesgo Repository
	 *
	 * @var M_tpo_riesgo
	 */
	protected $m_tpo_riesgo;

	public function __construct(M_tpo_riesgo $m_tpo_riesgo)
	{
		$this->m_tpo_riesgo = $m_tpo_riesgo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('m_tpo_riesgos.index');
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

		$count_rows=$this->m_tpo_riesgo->id($id)->count();

		$model=$this->m_tpo_riesgo
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
		return View::make('m_tpo_riesgos.create');
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
		$validation = Validator::make($input, M_tpo_riesgo::$rules, M_tpo_riesgo::$rulesMessages);

		if ($validation->passes())
		{
			$this->m_tpo_riesgo->create($input);

			return Redirect::route('m_tpo_riesgo.index');
		}

		return Redirect::route('m_tpo_riesgo.create')
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
		$m_tpo_riesgo = $this->m_tpo_riesgo->findOrFail($id);

		return View::make('m_tpo_riesgos.show', compact('m_tpo_riesgo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$m_tpo_riesgo = $this->m_tpo_riesgo->find($id);

		if (is_null($m_tpo_riesgo))
		{
			return Redirect::route('m_tpo_riesgos.index');
		}

		return View::make('m_tpo_riesgos.edit', compact('m_tpo_riesgo'));
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
		$validation = Validator::make($input, M_tpo_riesgo::$rules, M_tpo_riesgo::$rulesMessages);

		if ($validation->passes())
		{
			$m_tpo_riesgo = $this->m_tpo_riesgo->find($id);
			$m_tpo_riesgo->update($input);

			return Redirect::route('m_tpo_riesgo.show', $id);
		}

		return Redirect::route('m_tpo_riesgo.edit', $id)
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
		if ($this->m_tpo_riesgo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->m_tpo_riesgo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
