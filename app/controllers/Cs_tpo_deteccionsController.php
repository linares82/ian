<?php

class Cs_tpo_deteccionsController extends BaseController {

	/**
	 * Cs_tpo_deteccion Repository
	 *
	 * @var Cs_tpo_deteccion
	 */
	protected $cs_tpo_deteccion;

	public function __construct(Cs_tpo_deteccion $cs_tpo_deteccion)
	{
		$this->cs_tpo_deteccion = $cs_tpo_deteccion;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('cs_tpo_deteccions.index');
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

		$count_rows=$this->cs_tpo_deteccion->id($id)->withTrashed()->count();

		$model=$this->cs_tpo_deteccion
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
		return View::make('cs_tpo_deteccions.create');
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
		$validation = Validator::make($input, Cs_tpo_deteccion::$rules, Cs_tpo_deteccion::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_tpo_deteccion->create($input);

			return Redirect::route('cs_tpo_deteccion.index');
		}

		return Redirect::route('cs_tpo_deteccion.create')
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
		$cs_tpo_deteccion = $this->cs_tpo_deteccion->findOrFail($id);

		return View::make('cs_tpo_deteccions.show', compact('cs_tpo_deteccion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_tpo_deteccion = $this->cs_tpo_deteccion->find($id);

		if (is_null($cs_tpo_deteccion))
		{
			return Redirect::route('cs_tpo_deteccions.index');
		}

		return View::make('cs_tpo_deteccions.edit', compact('cs_tpo_deteccion'));
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
		$validation = Validator::make($input, Cs_tpo_deteccion::$rules, Cs_tpo_deteccion::$rulesMessages);

		if ($validation->passes())
		{
			$cs_tpo_deteccion = $this->cs_tpo_deteccion->find($id);
			$cs_tpo_deteccion->update($input);

			return Redirect::route('cs_tpo_deteccion.show', $id);
		}

		return Redirect::route('cs_tpo_deteccion.edit', $id)
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
		if ($this->cs_tpo_deteccion->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_tpo_deteccion->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
