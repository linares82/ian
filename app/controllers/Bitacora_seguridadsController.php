<?php

class Bitacora_seguridadsController extends BaseController {

	/**
	 * Bitacora_seguridad Repository
	 *
	 * @var Bitacora_seguridad
	 */
	protected $bitacora_seguridad;

	public function __construct(Bitacora_seguridad $bitacora_seguridad)
	{
		$this->bitacora_seguridad = $bitacora_seguridad;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Cs_tpo_bitacora::lists('tpo_bitacora','id');
		$tpo_inconformidades_ls=['0' => 'Seleccionar'] + Cs_tpo_inconformidade::lists('tpo_inconformidad','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		$estatus_ls=['0' => 'Seleccionar'] + A_st_nc::lists('estatus','id');
		return View::make('bitacora_seguridads.index', compact(['tpo_detecciones_ls', 'areas_ls', 'tpo_bitacoras_ls', 'tpo_inconformidades_ls', 'responsables_ls', 'grupos_ls', 'normas_ls', 'estatus_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$area = isset($_POST['area']) ? intval($_POST['area']) : 0;
		$tpo_deteccion = isset($_POST['tpo_deteccion']) ? intval($_POST['tpo_deteccion']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->bitacora_seguridad
				->id($id)->Cia($cia)->Area($area)->TpoDeteccion($tpo_deteccion)->Estatus($estatus)
				->withTrashed()->count();

		$model=$this->bitacora_seguridad
				->select('bitacora_seguridads.id','bitacora_seguridads.fecha', 'a.area', 'd.tpo_deteccion','bitacora_seguridads.inconformidad','st.estatus', 
					DB::raw('datediff(bitacora_seguridads.fec_planeada, CURDATE()) as dias_restantes'), 'bitacora_seguridads.fec_planeada',
					'bitacora_seguridads.created_at', 'bitacora_seguridads.updated_at', 'bitacora_seguridads.deleted_at')
				->join("areas as a", 'a.id', '=', 'bitacora_seguridads.area_id')
				->join('s_st_bs as st', 'st.id', '=', 'bitacora_seguridads.estatus_id')
				->join('cs_tpo_deteccions as d', 'd.id', '=', 'bitacora_seguridads.tpo_deteccion_id')
				->Id($id)->Cia($cia)->Area($area)->TpoDeteccion($tpo_deteccion)->Estatus($estatus)
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
		$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Cs_tpo_bitacora::lists('tpo_bitacora','id');
		$tpo_inconformidades_ls=['0' => 'Seleccionar'] + Cs_tpo_inconformidade::lists('tpo_inconformidad','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		return View::make('bitacora_seguridads.create', compact(['tpo_detecciones_ls', 'areas_ls', 'tpo_bitacoras_ls', 'tpo_inconformidades_ls', 'responsables_ls', 'grupos_ls', 'normas_ls']));
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
		$input['estatus_id']=1;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, Bitacora_seguridad::$rules, Bitacora_seguridad::$rulesMessages);

		if ($validation->passes())
		{
			$this->bitacora_seguridad->create($input);

			return Redirect::route('bitacora_seguridad.index');
		}

		return Redirect::route('bitacora_seguridad.create')
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
		$bitacora_seguridad = $this->bitacora_seguridad->findOrFail($id);

		return View::make('bitacora_seguridads.show', compact('bitacora_seguridad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_seguridad = $this->bitacora_seguridad->find($id);

		if (is_null($bitacora_seguridad))
		{
			return Redirect::route('bitacora_seguridads.index');
		}

		$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Cs_tpo_bitacora::lists('tpo_bitacora','id');
		$tpo_inconformidades_ls=['0' => 'Seleccionar'] + Cs_tpo_inconformidade::lists('tpo_inconformidad','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');

		return View::make('bitacora_seguridads.edit', compact(['bitacora_seguridad','tpo_detecciones_ls', 'areas_ls', 'tpo_bitacoras_ls', 'tpo_inconformidades_ls', 'responsables_ls', 'grupos_ls', 'normas_ls']));
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
		$validation = Validator::make($input, Bitacora_seguridad::$rules, Bitacora_seguridad::$rulesMessages);

		if ($validation->passes())
		{
			$bitacora_seguridad = $this->bitacora_seguridad->find($id);
			$bitacora_seguridad->update($input);

			return Redirect::route('bitacora_seguridad.show', $id);
		}

		return Redirect::route('bitacora_seguridad.edit', $id)
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
		if ($this->bitacora_seguridad->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_seguridad->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbNormas(){
		if(Request::ajax()){
			$grupo = e(Input::get('grupo_id'));
			$norma = e(Input::get('norma_id'));
			$final = array();
			$r = DB::table('cs_normas as n')
					->select('n.id', 'n.norma')
					->Join('cs_grupo_normas as gn', 'gn.id', '=', 'n.grupo_norma_id')
					->where('n.grupo_norma_id', '=', $grupo)
					->distinct()->get();
			if(isset($norma) and $norma<>0){
				foreach($r as $r1){
					if($r1->id==$norma){
						array_push($final, array('id'=>$r1->id, 
												 'norma'=>$r1->norma, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'norma'=>$r1->norma, 
												 'selectec'=>''));
					}
				}
				return $final;
			}else{
				return $r;	
			}
			
		}
	}

	public function cmbTpoInconformidades(){
		if(Request::ajax()){
			$tpo_bitacora = e(Input::get('tpo_bitacora_id'));
			$tpo_inconformidad = e(Input::get('tpo_inconformidad_id'));
			$final = array();
			$r = DB::table('cs_tpo_inconformidades as c')
					->select('c.id', 'c.tpo_inconformidad')
					->Join('cs_tpo_bitacoras as b', 'b.id', '=', 'c.tpo_bitacora_id')
					->where('c.tpo_bitacora_id', '=', $tpo_bitacora)
					->distinct()->get();
			if(isset($tpo_inconformidad) and $tpo_inconformidad<>0){
				foreach($r as $r1){
					if($r1->id==$tpo_inconformidad){
						array_push($final, array('id'=>$r1->id, 
												 'tpo_inconformidad'=>$r1->tpo_inconformidad, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'tpo_inconformidad'=>$r1->tpo_inconformidad, 
												 'selectec'=>''));
					}
				}
				return $final;
			}else{
				return $r;	
			}
			
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['bitacora_seguridad_id']=$_POST['bitacora_seguridad_id'];
		$c['comentario']=$_POST['comentario'];
		$c['costo']=$_POST['costo'];
		$c['estatus_id']=$_POST['estatus_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new Comentarios_b($c);
		$a_no_conformidade=Bitacora_seguridad::findOrFail($c['bitacora_seguridad_id']);
		$a_no_conformidade->comentarios()->save($comentario);
		$a_no_conformidade->estatus_id=$c['estatus_id'];
		$a_no_conformidade->costo=$c['costo'];
		$a_no_conformidade->save();
		echo json_encode(array('success'=>true));
		}
		catch(\Exception $e){
			DB::rollback();
    		//throw $e;
    		echo json_encode(array('msg'=>$e));
		}
		DB::commit();
		
	}

}
