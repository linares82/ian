<?php

class CumplimientosController extends BaseController {

	/**
	 * Cumplimiento Repository
	 *
	 * @var Cumplimiento
	 */
	protected $cumplimiento;

	public function __construct(Cumplimiento $cumplimiento)
	{
		$this->cumplimiento = $cumplimiento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('cumplimientos.index');
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

		$count_rows=$this->cumplimiento->id($id)->withTrashed()->count();

		$model=$this->cumplimiento
				->select('id', 'cumplimiento', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('cumplimientos.create');
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
		$validation = Validator::make($input, Cumplimiento::$rules, Cumplimiento::$rulesMessages);

		if ($validation->passes())
		{
			$this->cumplimiento->create($input);

			return Redirect::route('cumplimiento.index');
		}

		return Redirect::route('cumplimiento.create')
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
		$cumplimiento = $this->cumplimiento->findOrFail($id);

		return View::make('cumplimientos.show', compact('cumplimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cumplimiento = $this->cumplimiento->find($id);

		if (is_null($cumplimiento))
		{
			return Redirect::route('cumplimientos.index');
		}

		return View::make('cumplimientos.edit', compact('cumplimiento'));
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
		$validation = Validator::make($input, Cumplimiento::$rules, Cumplimiento::$rulesMessages);

		if ($validation->passes())
		{
			$cumplimiento = $this->cumplimiento->find($id);
			$cumplimiento->update($input);

			return Redirect::route('cumplimiento.show', $id);
		}

		return Redirect::route('cumplimiento.edit', $id)
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
		if ($this->cumplimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cumplimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
