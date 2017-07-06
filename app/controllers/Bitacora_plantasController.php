<?php

class Bitacora_plantasController extends BaseController {

	/**
	 * Bitacora_planta Repository
	 *
	 * @var Bitacora_planta
	 */
	protected $bitacora_planta;

	public function __construct(Bitacora_planta $bitacora_planta)
	{
		$this->bitacora_planta = $bitacora_planta;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$plantas_ls=['0' => 'Seleccionar'] + Ca_planta::lists('planta','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('bitacora_plantas.index', array('plantas_ls'=>$plantas_ls, 'turnos_ls'=>$turnos_ls, 'responsables_ls'=>$responsables_ls));
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

		$count_rows=$this->bitacora_planta->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_planta
				->select('bitacora_plantas.id', 'p.planta', 'bitacora_plantas.fecha', 't.turno',
					DB::raw('datediff(CURDATE(), bitacora_plantas.fecha) as ultima_captura'),  
					'bitacora_plantas.created_at', 'bitacora_plantas.updated_at', 'bitacora_plantas.deleted_at')
				->join('ca_plantas as p', 'p.id', '=', 'bitacora_plantas.planta_id')
				->join('turnos as t', 't.id', '=', 'bitacora_plantas.turno_id')
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
		$plantas_ls=['0' => 'Seleccionar'] + Ca_planta::lists('planta','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('bitacora_plantas.create', array('plantas_ls'=>$plantas_ls, 'turnos_ls'=>$turnos_ls, 'responsables_ls'=>$responsables_ls));
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
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, Bitacora_planta::$rules, Bitacora_planta::$rulesMessages);

		if ($validation->passes())
		{
			$this->bitacora_planta->create($input);

			return Redirect::route('bitacora_planta.index');
		}

		return Redirect::route('bitacora_planta.create')
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
		$bitacora_planta = $this->bitacora_planta->findOrFail($id);

		return View::make('bitacora_plantas.show', compact('bitacora_planta'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_planta = $this->bitacora_planta->find($id);

		if (is_null($bitacora_planta))
		{
			return Redirect::route('bitacora_plantas.index');
		}
		$plantas_ls=['0' => 'Seleccionar'] + Ca_planta::lists('planta','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('bitacora_plantas.edit', array('bitacora_planta'=>$bitacora_planta, 'plantas_ls'=>$plantas_ls, 'turnos_ls'=>$turnos_ls, 'responsables_ls'=>$responsables_ls));
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
		$validation = Validator::make($input, Bitacora_planta::$rules, Bitacora_planta::$rulesMessages);

		if ($validation->passes())
		{
			$bitacora_planta = $this->bitacora_planta->find($id);
			$bitacora_planta->update($input);

			return Redirect::route('bitacora_planta.show', $id);
		}

		return Redirect::route('bitacora_planta.edit', $id)
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
		if ($this->bitacora_planta->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_planta->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
