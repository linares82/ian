<?php

class Bitacora_enfermedadesController extends BaseController {

	/**
	 * Bitacora_enfermedade Repository
	 *
	 * @var Bitacora_enfermedade
	 */
	protected $bitacora_enfermedade;

	public function __construct(Bitacora_enfermedade $bitacora_enfermedade)
	{
		$this->bitacora_enfermedade = $bitacora_enfermedade;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$personas_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$enfermedades_ls=['0' => 'Seleccionar'] + Cs_enfermedade::lists('enfermedad','id');
		$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		return View::make('bitacora_enfermedades.index', compact(['personas_ls', 'enfermedades_ls', 'acciones_ls', 'turnos_ls', 'areas_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->bitacora_enfermedade->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_enfermedade
				->select('bitacora_enfermedades.id', 'e.enfermedad', 'bitacora_enfermedades.fecha', 't.turno', 'a.area',
					'bitacora_enfermedades.created_at', 'bitacora_enfermedades.updated_at', 'bitacora_enfermedades.deleted_at')
				->join('cs_enfermedades as e', 'e.id', '=', 'bitacora_enfermedades.enfermedad_id')
				->join('turnos as t', 't.id', '=', 'bitacora_enfermedades.turno_id')
				->join('areas as a', 'a.id', '=', 'bitacora_enfermedades.area_id')
				->Id($id)->Cia($cia)
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
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$personas_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$enfermedades_ls=['0' => 'Seleccionar'] + Cs_enfermedade::lists('enfermedad','id');
		$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		return View::make('bitacora_enfermedades.create', compact(['personas_ls', 'enfermedades_ls', 'acciones_ls', 'turnos_ls', 'areas_ls']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['anio']=date('Y', strtotime(Input::get('fecha')));;
		$input['mes']=date('m', strtotime(Input::get('fecha')));
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Bitacora_enfermedade::$rules, Bitacora_enfermedade::$rulesMessages);

		if ($validation->passes())
		{
			$this->bitacora_enfermedade->create($input);

			return Redirect::route('bitacora_enfermedade.index');
		}

		return Redirect::route('bitacora_enfermedade.create')
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
		$bitacora_enfermedade = $this->bitacora_enfermedade->findOrFail($id);

		return View::make('bitacora_enfermedades.show', compact('bitacora_enfermedade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_enfermedade = $this->bitacora_enfermedade->find($id);

		if (is_null($bitacora_enfermedade))
		{
			return Redirect::route('bitacora_enfermedades.index');
		}
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$personas_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$enfermedades_ls=['0' => 'Seleccionar'] + Cs_enfermedade::lists('enfermedad','id');
		$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		return View::make('bitacora_enfermedades.edit', compact(['bitacora_enfermedade','personas_ls', 'enfermedades_ls', 'acciones_ls', 'turnos_ls', 'areas_ls']));
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
		$input['anio']=date('Y', strtotime(Input::get('fecha')));;
		$input['mes']=date('m', strtotime(Input::get('fecha')));
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Bitacora_enfermedade::$rules, Bitacora_enfermedade::$rulesMessages);

		if ($validation->passes())
		{
			$bitacora_enfermedade = $this->bitacora_enfermedade->find($id);
			$bitacora_enfermedade->update($input);

			return Redirect::route('bitacora_enfermedade.show', $id);
		}

		return Redirect::route('bitacora_enfermedade.edit', $id)
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
		if ($this->bitacora_enfermedade->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_enfermedade->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
