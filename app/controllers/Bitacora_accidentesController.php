<?php

class Bitacora_accidentesController extends BaseController {

	/**
	 * Bitacora_accidente Repository
	 *
	 * @var Bitacora_accidente
	 */
	protected $bitacora_accidente;
	protected $bit_doc_accidente;

	public function __construct(Bitacora_accidente $bitacora_accidente, Bit_doc_accidente $bit_doc_accidente)
	{
		$this->bitacora_accidente = $bitacora_accidente;
		$this->bit_doc_accidente = $bit_doc_accidente;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$personas_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$accidentes_ls=['0' => 'Seleccionar'] + Cs_accidente::lists('accidente','id');
		$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		return View::make('bitacora_accidentes.index', compact(['areas_ls', 'responsables_ls', 'personas_ls', 'accidentes_ls', 'acciones_ls', 'turnos_ls']));
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

		$count_rows=$this->bitacora_accidente->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_accidente
				->select('bitacora_accidentes.id', 'ar.area', 'a.accidente', 'bitacora_accidentes.fecha', 't.turno',
					'bitacora_accidentes.created_at', 'bitacora_accidentes.updated_at', 'bitacora_accidentes.deleted_at')
				->join('cs_accidentes as a', 'a.id', '=', 'bitacora_accidentes.accidente_id')
				->join('areas as ar', 'ar.id', '=', 'bitacora_accidentes.area_id')
				->join('turnos as t', 't.id', '=', 'bitacora_accidentes.turno_id')
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
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		//dd($areas_ls);
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$personas_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$accidentes_ls=['0' => 'Seleccionar'] + Cs_accidente::lists('accidente','id');
		$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		return View::make('bitacora_accidentes.create', compact(['areas_ls', 'responsables_ls', 'personas_ls', 'accidentes_ls', 'acciones_ls', 'turnos_ls']));
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
		$validation = Validator::make($input, Bitacora_accidente::$rules, Bitacora_accidente::$rulesMessages);

		if ($validation->passes())
		{
			$this->bitacora_accidente->create($input);

			return Redirect::route('bitacora_accidente.index');
		}

		return Redirect::route('bitacora_accidente.create')
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
		$bitacora_accidente = $this->bitacora_accidente->findOrFail($id);

		return View::make('bitacora_accidentes.show', compact('bitacora_accidente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_accidente = $this->bitacora_accidente->find($id);
		$documentos = DB::table('bit_doc_accidentes')
						->where('bitacora_accidente_id', '=', $id)
						->where('deleted_at', '=', null)
						->get();
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=Sentry::getUser()->id;

		if (is_null($bitacora_accidente))
		{
			return Redirect::route('bitacora_accidentes.index');
		}
		//dd(User::find(Sentry::getUser()->id)->getCia());
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		//dd($areas_ls);
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$personas_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$accidentes_ls=['0' => 'Seleccionar'] + Cs_accidente::lists('accidente','id');
		$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
		$turnos_ls=['0' => 'Seleccionar'] + Turno::lists('turno','id');
		return View::make('bitacora_accidentes.edit', compact(['bitacora_accidente','areas_ls', 'responsables_ls', 'personas_ls', 'accidentes_ls', 'acciones_ls', 'turnos_ls', 'documentos','cia', 'usuario']));
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
		
		if(Input::hasFile('file1')){
			$documento['archivo']=Input::file('file1')->getClientOriginalName();	
			$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
			$usuario=Sentry::getUser()->id;
			Input::file('file1')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/bit_doc_accidentes', Input::file('file1')->getClientOriginalName());
			//dd(Input::file('file1'));
			$documento['usu_mod_id']=$usuario;
			$documento['usu_alta_id']=$usuario;
			$documento['bitacora_accidente_id']=$id;
			$documento['documento']=$input['documento'];
			//dd($documento);
			$this->bit_doc_accidente->create($documento);
		}
		
		unset($input['file1']);
		unset($input['documento']);
		
		$validation = Validator::make($input, Bitacora_accidente::$rules, Bitacora_accidente::$rulesMessages);

		if ($validation->passes())
		{
			$bitacora_accidente = $this->bitacora_accidente->find($id);
			$bitacora_accidente->update($input);

			return Redirect::route('bitacora_accidente.show', $id);
		}

		return Redirect::route('bitacora_accidente.edit', $id)
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
		if ($this->bitacora_accidente->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_accidente->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
