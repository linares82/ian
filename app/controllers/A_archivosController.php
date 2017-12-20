<?php

class A_archivosController extends BaseController {

	/**
	 * A_archivo Repository
	 *
	 * @var A_archivo
	 */
	protected $a_archivo;
        protected $a_archi_doc;
	public function __construct(A_archivo $a_archivo, A_archi_doc $a_archi_doc)
	{
		$this->a_archivo = $a_archivo;
                $this->a_archi_doc = $a_archi_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$documentos_ls=['0' => 'Seleccionar'] + Ca_ca_doc::lists('doc','id');
		$estatus_ls=['0' => 'Seleccionar'] + A_st_archivo::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('a_archivos.index', compact(['documentos_ls', 'bnds_ls', 'estatus_ls', 'responsables_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$documento = isset($_POST['documento']) ? intval($_POST['documento']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_archivo->id($id)
					->Cia($cia)->Documento($documento)->Estatus($estatus)
					->withTrashed()->count();

		$model=$this->a_archivo
				->select('a_archivos.id', 'cd.doc', 'a_archivos.descripcion', 'st.estatus', 'a_archivos.fec_fin_vigencia', 
					DB::raw('datediff(a_archivos.fec_fin_vigencia, CURDATE()) as dias_restantes'), 
					'a_archivos.dias_aviso', 'a_archivos.archivo',	
					'a_archivos.created_at', 'a_archivos.updated_at', 'a_archivos.deleted_at')
				->join('ca_ca_docs as cd', 'cd.id', '=', 'a_archivos.documento_id')
				->join('a_st_archivos as st', 'st.id', '=', 'a_archivos.st_archivo_id')
				->Id($id)->Cia($cia)->Documento($documento)->Estatus($estatus)
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
		$documentos_ls=['0' => 'Seleccionar'] + Ca_ca_doc::lists('doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('a_archivos.create', array('documentos_ls'=>$documentos_ls, 'bnds_ls'=>$bnds_ls, 'responsables_ls'=>$responsables_ls));
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
		$input['st_archivo_id']=1;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, A_archivo::$rules, A_archivo::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->a_archivo->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_archivos', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('a_archivo.index');
		}

		return Redirect::route('a_archivo.create')
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
		$a_archivo = $this->a_archivo->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;		
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('a_archivos.show', array('a_archivo'=>$a_archivo,'cia'=>$cia, 'usuario'=>$usuario, 'responsables_ls'=>$responsables_ls));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_archivo = $this->a_archivo->find($id);
                $documentos = DB::table('a_archi_docs')
						->where('a_archivo_id', '=', $id)
						->where('deleted_at', '=', null)
						->get();    
                $cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=Sentry::getUser()->id;
		if (is_null($a_archivo))
		{
			return Redirect::route('a_archivos.index');
		}
		$documentos_ls=['0' => 'Seleccionar'] + Ca_ca_doc::lists('doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('a_archivos.edit', 
                        array('a_archivo'=>$a_archivo, 'documentos_ls'=>$documentos_ls, 
                            'bnds_ls'=>$bnds_ls, 'responsables_ls'=>$responsables_ls, 
                            'documentos'=>$documentos, 'cia'=>$cia, 'usuario'=>$usuario));
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
		
		$documento=array();
		if(Input::hasFile('file1')){
			$documento['archivo']=Input::file('file1')->getClientOriginalName();	
			$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
			$usuario=Sentry::getUser()->id;
			Input::file('file1')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_archi_doc', Input::file('file1')->getClientOriginalName());
			
			$documento['usu_mod_id']=$usuario;
			$documento['usu_alta_id']=$usuario;
			$documento['a_archivo_id']=$id;
			$documento['documento']=$input['documento'];
			//dd($documento);
			$this->a_archi_doc->create($documento);
		}
		
		unset($input['file1']);
		unset($input['documento']);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
                
                $validation = Validator::make($input, A_archivo::$rules, A_archivo::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$a_archivo = $this->a_archivo->find($id);
			
			if(Input::hasFile('file')){
				if($a_archivo->archivo<>Input::file('file')->getClientOriginalName() 
					and $a_archivo->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_archivos/'.$a_archivo->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_archivos/'.$a_archivo->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($a_archivo->update($input) and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_archivos', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('a_archivo.show', $id);
		}

		return Redirect::route('a_archivo.edit', $id)
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
		if ($this->a_archivo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_archivo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['a_archivo_id']=$_POST['a_archivo_id'];
		$c['comentario']=$_POST['comentario'];
		$c['a_st_archivo_id']=$_POST['a_st_archivo_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new A_comentarios_archivo($c);
		$a_archivo=A_archivo::findOrFail($c['a_archivo_id']);
		$a_archivo->comentarios()->save($comentario);
		$a_archivo->st_archivo_id=$c['a_st_archivo_id'];
		$a_archivo->save();
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
