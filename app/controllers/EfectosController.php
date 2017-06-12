<?php

class EfectosController extends BaseController {

	/**
	 * Efecto Repository
	 *
	 * @var Efecto
	 */
	protected $efecto;

	public function __construct(Efecto $efecto)
	{
		$this->efecto = $efecto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('efectos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$efecto = isset($_POST['efecto']) ? strval($_POST['efecto']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->efecto->id($id)->Efecto($efecto)->withTrashed()->count();

		$model=$this->efecto
				->select('id', 'efecto', 'descripcion', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Efecto($efecto)
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
		return View::make('efectos.create');
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
		$validation = Validator::make($input, Efecto::$rules, Efecto::$rulesMessages);

		if ($validation->passes())
		{
			$this->efecto->create($input);

			return Redirect::route('efecto.index');
		}

		return Redirect::route('efecto.create')
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
		$efecto = $this->efecto->findOrFail($id);

		return View::make('efectos.show', compact('efecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$efecto = $this->efecto->find($id);

		if (is_null($efecto))
		{
			return Redirect::route('efectos.index');
		}

		return View::make('efectos.edit', compact('efecto'));
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
		$validation = Validator::make($input, Efecto::$rules, Efecto::$rulesMessages);

		if ($validation->passes())
		{
			$efecto = $this->efecto->find($id);
			$efecto->update($input);

			return Redirect::route('efecto.show', $id);
		}

		return Redirect::route('efecto.edit', $id)
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
		if ($this->efecto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->efecto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
