<?php

class A_no_conformidadesController extends BaseController {

	/**
	 * A_no_conformidade Repository
	 *
	 * @var A_no_conformidade
	 */
	protected $a_no_conformidade;

	public function __construct(A_no_conformidade $a_no_conformidade)
	{
		$this->a_no_conformidade = $a_no_conformidade;
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
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_bitacoras')->lists('tpo_bitacora','id');
		$tpo_inconformidades_ls=['0' => 'Seleccionar'] + Ca_tpo_noconformidade::lists('tpo_inconformidad','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$estatus_ls=['0' => 'Seleccionar'] + A_st_nc::lists('estatus','id');
		return View::make('a_no_conformidades.index', compact(['tpo_detecciones_ls', 'areas_ls', 'tpo_bitacoras_ls', 'tpo_inconformidades_ls', 'responsables_ls', 'estatus_ls']));
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

		$count_rows=$this->a_no_conformidade
				->id($id)->Cia($cia)->Area($area)->TpoDeteccion($tpo_deteccion)->Estatus($estatus)
				->withTrashed()->count();

		$model=$this->a_no_conformidade
				->select('a_no_conformidades.id','a_no_conformidades.fecha', 'a.area', 'd.tpo_deteccion','a_no_conformidades.no_conformidad','st.estatus', 
					DB::raw('datediff(a_no_conformidades.fec_planeada, CURDATE()) as dias_restantes'), 'a_no_conformidades.fec_planeada',
					'a_no_conformidades.created_at', 'a_no_conformidades.updated_at', 'a_no_conformidades.deleted_at')
				->join("areas as a", 'a.id', '=', 'a_no_conformidades.area_id')
				->join('a_st_ncs as st', 'st.id', '=', 'a_no_conformidades.estatus_id')
				->join('cs_tpo_deteccions as d', 'd.id', '=', 'a_no_conformidades.tpo_deteccion_id')
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
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_bitacoras')->lists('tpo_bitacora','id');
		//dd($tpo_bitacoras_ls);
		$tpo_inconformidades_ls=['0' => 'Seleccionar'] + Ca_tpo_noconformidade::lists('tpo_inconformidad','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_no_conformidades.create', compact(['tpo_detecciones_ls', 'areas_ls', 'tpo_bitacoras_ls', 'tpo_inconformidades_ls', 'responsables_ls']));
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
		$validation = Validator::make($input, A_no_conformidade::$rules, A_no_conformidade::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_no_conformidade->create($input);

			return Redirect::route('a_no_conformidade.index');
		}

		return Redirect::route('a_no_conformidade.create')
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
		$a_no_conformidade = $this->a_no_conformidade->findOrFail($id);

		return View::make('a_no_conformidades.show', compact('a_no_conformidade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_no_conformidade = $this->a_no_conformidade->find($id);

		if (is_null($a_no_conformidade))
		{
			return Redirect::route('a_no_conformidades.index');
		}

		$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_bitacoras')->lists('tpo_bitacora','id');
		$tpo_inconformidades_ls=['0' => 'Seleccionar'] + Ca_tpo_noconformidade::lists('tpo_inconformidad','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');

		return View::make('a_no_conformidades.edit', compact(['a_no_conformidade', 'tpo_detecciones_ls', 'areas_ls', 'tpo_bitacoras_ls', 'tpo_inconformidades_ls', 'responsables_ls']));
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
		$validation = Validator::make($input, A_no_conformidade::$rules, A_no_conformidade::$rulesMessages);

		if ($validation->passes())
		{
			$a_no_conformidade = $this->a_no_conformidade->find($id);
			$a_no_conformidade->update($input);

			return Redirect::route('a_no_conformidade.show', $id);
		}

		return Redirect::route('a_no_conformidade.edit', $id)
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
		if ($this->a_no_conformidade->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_no_conformidade->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbInconformidades(){
		if(Request::ajax()){
			$tpo_bitacora = e(Input::get('tpo_bitacora_id'));
			$tpo_inconformidad = e(Input::get('tpo_inconformidad_id'));
			$final = array();
			$r = DB::table('ca_tpo_noconformidades as c')
					->select('c.id', 'c.tpo_inconformidad')
					->Join('ca_tpo_bitacoras as b', 'b.id', '=', 'c.tpo_bitacora_id')
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
		$c['no_conformidad_id']=$_POST['no_conformidad_id'];
		$c['comentario']=$_POST['comentario'];
		$c['costo']=$_POST['costo'];
		$c['estatus_id']=$_POST['estatus_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new A_comentarios_nc($c);
		$a_no_conformidade=A_no_conformidade::findOrFail($c['no_conformidad_id']);
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
