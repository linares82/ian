<?php

class M_mantenimientosController extends BaseController {

	/**
	 * M_mantenimiento Repository
	 *
	 * @var M_mantenimiento
	 */
	protected $m_mantenimiento;
	protected $manto_doc;

	public function __construct(M_mantenimiento $m_mantenimiento, Manto_doc $manto_doc)
	{
		$this->m_mantenimiento = $m_mantenimiento;
		$this->manto_doc = $manto_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$objetivos_ls=['0' => 'Seleccionar'] + M_objetivo::lists('objetivo','id');
		$estatus_ls=['0' => 'Seleccionar'] + M_estatus::lists('estatus','id');
		$tpo_mantos_ls=['0' => 'Seleccionar'] + M_tpo_manto::lists('tpo_manto','id');
		$clase_mantos_ls=['0' => 'Seleccionar'] + M_clase_manto::lists('clase_manto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('m_mantenimientos.index', 
				 compact(['objetivos_ls', 'estatus_ls', 'clase_mantos_ls', 'tpo_mantos_ls',
				 		  'areas_ls', 'responsables_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$equipo = isset($_POST['equipo']) ? intval($_POST['equipo']) : 0;
		$subequipo = isset($_POST['subequipo']) ? intval($_POST['subequipo']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		//dd($$this->m_mantenimiento)->Equipo($equipo)->get();
		
		$count_rows=$this->m_mantenimiento->Cia($cia)->id($id);
		if ($equipo==0){
    		$count_rows=$count_rows;
    	}else{
    		$count_rows=$count_rows->where('m_mantenimientos.objetivo_id', '=', $equipo);
    	}
		if ($subequipo==0){
    		$count_rows=$count_rows;
    	}else{
    		$count_rows=$count_rows->where('m_mantenimientos.subequipo_id', '=', $subequipo);
    	}
		$count_rows=$count_rows->withTrashed()->count();

		$model=$this->m_mantenimiento
				->select('m_mantenimientos.id', 'om.objetivo', 's.subequipo', 'em.estatus', 'm_mantenimientos.descripcion',
						 'm_mantenimientos.created_at', 'm_mantenimientos.updated_at', 'm_mantenimientos.deleted_at')
				->join('m_objetivos as om', 'om.id', '=', 'm_mantenimientos.objetivo_id')
				->join('m_estatuses as em', 'em.id', '=', 'm_mantenimientos.estatus_id')
				->join('subequipos as s', 's.id', '=', 'm_mantenimientos.subequipo_id')
				->Id($id)->Cia($cia)->isObjetivo($equipo)->isSubequipo($subequipo)
				->orderBy('id','desc')
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
		$objetivos_ls=['0' => 'Seleccionar'] + M_objetivo::lists('objetivo','id');
		$subequipos_ls=['0' => 'Seleccionar'] + Subequipo::lists('subequipo','id');
		$estatus_ls=['0' => 'Seleccionar'] + M_estatus::lists('estatus','id');
		$aviso_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$tpp_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$supervision_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$conoce_procedimiento_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$lleva_equipo_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$cumple_puntos_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$eventualidades_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$levantar_formato_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$registro_bitacora_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		
		$tpo_mantos_ls=['0' => 'Seleccionar'] + M_tpo_manto::lists('tpo_manto','id');
		$clase_mantos_ls=['0' => 'Seleccionar'] + M_clase_manto::lists('clase_manto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$solicitantes_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$ejecutores_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('m_mantenimientos.create', 
				 compact(['objetivos_ls','subequipos_ls', 'estatus_ls', 'aviso_bnd_ls','tpp_bnd_ls',
						'clase_mantos_ls', 'tpo_mantos_ls',
				 		'areas_ls', 'responsables_ls', 'solicitantes_ls', 'ejecutores_ls', 'supervision_bnd_ls',
						'conoce_procedimiento_bnd_ls','lleva_equipo_bnd_ls','cumple_puntos_bnd_ls',
						'eventualidades_bnd_ls','levantar_formato_bnd_ls','registro_bitacora_bnd_ls']));
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
		$validation = Validator::make($input, M_mantenimiento::$rules, M_mantenimiento::$rulesMessages);

		if ($validation->passes())
		{
			$input['fec_inicio']=Carbon\Carbon::parse($input['fec_inicio'])->format('Y/m/d H:i:s');
			$input['fec_final']=Carbon\Carbon::parse($input['fec_final'])->format('Y/m/d H:i:s');
			//dd($input['fec_inicio']);
			
			$r=$this->m_mantenimiento->create($input);
			$input['codigo']=Hash::make($r->id); 
			unset($input['_token']);
			//dd($r->id);
			$ru=$this->m_mantenimiento->find($r->id);
			$ru->update($input);

			return Redirect::route('m_mantenimiento.index');
		}

		return Redirect::route('m_mantenimiento.create')
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
		$m_mantenimiento = $this->m_mantenimiento->findOrFail($id);

		return View::make('m_mantenimientos.show', compact('m_mantenimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$m_mantenimiento = $this->m_mantenimiento->find($id);
		$documentos = DB::table('Manto_docs')
						->where('mantenimiento_id', '=', $id)
						->where('deleted_at', '=', null)
						->get();
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=Sentry::getUser()->id;
		//dd($documentos);
		
		if (is_null($m_mantenimiento))
		{
			return Redirect::route('m_mantenimiento.index');
		}

		$objetivos_ls=['0' => 'Seleccionar'] + M_objetivo::lists('objetivo','id');
		$subequipos_ls=['0' => 'Seleccionar'] + Subequipo::lists('subequipo','id');
		$estatus_ls=['0' => 'Seleccionar'] + M_estatus::lists('estatus','id');
		$aviso_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$tpp_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$supervision_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$conoce_procedimiento_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$lleva_equipo_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$cumple_puntos_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$eventualidades_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$levantar_formato_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		$registro_bitacora_bnd_ls=['0' => 'Seleccionar'] + Bnd::lists('bnd','id');
		
		$tpo_mantos_ls=['0' => 'Seleccionar'] + M_tpo_manto::lists('tpo_manto','id');
		$clase_mantos_ls=['0' => 'Seleccionar'] + M_clase_manto::lists('clase_manto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$solicitantes_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$ejecutores_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('m_mantenimientos.edit', 
				 compact(['m_mantenimiento','objetivos_ls','subequipos_ls', 'estatus_ls', 'aviso_bnd_ls','tpp_bnd_ls',
						'clase_mantos_ls', 'tpo_mantos_ls',
				 		'areas_ls', 'responsables_ls', 'solicitantes_ls', 'ejecutores_ls', 'supervision_bnd_ls',
						'conoce_procedimiento_bnd_ls','lleva_equipo_bnd_ls','cumple_puntos_bnd_ls',
						'eventualidades_bnd_ls','levantar_formato_bnd_ls','registro_bitacora_bnd_ls',
						'documentos', 'cia', 'usuario']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$input['codigo']=Hash::make($id);
		$documento=array();
		//dd(Input::all());
		//dd(Input::file('file1'));
		if(Input::hasFile('file1')){
			$documento['archivo']=Input::file('file1')->getClientOriginalName();	
			$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
			$usuario=Sentry::getUser()->id;
			Input::file('file1')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/manto_doc', Input::file('file1')->getClientOriginalName());
			
			$documento['usu_mod_id']=$usuario;
			$documento['usu_alta_id']=$usuario;
			$documento['mantenimiento_id']=$id;
			$documento['documento']=$input['documento'];
			//dd($documento);
			$this->manto_doc->create($documento);
		}
		
		unset($input['file1']);
		unset($input['documento']);
		
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['fec_inicio']=Carbon\Carbon::parse($input['fec_inicio'])->format('Y/m/d H:i:s');
		$input['fec_final']=Carbon\Carbon::parse($input['fec_final'])->format('Y/m/d H:i:s');
		
		//dd($documento);
		$validation = Validator::make($input, M_mantenimiento::$rules, M_mantenimiento::$rulesMessages);

		if ($validation->passes())
		{
			$m_mantenimiento = $this->m_mantenimiento->find($id);
			$m_mantenimiento->update($input);
			
			return Redirect::route('m_mantenimiento.index');
		}

		return Redirect::route('m_mantenimiento.edit', $id)
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
		if ($this->m_mantenimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->m_mantenimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}
	
	public function conSubequipo(){
		if(Request::ajax()){
			$id = e(Input::get('id'));
			return DB::table('subequipos as s')
					->join('areas as a', 'a.id', '=', 's.area_id')
					->select('s.subequipo','s.clase','s.marca','s.modelo','s.no_serie','s.fecha_carga','a.area','s.ubicacion')
					->where('s.id', '=', $id)
					->distinct()->get();
		}
	}
	
	public function rptFormato($id){
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		//$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		$m = $this->m_mantenimiento->find($id);
		$no_orden=$m->no_orden;
		
		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/mantenimiento.pdf')){
			unlink($carpeta . '/mantenimiento.pdf');
		}

		//dd($carpeta . '/mantenimiento');
		
		JasperPHP::process(
	    base_path() . '/public/reportes/reportes/mantenimiento.jasper', 
	    $carpeta . '/mantenimiento',
	    array("pdf"), 
	    array('id'=>$id,
	    	  //'ruta_img'=>base_path().'/public/uploads/cias/'.$img),
			  'codigo'=> Hash::make($no_orden)),
	    Config::get('database.connections.mysql') //DB connection array
	    )->execute();
		
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/mantenimiento.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/mantenimiento.pdf');	    
	}

}
