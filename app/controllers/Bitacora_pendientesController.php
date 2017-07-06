<?php

class Bitacora_pendientesController extends BaseController {

	/**
	 * Bitacora_pendiente Repository
	 *
	 * @var Bitacora_pendiente
	 */
	protected $bitacora_pendiente;

	public function __construct(Bitacora_pendiente $bitacora_pendiente)
	{
		$this->bitacora_pendiente = $bitacora_pendiente;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$estatus_ls=['0' => 'Seleccionar'] + Bit_st::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('bitacora_pendientes.index', compact(['estatus_ls', 'bnds_ls', 'responsables_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->bitacora_pendiente->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_pendiente
				->select('bitacora_pendientes.id', 'bitacora_pendientes.pendiente', 'st.estatus', 'bitacora_pendientes.fec_planeada',
				DB::raw('datediff(bitacora_pendientes.fec_planeada, CURDATE()) as dias_restantes'), 'bitacora_pendientes.dias_aviso',
				'bitacora_pendientes.created_at', 'bitacora_pendientes.updated_at', 'bitacora_pendientes.deleted_at') 
				->join('bit_sts as st', 'st.id', '=', 'bitacora_pendientes.bit_st_id')
				->Id($id)->Cia($cia)
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
		$estatus_ls=['0' => 'Seleccionar'] + Bit_st::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('bitacora_pendientes.create', compact(['estatus_ls', 'bnds_ls', 'responsables_ls']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['bit_st_id']=1;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, Bitacora_pendiente::$rules, Bitacora_pendiente::$rulesMessages);

		if ($validation->passes())
		{
			$this->bitacora_pendiente->create($input);

			return Redirect::route('bitacora_pendiente.index');
		}

		return Redirect::route('bitacora_pendiente.create')
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
		$bitacora_pendiente = $this->bitacora_pendiente->findOrFail($id);

		return View::make('bitacora_pendientes.show', compact('bitacora_pendiente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_pendiente = $this->bitacora_pendiente->find($id);

		if (is_null($bitacora_pendiente))
		{
			return Redirect::route('bitacora_pendientes.index');
		}
		$estatus_ls=['0' => 'Seleccionar'] + Bit_st::lists('estatus','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
		return View::make('bitacora_pendientes.edit', compact(['bitacora_pendiente', 'estatus_ls', 'bnds_ls','responsables_ls']));
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
		$validation = Validator::make($input, Bitacora_pendiente::$rules, Bitacora_pendiente::$rulesMessages);

		if ($validation->passes())
		{
			$bitacora_pendiente = $this->bitacora_pendiente->find($id);
			$bitacora_inicial = $this->bitacora_pendiente->find($id); 
			$bitacora_pendiente->update($input);
				
			return Redirect::route('bitacora_pendiente.show', $id);
		}

		return Redirect::route('bitacora_pendiente.edit', $id)
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
		if ($this->bitacora_pendiente->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_pendiente->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function comentarioEstatus(){
		$c=array();
		$c['pendiente_id']=$_POST['pendiente_id'];
		$c['comentario']=$_POST['comentario'];
		$c['estatus_id']=$_POST['estatus_id'];
		$c['usu_alta_id']=Sentry::getUser()->id;
		$c['usu_mod_id']=Sentry::getUser()->id;
		DB::beginTransaction();
		try{
		$comentario=new A_comentarios_pendiente($c);
		$bitacora_pendiente=Bitacora_pendiente::findOrFail($c['pendiente_id']);
		$bitacora_pendiente->comentarios()->save($comentario);
		$bitacora_pendiente->bit_st_id=$c['estatus_id'];
		$bitacora_pendiente->save();
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
