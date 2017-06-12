<?php

class M_clase_mantosController extends BaseController {

	/**
	 * M_clase_manto Repository
	 *
	 * @var M_clase_manto
	 */
	protected $m_clase_manto;

	public function __construct(M_clase_manto $m_clase_manto)
	{
		$this->m_clase_manto = $m_clase_manto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('m_clase_mantos.index');
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

		$count_rows=$this->m_clase_manto->id($id)->count();

		$model=$this->m_clase_manto
				->select('id', 'clase_manto', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('m_clase_mantos.create');
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
		$validation = Validator::make($input, M_clase_manto::$rules, M_clase_manto::$rulesMessages);

		if ($validation->passes())
		{
			$this->m_clase_manto->create($input);

			return Redirect::route('m_clase_manto.index');
		}

		return Redirect::route('m_clase_manto.create')
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
		$m_clase_manto = $this->m_clase_manto->findOrFail($id);

		return View::make('m_clase_mantos.show', compact('m_clase_manto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$m_clase_manto = $this->m_clase_manto->find($id);

		if (is_null($m_clase_manto))
		{
			return Redirect::route('m_clase_mantos.index');
		}

		return View::make('m_clase_mantos.edit', compact('m_clase_manto'));
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
		$validation = Validator::make($input, M_clase_manto::$rules, M_clase_manto::$rulesMessages);

		if ($validation->passes())
		{
			$m_clase_manto = $this->m_clase_manto->find($id);
			$m_clase_manto->update($input);

			return Redirect::route('m_clase_manto.show', $id);
		}

		return Redirect::route('m_clase_manto.edit', $id)
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
		if ($this->m_clase_manto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->m_clase_manto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
