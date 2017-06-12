<?php

class Emision_efectosController extends BaseController {

	/**
	 * Emision_efecto Repository
	 *
	 * @var Emision_efecto
	 */
	protected $emision_efecto;

	public function __construct(Emision_efecto $emision_efecto)
	{
		$this->emision_efecto = $emision_efecto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('emision_efectos.index');
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

		$count_rows=$this->emision_efecto->id($id)->withTrashed()->count();

		$model=$this->emision_efecto
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
		return View::make('emision_efectos.create');
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
		$validation = Validator::make($input, Emision_efecto::$rules, Emision_efecto::$rulesMessages);

		if ($validation->passes())
		{
			$this->emision_efecto->create($input);

			return Redirect::route('emision_efecto.index');
		}

		return Redirect::route('emision_efecto.create')
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
		$emision_efecto = $this->emision_efecto->findOrFail($id);

		return View::make('emision_efectos.show', compact('emision_efecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$emision_efecto = $this->emision_efecto->find($id);

		if (is_null($emision_efecto))
		{
			return Redirect::route('emision_efectos.index');
		}

		return View::make('emision_efectos.edit', compact('emision_efecto'));
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
		$validation = Validator::make($input, Emision_efecto::$rules, Emision_efecto::$rulesMessages);

		if ($validation->passes())
		{
			$emision_efecto = $this->emision_efecto->find($id);
			$emision_efecto->update($input);

			return Redirect::route('emision_efecto.show', $id);
		}

		return Redirect::route('emision_efecto.edit', $id)
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
		if ($this->emision_efecto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->emision_efecto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
