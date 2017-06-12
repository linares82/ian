<?php

class Bitacora_ffsController extends BaseController {

	/**
	 * Bitacora_ff Repository
	 *
	 * @var Bitacora_ff
	 */
	protected $bitacora_ff;

	public function __construct(Bitacora_ff $bitacora_ff)
	{
		$this->bitacora_ff = $bitacora_ff;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fuentes_fijas_ls=['0' => 'Seleccionar'] + Ca_fuentes_fija::lists('planta','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('bitacora_ffs.index', array('fuentes_fijas_ls'=>$fuentes_fijas_ls, 'turnos_ls'=>$turnos_ls, 'responsables_ls'=>$responsables_ls));
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

		$count_rows=$this->bitacora_ff->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_ff
				->select('bitacora_ffs.id', 'ff.planta', 't.turno', 'bitacora_ffs.fecha', 
					DB::raw('datediff(CURDATE(), bitacora_ffs.fecha) as ultima_captura'), 
					'bitacora_ffs.created_at', 'bitacora_ffs.updated_at', 'bitacora_ffs.deleted_at')
				->join('ca_fuentes_fijas as ff', 'ff.id', '=', 'bitacora_ffs.ca_fuente_fija_id')
				->join('turnos as t', 't.id', '=', 'bitacora_ffs.turno_id')
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
		$fuentes_fijas_ls=['0' => 'Seleccionar'] + Ca_fuentes_fija::lists('planta','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('bitacora_ffs.create', array('fuentes_fijas_ls'=>$fuentes_fijas_ls, 'turnos_ls'=>$turnos_ls, 'responsables_ls'=>$responsables_ls));
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
		$validation = Validator::make($input, Bitacora_ff::$rules, Bitacora_ff::$rulesMessages);

		if ($validation->passes())
		{
			$this->bitacora_ff->create($input);

			return Redirect::route('bitacora_ff.index');
		}

		return Redirect::route('bitacora_ff.create')
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
		$bitacora_ff = $this->bitacora_ff->findOrFail($id);

		return View::make('bitacora_ffs.show', compact('bitacora_ff'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_ff = $this->bitacora_ff->find($id);

		if (is_null($bitacora_ff))
		{
			return Redirect::route('bitacora_ffs.index');
		}
		$fuentes_fijas_ls=['0' => 'Seleccionar'] + Ca_fuentes_fija::lists('planta','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('bitacora_ffs.edit', array('bitacora_ff'=>$bitacora_ff, 'fuentes_fijas_ls'=>$fuentes_fijas_ls, 'turnos_ls'=>$turnos_ls, 'responsables_ls'=>$responsables_ls));
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
		$validation = Validator::make($input, Bitacora_ff::$rules, Bitacora_ff::$rulesMessages);

		if ($validation->passes())
		{
			$bitacora_ff = $this->bitacora_ff->find($id);
			$bitacora_ff->update($input);

			return Redirect::route('bitacora_ff.show', $id);
		}

		return Redirect::route('bitacora_ff.edit', $id)
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
		if ($this->bitacora_ff->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_ff->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
