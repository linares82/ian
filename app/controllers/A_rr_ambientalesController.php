<?php

class A_rr_ambientalesController extends BaseController {

	/**
	 * A_rr_ambientale Repository
	 *
	 * @var A_rr_ambientale
	 */
	protected $a_rr_ambientale;
	protected $a_rr_amb_doc;

	public function __construct(A_rr_ambientale $a_rr_ambientale, A_rr_amb_doc $a_rr_amb_doc)
	{
		$this->a_rr_ambientale = $a_rr_ambientale;
		$this->a_rr_amb_doc=$a_rr_amb_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cia=$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		$categorias_ls=['0' => 'Seleccionar'] + Ca_categorium::lists('categoria','id');
		$documentos_ls=['0' => 'Seleccionar'] + Ca_aa_doc::where('cia_id',$cia)->lists('doc','id');
		$estatus_ls=['0' => 'Seleccionar'] + A_st_archivo::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_rr_ambientales.index', compact(['materiales_ls', 'categorias_ls', 
					'documentos_ls', 'bnds_ls', 'estatus_ls', 'responsables_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$material = isset($_POST['material']) ? intval($_POST['material']) : 0;
		$categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : 0;
		$documento = isset($_POST['documento']) ? intval($_POST['documento']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_rr_ambientale
					->id($id)->Cia($cia)->Material($material)->Categoria($categoria)
					->Documento($documento)->Estatus($estatus)
					->withTrashed()->count();

		$model=$this->a_rr_ambientale
				->select('a_rr_ambientales.id','m.material', 'c.categoria', 'd.doc', 'a_rr_ambientales.descripcion',
					DB::raw('datediff(a_rr_ambientales.fec_fin_vigencia, CURDATE()) as dias_restantes'), 
					'a_rr_ambientales.fec_fin_vigencia', 'a_rr_ambientales.archivo', 'st.estatus', 'a_rr_ambientales.dias_aviso', 
					'a_rr_ambientales.created_at', 'a_rr_ambientales.updated_at', 'a_rr_ambientales.deleted_at')
				->join('ca_materiales as m', 'm.id', '=', 'a_rr_ambientales.material_id')
				->join('ca_categoria as c', 'c.id', '=', 'a_rr_ambientales.categoria_id')
				->join('ca_aa_docs as d', 'd.id', '=', 'a_rr_ambientales.documento_id')
				->join('a_st_archivos as st', 'st.id', '=', 'a_rr_ambientales.st_archivo_id')
				->Id($id)->Cia($cia)->Material($material)->Categoria($categoria)
				->Documento($documento)->Estatus($estatus)
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
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		$categorias_ls=['0' => 'Seleccionar'] + Ca_categorium::lists('categoria','id');
		$documentos_ls=['0' => 'Seleccionar'] + Ca_aa_doc::lists('doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_rr_ambientales.create', array('materiales_ls'=>$materiales_ls, 
			'categorias_ls'=>$categorias_ls, 'documentos_ls'=>$documentos_ls, 'bnds_ls'=>$bnds_ls, 'responsables_ls'=>$responsables_ls));
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

		$validation = Validator::make($input, A_rr_ambientale::$rules, A_rr_ambientale::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->a_rr_ambientale->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('a_rr_ambientale.index');
		}

		return Redirect::route('a_rr_ambientale.create')
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
		$a_rr_ambientale = $this->a_rr_ambientale->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
		
		return View::make('a_rr_ambientales.show', array('a_rr_ambientale'=>$a_rr_ambientale, 'cia'=>$cia, 'usuario'=>$usuario));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_rr_ambientale = $this->a_rr_ambientale->find($id);
		$documentos = DB::table('a_rr_amb_docs')
						->where('a_rr_ambiental_id', '=', $id)
						->where('deleted_at', '=', null)
						->get();
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=Sentry::getUser()->id;

		if (is_null($a_rr_ambientale))
		{
			return Redirect::route('a_rr_ambientales.index');
		}
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		$categorias_ls=['0' => 'Seleccionar'] + Ca_categorium::lists('categoria','id');
		$documentos_ls=['0' => 'Seleccionar'] + DB::Table('ca_aa_docs')->lists('doc','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_rr_ambientales.edit', array('a_rr_ambientale'=>$a_rr_ambientale, 
			'materiales_ls'=>$materiales_ls, 'categorias_ls'=>$categorias_ls, 
			'documentos_ls'=>$documentos_ls, 'bnds_ls'=>$bnds_ls, 'responsables_ls'=>$responsables_ls,
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
			Input::file('file1')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales_doc', Input::file('file1')->getClientOriginalName());
			
			$documento['usu_mod_id']=$usuario;
			$documento['usu_alta_id']=$usuario;
			$documento['a_rr_ambiental_id']=$id;
			$documento['documento']=$input['documento'];
			//dd($documento);
			$this->a_rr_amb_doc->create($documento);
		}
		
		unset($input['file1']);
		unset($input['documento']);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
		

		$validation = Validator::make($input, A_rr_ambientale::$rules, A_rr_ambientale::$rulesMessages);

		if ($validation->passes())
		{
			$a_rr_ambientale = $this->a_rr_ambientale->find($id);

			if(Input::hasFile('file')){
				if($a_rr_ambientale->archivo<>Input::file('file')->getClientOriginalName() 
					and $a_rr_ambientale->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales/'.$a_rr_ambientale->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales/'.$a_rr_ambientale->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($a_rr_ambientale->update($input) and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_rr_ambientales', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('a_rr_ambientale.show', $id);
		}

		return Redirect::route('a_rr_ambientale.edit', $id)
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
		if ($this->a_rr_ambientale->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_rr_ambientale->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbCategorias(){
		if(Request::ajax()){
			$material = e(Input::get('material_id'));
			$categoria = e(Input::get('categoria_id'));
			$final = array();
			$r = DB::table('ca_categoria as c')
					->select('c.id', 'c.categoria')
					->Join('ca_materiales as m', 'm.id', '=', 'c.material_id')
					->where('c.material_id', '=', $material)
					->distinct()->get();
			if(isset($categoria) and $categoria<>0){
				foreach($r as $r1){
					if($r1->id==$categoria){
						array_push($final, array('id'=>$r1->id, 
												 'categoria'=>$r1->categoria, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'categoria'=>$r1->categoria, 
												 'selectec'=>''));
					}
				}
				return $final;
			}else{
				return $r;	
			}
			
		}
	}

	public function cmbDocumentos(){
		$cia=$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		if(Request::ajax()){
			$material = e(Input::get('material_id'));
			$categoria = e(Input::get('categoria_id'));
			$documento = e(Input::get('documento_id'));
			$final = array();
			$r = DB::table('ca_aa_docs as d')
					->select('d.id', 'd.doc')
					->join('ca_categoria as c', 'c.id', '=', 'd.categoria_id')
					->Join('ca_materiales as m', 'm.id', '=', 'd.material_id')
					->where('d.material_id', '=', $material)
					->where('d.categoria_id', '=', $categoria)
					->where('d.cia_id', $cia)
					->distinct()->get();
			
			if(isset($documento) and $documento<>0){
				foreach($r as $r1){
					if($r1->id==$documento){
						array_push($final, array('id'=>$r1->id, 
												 'doc'=>$r1->doc, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'doc'=>$r1->doc, 
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
		$c['a_rr_id']=$_POST['a_rr_id'];
		$c['comentario']=$_POST['comentario'];
		$c['a_st_rr_id']=$_POST['a_st_rr_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		$comentario=new A_comentarios_rr;
		if ($comentario->create($c)){
			$p=A_rr_ambientale::find($c['a_rr_id']);
			$p->st_archivo_id=$c['a_st_rr_id'];
			if($p->save()){
				echo json_encode(array('success'=>true));
			}else{
				echo json_encode(array('msg'=>'Problemas al crear registro.'));
			}
		}
		else{
			echo json_encode(array('msg'=>'Problemas al crear registro.'));
		}
	}


}
