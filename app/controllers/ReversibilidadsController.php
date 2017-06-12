<?php

class ReversibilidadsController extends BaseController {

	/**
	 * Reversibilidad Repository
	 *
	 * @var Reversibilidad
	 */
	protected $reversibilidad;

	public function __construct(Reversibilidad $reversibilidad)
	{
		$this->reversibilidad = $reversibilidad;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('reversibilidads.index');
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

		$count_rows=$this->reversibilidad->id($id)->withTrashed()->count();

		$model=$this->reversibilidad
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
		return View::make('reversibilidads.create');
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
		$validation = Validator::make($input, Reversibilidad::$rules, Reversibilidad::$rulesMessages);

		if ($validation->passes())
		{
			$this->reversibilidad->create($input);

			return Redirect::route('reversibilidad.index');
		}

		return Redirect::route('reversibilidad.create')
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
		$reversibilidad = $this->reversibilidad->findOrFail($id);

		return View::make('reversibilidads.show', compact('reversibilidad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$reversibilidad = $this->reversibilidad->find($id);

		if (is_null($reversibilidad))
		{
			return Redirect::route('reversibilidads.index');
		}

		return View::make('reversibilidads.edit', compact('reversibilidad'));
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
		$validation = Validator::make($input, Reversibilidad::$rules, Reversibilidad::$rulesMessages);

		if ($validation->passes())
		{
			$reversibilidad = $this->reversibilidad->find($id);
			$reversibilidad->update($input);

			return Redirect::route('reversibilidad.show', $id);
		}

		return Redirect::route('reversibilidad.edit', $id)
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
		if ($this->reversibilidad->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->reversibilidad->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
