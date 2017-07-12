<?php

class M_objetivosController extends BaseController {

	/**
	 * M_objetivo Repository
	 *
	 * @var M_objetivo
	 */
	protected $m_objetivo;

	public function __construct(M_objetivo $m_objetivo)
	{
		$this->m_objetivo = $m_objetivo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('m_objetivos.index');
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
		$cia=User::find(Sentry::getUser()->id)->getCia();

		$count_rows=$this->m_objetivo->id($id)->cia($cia)->withTrashed()->count();

		$model=$this->m_objetivo
				->select('id', 'objetivo', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->cia($cia)     
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
		return View::make('m_objetivos.create');
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
		$input['cia_id']=User::find(Sentry::getUser()->id)->getCia();
		$validation = Validator::make($input, M_objetivo::$rules, M_objetivo::$rulesMessages);

		if ($validation->passes())
		{
			$this->m_objetivo->create($input);

			return Redirect::route('m_objetivo.index');
		}

		return Redirect::route('m_objetivo.create')
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
		$m_objetivo = $this->m_objetivo->findOrFail($id);

		return View::make('m_objetivos.show', compact('m_objetivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$m_objetivo = $this->m_objetivo->find($id);

		if (is_null($m_objetivo))
		{
			return Redirect::route('m_objetivos.index');
		}

		return View::make('m_objetivos.edit', compact('m_objetivo'));
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
		$input['cia_id']=User::find(Sentry::getUser()->id)->getCia();
		$validation = Validator::make($input, M_objetivo::$rules, M_objetivo::$rulesMessages);

		if ($validation->passes())
		{
			$m_objetivo = $this->m_objetivo->find($id);
			$m_objetivo->update($input);

			return Redirect::route('m_objetivo.show', $id);
		}

		return Redirect::route('m_objetivo.edit', $id)
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
		if ($this->m_objetivo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->m_objetivo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
