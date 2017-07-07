<?php

class Rev_requisitos_lnsController extends BaseController {

	/**
	 * Rev_requisitos_ln Repository
	 *
	 * @var Rev_requisitos_ln
	 */
	protected $rev_requisitos_ln;

	public function __construct(Rev_requisitos_ln $rev_requisitos_ln)
	{
		$this->rev_requisitos_ln = $rev_requisitos_ln;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rev_requisito=$_GET['id'];

		return View::make('rev_requisitos_lns.index', compact(['rev_requisito']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$rev_requisito=isset($_REQUEST['rev_requisito']) ? intval($_REQUEST['rev_requisito']) : 0;
		$result = array();
		//dd($_GET);
		$count_rows=0;
		$model=array();

		$count_rows=$this->rev_requisitos_ln->id($id)->RevRequisito($rev_requisito)->count();

		$model=$this->rev_requisitos_ln
				->select('rev_requisitos_lns.id', 'ai.impacto', 'c.condicion', 'ec.estatus', 
						'rev_requisitos_lns.fec_cumplimiento', 'rev_requisitos_lns.dias_advertencia1', 
						'rev_requisitos_lns.dias_advertencia2', 'rev_requisitos_lns.dias_advertencia3',
						'i.importancia',
						DB::raw('datediff(rev_requisitos_lns.fec_cumplimiento, CURDATE()) as dias_restantes'), 
						'rev_requisitos_lns.created_at', 'rev_requisitos_lns.updated_at', 'rev_requisitos_lns.deleted_at')
				->join('aa_impactos as ai', 'ai.id', '=', 'rev_requisitos_lns.impacto_id')
				->join('areas as a', 'a.id', '=', 'rev_requisitos_lns.area_id')
				->join('estatus_condiciones as ec', 'ec.id', '=', 'rev_requisitos_lns.estatus_id')
				->join('importancia as i', 'i.id', '=', 'rev_requisitos_lns.importancia_id')
				->join('condiciones as c', 'c.id', '=', 'rev_requisitos_lns.condicion_id')
				->Id($id)->RevRequisito($rev_requisito)
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
		$rev_requisitos_id=$id;
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$estatus_ls=['0' => 'Seleccionar'] + Estatus_condicione::lists('estatus','id');
		$importancia_ls=['0' => 'Seleccionar'] + Importancium::lists('importancia','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$condiciones_ls=['0' => 'Seleccionar'] + Condicione::lists('condicion','id');
		return View::make('rev_requisitos_lns.create', 
				  compact('rev_requisitos_id', 'impactos_ls', 
						  'areas_ls', 'estatus_ls', 'importancia_ls', 'responsables_ls', 'condiciones_ls'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($rev)
	{
		$input = Input::all();
		$input['rev_requisitos_id']=$rev;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Rev_requisitos_ln::$rules, Rev_requisitos_ln::$rulesMessages);

		if ($validation->passes())
		{
			//dd($input);
			$this->rev_requisitos_ln->create($input);

			return Redirect::route('rev_requisitos_ln.index', array('id'=>$rev));
		}
		
		return Redirect::route('rev_requisitos_ln.create', array('id'=>$rev))
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
		$rev_requisitos_ln = $this->rev_requisitos_ln->findOrFail($id);

		return View::make('rev_requisitos_lns.show', compact('rev_requisitos_ln'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rev_requisitos_ln = $this->rev_requisitos_ln->find($id);

		if (is_null($rev_requisitos_ln))
		{
			return Redirect::route('rev_requisitos_lns.index');
		}
		
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$estatus_ls=['0' => 'Seleccionar'] + Estatus_condicione::lists('estatus','id');
		$importancia_ls=['0' => 'Seleccionar'] + Importancium::lists('importancia','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		$condiciones_ls=['0' => 'Seleccionar'] + Condicione::lists('condicion','id');
		return View::make('rev_requisitos_lns.edit', 
				  compact(['rev_requisitos_ln', 'impactos_ls', 'areas_ls', 'estatus_ls',
				  			'importancia_ls', 'responsables_ls', 'condiciones_ls']));
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
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Rev_requisitos_ln::$rules, Rev_requisitos_ln::$rulesMessages);

		if ($validation->passes())
		{
			$rev_requisitos_ln = $this->rev_requisitos_ln->find($id);
			$rev_requisitos_ln->update($input);

			return Redirect::route('rev_requisitos_ln.show', $id);
		}

		return Redirect::route('rev_requisitos_ln.edit', $id)
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
		if ($this->rev_requisitos_ln->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->rev_requisitos_ln->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbDoc(){
		if(Request::ajax()){
			$impacto = e(Input::get('impacto_id'));
			$condicion = e(Input::get('condicion_id'));
			$final = array();
			$r = DB::table('condiciones as c')
					->select('c.id', 'c.condicion')
					->Join('aa_impactos as i', 'i.id', '=', 'c.impacto_id')
					->where('c.impacto_id', '=', $impacto)
					->distinct()->get();
			//dd($r);
			if(isset($condicion) and $condicion<>0){
				foreach($r as $r1){
					if($r1->id==$condicion){
						array_push($final, array('id'=>$r1->id, 
												 'condicion'=>$r1->condicion, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'condicion'=>$r1->condicion, 
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
