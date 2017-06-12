<?php

class Aa_condicionesController extends BaseController {

	/**
	 * Aa_condicione Repository
	 *
	 * @var Aa_condicione
	 */
	protected $aa_condicione;

	public function __construct(Aa_condicione $aa_condicione)
	{
		$this->aa_condicione = $aa_condicione;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('aa_condiciones.index');
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

		$count_rows=$this->aa_condicione->id($id)->count();

		$model=$this->aa_condicione
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
		return View::make('aa_condiciones.create');
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
		$validation = Validator::make($input, Aa_condicione::$rules, Aa_condicione::$rulesMessages);

		if ($validation->passes())
		{
			$this->aa_condicione->create($input);

			return Redirect::route('aa_condicione.index');
		}

		return Redirect::route('aa_condicione.create')
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
		$aa_condicione = $this->aa_condicione->findOrFail($id);

		return View::make('aa_condiciones.show', compact('aa_condicione'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$aa_condicione = $this->aa_condicione->find($id);

		if (is_null($aa_condicione))
		{
			return Redirect::route('aa_condiciones.index');
		}

		return View::make('aa_condiciones.edit', compact('aa_condicione'));
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
		$validation = Validator::make($input, Aa_condicione::$rules, Aa_condicione::$rulesMessages);

		if ($validation->passes())
		{
			$aa_condicione = $this->aa_condicione->find($id);
			$aa_condicione->update($input);

			return Redirect::route('aa_condicione.show', $id);
		}

		return Redirect::route('aa_condicione.edit', $id)
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
		if ($this->aa_condicione->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->aa_condicione->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
