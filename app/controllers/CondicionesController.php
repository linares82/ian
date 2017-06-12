<?php

class CondicionesController extends BaseController {

	/**
	 * Condicione Repository
	 *
	 * @var Condicione
	 */
	protected $condicione;

	public function __construct(Condicione $condicione)
	{
		$this->condicione = $condicione;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		return View::make('condiciones.index', compact('impactos_ls'));
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

		$count_rows=$this->condicione->id($id)->withTrashed()->count();

		$model=$this->condicione
				->select('condiciones.id', 'ai.impacto', 'condiciones.condicion', 
					'condiciones.created_at', 'condiciones.updated_at', 'condiciones.deleted_at')
				->join('aa_impactos as ai', 'ai.id', '=', 'condiciones.impacto_id')
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
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		return View::make('condiciones.create', compact('impactos_ls'));
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
		$validation = Validator::make($input, Condicione::$rules, Condicione::$rulesMessages);

		if ($validation->passes())
		{
			$this->condicione->create($input);

			return Redirect::route('condicione.index');
		}

		return Redirect::route('condicione.create')
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
		$condicione = $this->condicione->findOrFail($id);

		return View::make('condiciones.show', compact('condicione'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$condicione = $this->condicione->find($id);

		if (is_null($condicione))
		{
			return Redirect::route('condiciones.index');
		}	
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');

		return View::make('condiciones.edit', compact('condicione', 'impactos_ls'));
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
		$validation = Validator::make($input, Condicione::$rules, Condicione::$rulesMessages);

		if ($validation->passes())
		{
			$condicione = $this->condicione->find($id);
			$condicione->update($input);

			return Redirect::route('condicione.show', $id);
		}

		return Redirect::route('condicione.edit', $id)
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
		if ($this->condicione->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->condicione->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
