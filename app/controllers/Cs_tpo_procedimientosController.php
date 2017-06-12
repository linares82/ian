<?php

class Cs_tpo_procedimientosController extends BaseController {

	/**
	 * Cs_tpo_procedimiento Repository
	 *
	 * @var Cs_tpo_procedimiento
	 */
	protected $cs_tpo_procedimiento;

	public function __construct(Cs_tpo_procedimiento $cs_tpo_procedimiento)
	{
		$this->cs_tpo_procedimiento = $cs_tpo_procedimiento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('cs_tpo_procedimientos.index');
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

		$count_rows=$this->cs_tpo_procedimiento->id($id)->withTrashed()->count();

		$model=$this->cs_tpo_procedimiento
				->select('id', 'tpo_procedimiento', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('cs_tpo_procedimientos.create');
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
		$validation = Validator::make($input, Cs_tpo_procedimiento::$rules, Cs_tpo_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_tpo_procedimiento->create($input);

			return Redirect::route('cs_tpo_procedimiento.index');
		}

		return Redirect::route('cs_tpo_procedimiento.create')
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
		$cs_tpo_procedimiento = $this->cs_tpo_procedimiento->findOrFail($id);

		return View::make('cs_tpo_procedimientos.show', compact('cs_tpo_procedimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_tpo_procedimiento = $this->cs_tpo_procedimiento->find($id);

		if (is_null($cs_tpo_procedimiento))
		{
			return Redirect::route('cs_tpo_procedimientos.index');
		}

		return View::make('cs_tpo_procedimientos.edit', compact('cs_tpo_procedimiento'));
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
		$validation = Validator::make($input, Cs_tpo_procedimiento::$rules, Cs_tpo_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$cs_tpo_procedimiento = $this->cs_tpo_procedimiento->find($id);
			$cs_tpo_procedimiento->update($input);

			return Redirect::route('cs_tpo_procedimiento.show', $id);
		}

		return Redirect::route('cs_tpo_procedimiento.edit', $id)
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
		if ($this->cs_tpo_procedimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_tpo_procedimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
