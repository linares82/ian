<?php

class S_documentosController extends BaseController {

	/**
	 * S_documento Repository
	 *
	 * @var S_documento
	 */
	protected $s_documento;

	public function __construct(S_documento $s_documento)
	{
		$this->s_documento = $s_documento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cat_docs_ls=['0' => 'Seleccionar'] + Cs_cat_doc::lists('cat_doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$estatus_ls=['0' => 'Seleccionar'] + S_estatus_procedimiento::lists('estatus','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_documentos.index', compact('cat_docs_ls', 'bnds_ls', 'estatus_ls', 'responsables_ls'));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$catDoc = isset($_POST['documento']) ? intval($_POST['documento']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->s_documento
				->id($id)->Cia($cia)->CatDoc($catDoc)->Estatus($estatus)
				->withTrashed()->count();

		$model=$this->s_documento
				->select('s_documentos.id', 'd.cat_doc', 's_documentos.descripcion', 'st.estatus', 
					's_documentos.fec_fin_vigencia', 's_documentos.archivo', 's_documentos.dias_aviso',
					DB::raw('datediff(s_documentos.fec_fin_vigencia, CURDATE()) as dias_restantes'),   
					's_documentos.created_at', 's_documentos.updated_at', 's_documentos.deleted_at')
				->join('cs_cat_docs as d', 'd.id', '=', 's_documentos.documento_id')
				->join('s_estatus_procedimientos as st', 'st.id', '=', 's_documentos.estatus_id')
				->Id($id)->Cia($cia)->CatDoc($catDoc)->Estatus($estatus)
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
		$cat_docs_ls=['0' => 'Seleccionar'] + Cs_cat_doc::lists('cat_doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_documentos.create', compact('cat_docs_ls', 'bnds_ls', 'responsables_ls'));
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
		$validation = Validator::make($input, S_documento::$rules, S_documento::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->s_documento->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_documentos', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('s_documento.index');
		}

		return Redirect::route('s_documento.create')
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
		$s_documento = $this->s_documento->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;		

		return View::make('s_documentos.show', compact('s_documento', 'cia', 'usuario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$s_documento = $this->s_documento->find($id);

		if (is_null($s_documento))
		{
			return Redirect::route('s_documentos.index');
		}
		$cat_docs_ls=['0' => 'Seleccionar'] + Cs_cat_doc::lists('cat_doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('s_documentos.edit', compact(['s_documento', 'cat_docs_ls', 'bnds_ls', 'responsables_ls']));
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
		$validation = Validator::make($input, S_documento::$rules, S_documento::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$s_documento = $this->s_documento->find($id);

			if(Input::hasFile('file')){
				if($s_documento->archivo<>Input::file('file')->getClientOriginalName() 
					and $s_documento->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_documentos/'.$s_documento->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_documentos/'.$s_documento->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if ($s_documento->update($input) and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/s_documentos', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('s_documento.show', $id);
		}

		return Redirect::route('s_documento.edit', $id)
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
		if ($this->s_documento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->s_documento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['s_documento_id']=$_POST['s_documento_id'];
		$c['comentario']=$_POST['comentario'];
		$c['estatus_id']=$_POST['estatus_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new S_comentarios_documento($c);
		$s_documento=S_documento::findOrFail($c['s_documento_id']);
		$s_documento->comentarios()->save($comentario);
		$s_documento->estatus_id=$c['estatus_id'];
		$s_documento->save();
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
