<?php

class M_imp_realsController extends BaseController {

	/**
	 * M_imp_real Repository
	 *
	 * @var M_imp_real
	 */
	protected $m_imp_real;

	public function __construct(M_imp_real $m_imp_real)
	{
		$this->m_imp_real = $m_imp_real;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('m_imp_reals.index');
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

		$count_rows=$this->m_imp_real->id($id)->count();

		$model=$this->m_imp_real
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
		return View::make('m_imp_reals.create');
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
		$validation = Validator::make($input, M_imp_real::$rules, M_imp_real::$rulesMessages);

		if ($validation->passes())
		{
			$this->m_imp_real->create($input);

			return Redirect::route('m_imp_real.index');
		}

		return Redirect::route('m_imp_real.create')
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
		$m_imp_real = $this->m_imp_real->findOrFail($id);

		return View::make('m_imp_reals.show', compact('m_imp_real'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$m_imp_real = $this->m_imp_real->find($id);

		if (is_null($m_imp_real))
		{
			return Redirect::route('m_imp_reals.index');
		}

		return View::make('m_imp_reals.edit', compact('m_imp_real'));
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
		$validation = Validator::make($input, M_imp_real::$rules, M_imp_real::$rulesMessages);

		if ($validation->passes())
		{
			$m_imp_real = $this->m_imp_real->find($id);
			$m_imp_real->update($input);

			return Redirect::route('m_imp_real.show', $id);
		}

		return Redirect::route('m_imp_real.edit', $id)
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
		if ($this->m_imp_real->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->m_imp_real->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
