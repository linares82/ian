<?php

class S_procedimientosController extends BaseController {

	/**
	 * S_procedimiento Repository
	 *
	 * @var S_procedimiento
	 */
	protected $s_procedimiento;

	public function __construct(S_procedimiento $s_procedimiento)
	{
		$this->s_procedimiento = $s_procedimiento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tpo_procedimientos_ls=['0' => 'Seleccionar'] + Cs_tpo_procedimiento::lists('tpo_procedimiento','id');
		$tpo_documentos_ls=['0' => 'Seleccionar'] + Cs_tpo_doc::lists('tpo_doc','id');
		$estatus_ls=['0' => 'Seleccionar'] + S_estatus_procedimiento::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_procedimientos.index', compact(['tpo_procedimientos_ls', 'tpo_documentos_ls', 'bnds_ls', 'estatus_ls', 'responsables_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$tpo_procedimiento = isset($_POST['tpo_procedimiento']) ? intval($_POST['tpo_procedimiento']) : 0;
		$tpo_documento = isset($_POST['tpo_documento']) ? intval($_POST['tpo_documento']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->s_procedimiento
				->id($id)->Cia($cia)->TpoProcedimiento($tpo_procedimiento)
				->TpoDocumento($tpo_documento)->Estatus($estatus)
				->withTrashed()->count();

		$model=$this->s_procedimiento
				->select('s_procedimientos.id', 'p.tpo_procedimiento', 'd.tpo_doc', 's_procedimientos.descripcion', 
					'st.estatus', 's_procedimientos.archivo',
					DB::raw('datediff(s_procedimientos.fec_fin_vigencia, CURDATE()) as dias_restantes'), 
					's_procedimientos.dias_aviso', 's_procedimientos.fec_fin_vigencia',
					's_procedimientos.created_at', 's_procedimientos.updated_at', 's_procedimientos.deleted_at')
				->join('cs_tpo_procedimientos as p', 'p.id', '=', 's_procedimientos.tpo_procedimiento_id')
				->join('cs_tpo_docs as d', 'd.id', '=', 's_procedimientos.tpo_doc_id')
				->join('s_estatus_procedimientos as st', 'st.id', '=', 's_procedimientos.estatus_id')
				->Id($id)->Cia($cia)->TpoProcedimiento($tpo_procedimiento)
				->TpoDocumento($tpo_documento)->Estatus($estatus)
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
		$tpo_procedimientos_ls=['0' => 'Seleccionar'] + Cs_tpo_procedimiento::lists('tpo_procedimiento','id');
		$tpo_documentos_ls=['0' => 'Seleccionar'] + Cs_tpo_doc::lists('tpo_doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_procedimientos.create', compact(['tpo_procedimientos_ls', 'tpo_documentos_ls', 'bnds_ls', 'responsables_ls']));
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
		$input['estatus_id'] =1; 
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, S_procedimiento::$rules, S_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->s_procedimiento->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_procedimientos', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('s_procedimiento.index');
		}

		return Redirect::route('s_procedimiento.create')
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
		$s_procedimiento = $this->s_procedimiento->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		return View::make('s_procedimientos.show', compact('s_procedimiento', 'cia', 'usuario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_procedimiento = $this->s_procedimiento->find($id);

		if (is_null($s_procedimiento))
		{
			return Redirect::route('s_procedimientos.index');
		}
		$tpo_procedimientos_ls=['0' => 'Seleccionar'] + Cs_tpo_procedimiento::lists('tpo_procedimiento','id');
		$tpo_documentos_ls=['0' => 'Seleccionar'] + Cs_tpo_doc::lists('tpo_doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_procedimientos.edit', compact(['s_procedimiento', 'tpo_procedimientos_ls', 'tpo_documentos_ls', 'bnds_ls', 'responsables_ls']));
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

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		$validation = Validator::make($input, S_procedimiento::$rules, S_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			$s_procedimiento = $this->s_procedimiento->find($id);

			if(Input::hasFile('file')){
				if($s_procedimiento->archivo<>Input::file('file')->getClientOriginalName() 
					and $s_procedimiento->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_procedimientos/'.$s_procedimiento->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_procedimientos/'.$s_procedimiento->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($s_procedimiento->update($input)and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_procedimientos', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('s_procedimiento.show', $id);
		}

		return Redirect::route('s_procedimiento.edit', $id)
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
		if ($this->s_procedimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_procedimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['s_procedimiento_id']=$_POST['procedimiento_id'];
		$c['comentario']=$_POST['comentario'];
		$c['estatus_id']=$_POST['estatus_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new S_comentarios_procedimiento($c);
		$s_procedimiento=S_procedimiento::findOrFail($c['s_procedimiento_id']);
		$s_procedimiento->comentarios()->save($comentario);
		$s_procedimiento->estatus_id=$c['estatus_id'];
		$s_procedimiento->save();
		echo json_encode(array('success'=>true));
		}
		catch(\Exception $e){
			DB::rollback();
    		//throw $e;
    		echo json_encode(array('msg'=>$e));
		}
		DB::commit();
	}

	public function cmbDocumentos(){
		if(Request::ajax()){
			$tpo_procedimiento = e(Input::get('tpo_procedimiento_id'));
			$tpo_doc = e(Input::get('tpo_doc_id'));
			$final = array();
			$r = DB::table('cs_tpo_docs as d')
					->select('d.id', 'd.tpo_doc')
					->Join('cs_tpo_procedimientos as p', 'p.id', '=', 'd.tpo_procedimiento_id')
					->where('d.tpo_procedimiento_id', '=', $tpo_procedimiento)
					->distinct()->get();
			if(isset($tpo_doc) and $tpo_doc<>0){
				foreach($r as $r1){
					if($r1->id==$tpo_doc){
						array_push($final, array('id'=>$r1->id, 
												 'tpo_doc'=>$r1->tpo_doc, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'tpo_doc'=>$r1->tpo_doc, 
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
