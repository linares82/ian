<?php

class A_procedimientosController extends BaseController {

	/**
	 * A_procedimiento Repository
	 *
	 * @var A_procedimiento
	 */
	protected $a_procedimiento;

	public function __construct(A_procedimiento $a_procedimiento)
	{
		$this->a_procedimiento = $a_procedimiento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$procedimientos_ls=['0' => 'Seleccionar'] + Ca_procedimiento::lists('procedimiento','id');
		$estatus_ls=['0' => 'Seleccionar'] + A_st_archivo::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_procedimientos.index', compact(['procedimientos_ls','bnds_ls', 'estatus_ls', 'responsables_ls']));
		
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$procedimiento = isset($_POST['procedimiento']) ? intval($_POST['procedimiento']) : 0;
		$estatus = isset($_POST['estatus']) ? intval($_POST['estatus']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_procedimiento->id($id)
					->Cia($cia)->Procedimiento($procedimiento)->Estatus($estatus)
					->withTrashed()->count();

		$model=$this->a_procedimiento
				->select('a_procedimientos.id', 'p.procedimiento', 'a_procedimientos.descripcion', 'a_procedimientos.archivo',
						DB::raw('datediff(a_procedimientos.fec_fin_vigencia, CURDATE()) as dias_restantes'),
						'a_procedimientos.dias_aviso', 'a_procedimientos.fec_fin_vigencia', 'st.estatus',
						'a_procedimientos.created_at', 'a_procedimientos.updated_at', 'a_procedimientos.deleted_at')
				->join('ca_procedimientos as p', 'p.id', '=', 'a_procedimientos.procedimiento_id')
				->join('a_st_archivos as st', 'st.id', '=', 'a_procedimientos.st_archivo_id')
				->Id($id)->Cia($cia)->Procedimiento($procedimiento)->Estatus($estatus)
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
		$procedimientos_ls=['0' => 'Seleccionar'] + Ca_procedimiento::lists('procedimiento','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_procedimientos.create', array('procedimientos_ls'=>$procedimientos_ls, 'bnds_ls'=>$bnds_ls, 'responsables_ls'=>$responsables_ls));
		
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
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		

		$validation = Validator::make($input, A_procedimiento::$rules, A_procedimiento::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			if($this->a_procedimiento->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_procedimientos', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('a_procedimiento.index');
		}

		return Redirect::route('a_procedimiento.create')
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
		$a_procedimiento = $this->a_procedimiento->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
		return View::make('a_procedimientos.show', array('a_procedimiento'=>$a_procedimiento, 'cia'=>$cia, 'usuario'=>$usuario));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_procedimiento = $this->a_procedimiento->find($id);

		if (is_null($a_procedimiento))
		{
			return Redirect::route('a_procedimientos.index');
		}
		$procedimientos_ls=['0' => 'Seleccionar'] + Ca_procedimiento::lists('procedimiento','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('a_procedimientos.edit', array('a_procedimiento'=>$a_procedimiento, 'procedimientos_ls'=>$procedimientos_ls, 'bnds_ls'=>$bnds_ls, 'responsables_ls'=>$responsables_ls));
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
		$validation = Validator::make($input, A_procedimiento::$rules, A_procedimiento::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$a_procedimiento = $this->a_procedimiento->find($id);

			if(Input::hasFile('file')){
				if($a_procedimiento->archivo<>Input::file('file')->getClientOriginalName() 
					and $a_procedimiento->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_procedimientos/'.$a_procedimiento->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_procedimientos/'.$a_procedimiento->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($a_procedimiento->update($input) and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/a_procedimientos', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('a_procedimiento.show', $id);
		}

		return Redirect::route('a_procedimiento.edit', $id)
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
		if ($this->a_procedimiento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_procedimiento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['a_procedimiento_id']=$_POST['a_procedimiento_id'];
		$c['comentario']=$_POST['comentario'];
		$c['a_st_procedimiento_id']=$_POST['a_st_procedimiento_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		$comentario=new A_comentarios_procedimiento;
		if ($comentario->create($c)){
			$p=A_procedimiento::find($c['a_procedimiento_id']);
			$p->st_archivo_id=$c['a_st_procedimiento_id'];
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
