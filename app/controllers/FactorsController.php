<?php

class FactorsController extends BaseController {

	/**
	 * Factor Repository
	 *
	 * @var Factor
	 */
	protected $factor;

	public function __construct(Factor $factor)
	{
		$this->factor = $factor;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('factors.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$factor = isset($_POST['factor']) ? strval($_POST['factor']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->factor->id($id)->Factor($factor)->withTrashed()->count();

		$model=$this->factor
				->select('id', 'factor', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Factor($factor)
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
		return View::make('factors.create');
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
		$validation = Validator::make($input, Factor::$rules, Factor::$rulesMessages);

		if ($validation->passes())
		{
			$this->factor->create($input);

			return Redirect::route('factor.index');
		}

		return Redirect::route('factor.create')
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
		$factor = $this->factor->findOrFail($id);

		return View::make('factors.show', compact('factor'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$factor = $this->factor->find($id);

		if (is_null($factor))
		{
			return Redirect::route('factors.index');
		}

		return View::make('factors.edit', compact('factor'));
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
		$validation = Validator::make($input, Factor::$rules, Factor::$rulesMessages);

		if ($validation->passes())
		{
			$factor = $this->factor->find($id);
			$factor->update($input);

			return Redirect::route('factor.show', $id);
		}

		return Redirect::route('factor.edit', $id)
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
		if ($this->factor->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->factor->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
