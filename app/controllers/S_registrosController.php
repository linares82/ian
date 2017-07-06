<?php

class S_registrosController extends BaseController {

	/**
	 * S_registro Repository
	 *
	 * @var S_registro
	 */
	protected $s_registro;

	public function __construct(S_registro $s_registro)
	{
		$this->s_registro = $s_registro;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		$elementos_ls=['0' => 'Seleccionar'] + Cs_elementos_inspeccion::lists('elemento','id');
		$estatus_ls=['0' => 'Seleccionar'] + S_estatus_procedimiento::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_registros.index', compact(['grupos_ls', 'normas_ls', 'elementos_ls', 'bnds_ls', 'estatus_ls', 'responsables_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$grupo = isset($_POST['grupo']) ? intval($_POST['grupo']) : 0;
		$norma = isset($_POST['norma']) ? intval($_POST['norma']) : 0;
		$elemento = isset($_POST['elemento']) ? intval($_POST['elemento']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->s_registro
				->id($id)->Cia($cia)->grupo($grupo)->norma($norma)->elemento($elemento)
				->Estatus($estatus)
				->withTrashed()->count();

		$model=$this->s_registro
				->select('s_registros.id', 'gn.grupo_norma', 'n.norma', 'e.elemento', 'st.estatus',
					's_registros.detalle', 's_registros.archivo',
					DB::raw('datediff(s_registros.fec_fin_vigencia, CURDATE()) as dias_restantes'), 
					's_registros.dias_aviso', 's_registros.fec_fin_vigencia', 
					's_registros.created_at', 's_registros.updated_at', 's_registros.deleted_at')
				->join('cs_grupo_normas as gn', 'gn.id', '=', 's_registros.grupo_id')
				->join('cs_normas as n', 'n.id', '=', 's_registros.norma_id')
				->join('cs_elementos_inspeccions as e', 'e.id', '=', 's_registros.elemento_id')
				->join('s_estatus_procedimientos as st', 'st.id', '=', 's_registros.estatus_id')
				->Id($id)->Cia($cia)->grupo($grupo)->norma($norma)->elemento($elemento)
				->Estatus($estatus)
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
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		$elementos_ls=['0' => 'Seleccionar'] + Cs_elementos_inspeccion::lists('elemento','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_registros.create', compact(['grupos_ls', 'normas_ls', 'elementos_ls', 'bnds_ls', 'responsables_ls']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		unset($input['file']);
		$input['estatus_id']=1;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, S_registro::$rules, S_registro::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->s_registro->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_registros', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('s_registro.index');
		}

		return Redirect::route('s_registro.create')
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
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
		$s_registro = $this->s_registro->findOrFail($id);

		return View::make('s_registros.show', compact(['s_registro', 'cia', 'usuario']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_registro = $this->s_registro->find($id);

		if (is_null($s_registro))
		{
			return Redirect::route('s_registros.index');
		}
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		$elementos_ls=['0' => 'Seleccionar'] + Cs_elementos_inspeccion::lists('elemento','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_registros.edit', compact(['s_registro', 'grupos_ls', 'normas_ls', 'elementos_ls', 'bnds_ls', 'responsables_ls']));
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
		unset($input['file']);
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, S_registro::$rules, S_registro::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$s_registro = $this->s_registro->find($id);

			if(Input::hasFile('file')){
				if($s_registro->archivo<>Input::file('file')->getClientOriginalName() 
					and $s_registro->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_registros/'.$s_registro->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_registros/'.$s_registro->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($s_registro->update($input)and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_registros', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('s_registro.show', $id);
		}

		return Redirect::route('s_registro.edit', $id)
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
		if ($this->s_registro->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_registro->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['s_registros_id']=$_POST['registro_id'];
		$c['comentario']=$_POST['comentario'];
		$c['estatus_id']=$_POST['estatus_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new S_comentarios_registro($c);
		$s_registro=S_registro::findOrFail($c['s_registros_id']);
		$s_registro->comentarios()->save($comentario);
		$s_registro->estatus_id=$c['estatus_id'];
		$s_registro->save();
		echo json_encode(array('success'=>true));
		}
		catch(\Exception $e){
			DB::rollback();
    		//throw $e;
    		echo json_encode(array('msg'=>$e));
		}
		DB::commit();
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

	public function cmbElementos(){
		if(Request::ajax()){
			$grupo = e(Input::get('grupo_id'));
			$norma = e(Input::get('norma_id'));
			$elemento= e(Input::get('elemento_id'));
			$final = array();
			$r = DB::table('cs_elementos_inspeccions as e')
					->select('e.id', 'e.elemento')
					->Join('cs_grupo_normas as gn', 'gn.id', '=', 'e.grupo_norma_id')
					->Join('cs_normas as n', 'n.id', '=', 'e.norma_id')
					->where('e.grupo_norma_id', '=', $grupo)
					->where('e.norma_id', '=', $norma)
					->distinct()->get();
			if(isset($elemento) and $elemento<>0){
				foreach($r as $r1){
					if($r1->id==$elemento){
						array_push($final, array('id'=>$r1->id, 
												 'elemento'=>$r1->elemento, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'elemento'=>$r1->elemento, 
												 'selectec'=>''));
					}
				}
				return $final;
			}else{
				return $r;	
			}
			
		}
	}

}
