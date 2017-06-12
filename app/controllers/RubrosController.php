<?php

class RubrosController extends BaseController {

	/**
	 * Rubro Repository
	 *
	 * @var Rubro
	 */
	protected $rubro;

	public function __construct(Rubro $rubro)
	{
		$this->rubro = $rubro;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('rubros.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$rubro = isset($_POST['rubro']) ? intval($_POST['rubro']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->rubro->id($id)->Rubro($rubro)->withTrashed()->count();

		$model=$this->rubro
				->select('id', 'rubro', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Rubro($rubro)
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
		return View::make('rubros.create');
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
		$validation = Validator::make($input, Rubro::$rules, Rubro::$rulesMessages);

		if ($validation->passes())
		{
			$this->rubro->create($input);

			return Redirect::route('rubro.index');
		}

		return Redirect::route('rubro.create')
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
		$rubro = $this->rubro->findOrFail($id);

		return View::make('rubros.show', compact('rubro'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rubro = $this->rubro->find($id);

		if (is_null($rubro))
		{
			return Redirect::route('rubros.index');
		}

		return View::make('rubros.edit', compact('rubro'));
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
		$validation = Validator::make($input, Rubro::$rules, Rubro::$rulesMessages);

		if ($validation->passes())
		{
			$rubro = $this->rubro->find($id);
			$rubro->update($input);

			return Redirect::route('rubro.show', $id);
		}

		return Redirect::route('rubro.edit', $id)
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
		if ($this->rubro->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->rubro->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
