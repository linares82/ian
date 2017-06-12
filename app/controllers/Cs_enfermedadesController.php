<?php

class Cs_enfermedadesController extends BaseController {

	/**
	 * Cs_enfermedade Repository
	 *
	 * @var Cs_enfermedade
	 */
	protected $cs_enfermedade;

	public function __construct(Cs_enfermedade $cs_enfermedade)
	{
		$this->cs_enfermedade = $cs_enfermedade;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('cs_enfermedades.index');
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

		$count_rows=$this->cs_enfermedade->id($id)->withTrashed()->count();

		$model=$this->cs_enfermedade
				->select('id', 'enfermedad', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('cs_enfermedades.create');
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
		$validation = Validator::make($input, Cs_enfermedade::$rules, Cs_enfermedade::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_enfermedade->create($input);

			return Redirect::route('cs_enfermedade.index');
		}

		return Redirect::route('cs_enfermedade.create')
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
		$cs_enfermedade = $this->cs_enfermedade->findOrFail($id);

		return View::make('cs_enfermedades.show', compact('cs_enfermedade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_enfermedade = $this->cs_enfermedade->find($id);

		if (is_null($cs_enfermedade))
		{
			return Redirect::route('cs_enfermedades.index');
		}

		return View::make('cs_enfermedades.edit', compact('cs_enfermedade'));
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
		$validation = Validator::make($input, Cs_enfermedade::$rules, Cs_enfermedade::$rulesMessages);

		if ($validation->passes())
		{
			$cs_enfermedade = $this->cs_enfermedade->find($id);
			$cs_enfermedade->update($input);

			return Redirect::route('cs_enfermedade.show', $id);
		}

		return Redirect::route('cs_enfermedade.edit', $id)
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
		if ($this->cs_enfermedade->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_enfermedade->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
