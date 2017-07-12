<?php

class SubequiposController extends BaseController {

	/**
	 * Subequipo Repository
	 *
	 * @var Subequipo
	 */
	protected $subequipo;

	public function __construct(Subequipo $subequipo)
	{
		$this->subequipo = $subequipo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('subequipos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$objetivo = isset($_POST['equipobox']) ? intval($_POST['equipobox']) : 0;
		$subequipo = isset($_POST['subequipobox']) ? intval($_POST['subequipobox']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();
		$cia=User::find(Sentry::getUser()->id)->getCia();

		$count_rows=$this->subequipo->id($id,$objetivo,$subequipo)->cia($id)->count();

		$model=$this->subequipo
				->select('subequipos.id','e.objetivo', 'subequipo', 'clase', 'marca', 'modelo', 'no_serie', 'subequipos.created_at', 'subequipos.updated_at', 'subequipos.deleted_at')
				->Join('m_objetivos as e', 'e.id', '=', 'subequipos.equipo_id')
				->Id($id,$objetivo,$subequipo)->cia($id)   
				->skip($offset)->take($rows)->orderBy('subequipos.'.$sort, $order)->withTrashed()->get();	
		
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
		$equipos_ls=['0' => 'Seleccionar'] + M_objetivo::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('objetivo','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		return View::make('subequipos.create', compact(['equipos_ls', 'areas_ls']));
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
		$input['cia_id']=User::find(Sentry::getUser()->id)->getCia();
		$validation = Validator::make($input, Subequipo::$rules, Subequipo::$rulesMessages);

		if ($validation->passes())
		{
			$this->subequipo->create($input);

			return Redirect::route('subequipo.index');
		}

		return Redirect::route('subequipo.create')
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
		$subequipo = $this->subequipo->findOrFail($id);

		return View::make('subequipos.show', compact('subequipo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$subequipo = $this->subequipo->find($id);

		if (is_null($subequipo))
		{
			return Redirect::route('subequipos.index');
		}
		
		$equipos_ls=['0' => 'Seleccionar'] + M_objetivo::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('objetivo','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');

		return View::make('subequipos.edit', compact('subequipo', 'equipos_ls', 'areas_ls'));
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
		$input['cia_id']=User::find(Sentry::getUser()->id)->getCia();
		$validation = Validator::make($input, Subequipo::$rules, Subequipo::$rulesMessages);

		if ($validation->passes())
		{
			$subequipo = $this->subequipo->find($id);
			$subequipo->update($input);

			return Redirect::route('subequipo.show', $id);
		}

		return Redirect::route('subequipo.edit', $id)
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
		if ($this->subequipo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->subequipo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
