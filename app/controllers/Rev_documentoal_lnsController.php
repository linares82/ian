<?php

class Rev_documentoal_lnsController extends BaseController {

	/**
	 * Rev_documentoal_ln Repository
	 *
	 * @var Rev_documentoal_ln
	 */
	protected $rev_documentoal_ln;

	public function __construct(Rev_documentoal_ln $rev_documentoal_ln)
	{
		$this->rev_documentoal_ln = $rev_documentoal_ln;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rev_documental=$_GET['id'];
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		return View::make('rev_documentoal_lns.index', compact('rev_documental'));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$rev_documental=isset($_REQUEST['rev_documental']) ? intval($_REQUEST['rev_documental']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->rev_documentoal_ln->id($id)->RevDocumental($rev_documental)->withTrashed()->count();

		$model=$this->rev_documentoal_ln
				->select('rev_documentoal_lns.id', 'td.tpo_doc', 'rd.r_documento', 'er.estatus', 
						'rev_documentoal_lns.archivo', 'i.importancia', 'rev_documentoal_lns.fec_vencimiento',
						'rev_documentoal_lns.fec_cumplimiento', 'rev_documentoal_lns.dias_advertencia1', 
						'rev_documentoal_lns.dias_advertencia2', 'rev_documentoal_lns.dias_advertencia3',
						DB::raw('datediff(rev_documentoal_lns.fec_cumplimiento, CURDATE()) as dias_restantes_cumplimiento'), 
						DB::raw('datediff(rev_documentoal_lns.fec_vencimiento, CURDATE()) as dias_restantes_vencimiento'), 
						'rev_documentoal_lns.created_at', 'rev_documentoal_lns.updated_at', 'rev_documentoal_lns.deleted_at')
				->join('tpo_docs as td', 'td.id', '=', 'rev_documentoal_lns.tpo_documento_id')
				->join('estatus_requisitos as er', 'er.id', '=', 'rev_documentoal_lns.estatus_id')
				->join('importancia as i', 'i.id', '=', 'rev_documentoal_lns.importancia_id')
				->join('r_documentos as rd', 'rd.id','=', 'rev_documentoal_lns.documento_id')
				->Id($id)->RevDocumental($rev_documental)
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
	public function create($id)
	{
		$rev_documental=$id;
		$tpo_documentos_ls=['0' => 'Seleccionar'] + Tpo_doc::lists('tpo_doc','id');
		$estatus_ls=['0' => 'Seleccionar'] + Estatus_condicione::lists('estatus','id');
		$importancia_ls=['0' => 'Seleccionar'] + Importancium::lists('importancia','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$r_documentos_ls=['0' => 'Seleccionar'] + R_documento::lists('r_documento','id');
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		//dd($rev_documental);
		return View::make('rev_documentoal_lns.create', 
					compact(['rev_documental', 'tpo_documentos_ls', 'estatus_ls', 
							'importancia_ls', 'responsables_ls', 'r_documentos_ls',
							'grupos_ls', 'normas_ls']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($rev)
	{
		$input = Input::all();
		unset($input['file']);
		$input['rev_documental_id']=$rev;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Rev_documentoal_ln::$rules, Rev_documentoal_ln::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->rev_documentoal_ln->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/rev_documentoal_lns', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('rev_documentoal_ln.index', array('id'=>$rev));
		}

		return Redirect::route('rev_documentoal_ln.create', array('id'=>$rev))
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
		$rev_documentoal_ln = $this->rev_documentoal_ln->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;		
		return View::make('rev_documentoal_lns.show', compact('rev_documentoal_ln', 'cia', 'usuario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rev_documentoal_ln = $this->rev_documentoal_ln->find($id);

		if (is_null($rev_documentoal_ln))
		{
			return Redirect::route('rev_documentoal_lns.index');
		}
		$tpo_documentos_ls=['0' => 'Seleccionar'] + Tpo_doc::lists('tpo_doc','id');
		$estatus_ls=['0' => 'Seleccionar'] + Estatus_condicione::lists('estatus','id');
		$importancia_ls=['0' => 'Seleccionar'] + Importancium::lists('importancia','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$r_documentos_ls=['0' => 'Seleccionar'] + R_documento::lists('r_documento','id');
		$grupos_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		return View::make('rev_documentoal_lns.edit', 
				compact(['rev_documentoal_ln', 'tpo_documentos_ls', 'estatus_ls', 
						'importancia_ls', 'responsables_ls', 'r_documentos_ls',
						'grupos_ls', 'normas_ls']));
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
		$validation = Validator::make($input, Rev_documentoal_ln::$rules, Rev_documentoal_ln::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$rev_documentoal_ln = $this->rev_documentoal_ln->find($id);

			if(Input::hasFile('file')){
				if($rev_documentoal_ln->archivo<>Input::file('file')->getClientOriginalName() 
					and $rev_documentoal_ln->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/rev_documentoal_lns/'.$rev_documentoal_ln->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/rev_documentoal_lns/'.$rev_documentoal_ln->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($rev_documentoal_ln->update($input) and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/rev_documentoal_lns', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('rev_documentoal_ln.show', $id);
		}

		return Redirect::route('rev_documentoal_ln.edit', $id)
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
		if ($this->rev_documentoal_ln->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->rev_documentoal_ln->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbDoc(){
		if(Request::ajax()){
			$tpo_doc = e(Input::get('tpo_documento_id'));
			$documento = e(Input::get('documento_id'));
			$final = array();
			$r = DB::table('r_documentos as rd')
					->select('rd.id', 'rd.r_documento')
					->Join('tpo_docs as td', 'td.id', '=', 'rd.tpo_documento_id')
					->where('rd.tpo_documento_id', '=', $tpo_doc)
					->distinct()->get();
			//dd($_REQUEST);
			if(isset($documento) and $documento<>0){
				foreach($r as $r1){
					if($r1->id==$documento){
						array_push($final, array('id'=>$r1->id, 
												 'r_documento'=>$r1->r_documento, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'r_documento'=>$r1->r_documento, 
												 'selectec'=>''));
					}
				}
				return $final;
			}else{
				return $r;	
			}
			
		}
	}

	public function cmbNormas(){
		if(Request::ajax()){
			$grupo = e(Input::get('grupo_norma_id'));
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

}
