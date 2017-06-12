<?php

class P_correo_bitacorasController extends BaseController {

	/**
	 * P_correo_bitacora Repository
	 *
	 * @var P_correo_bitacora
	 */
	protected $p_correo_bitacora;

	public function __construct(P_correo_bitacora $p_correo_bitacora)
	{
		$this->p_correo_bitacora = $p_correo_bitacora;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd','id');
		$bitacoras_ls=['0' => 'Seleccionar'] + Bitacora::lists('bitacora','id');
		$empleados_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('p_correo_bitacoras.index', compact(['bnds_ls', 'bitacoras_ls', 'empleados_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->Entidad->id;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->p_correo_bitacora->id($id)->Cia($cia)->count();

		$model=$this->p_correo_bitacora
				->select('p_correo_bitacoras.id', 'envio.bnd as bnd_enviar', 'b.bitacora', 'e.nombre', 
					'jefe.bnd as bnd_jefe', 'dias_plazo', 'ent.abreviatura',
					'p_correo_bitacoras.created_at', 'p_correo_bitacoras.updated_at', 
					'p_correo_bitacoras.deleted_at')
				->join('bnds as envio', 'envio.id', '=', 'p_correo_bitacoras.bnd_enviar')
				->join('bitacoras as b', 'b.id', '=', 'p_correo_bitacoras.bitacora_id')
				->join('empleados as e', 'e.id', '=', 'p_correo_bitacoras.empleado_id')
				->join('bnds as jefe', 'jefe.id', '=', 'p_correo_bitacoras.bnd_jefe')
				->join('entidades as ent', 'ent.id', '=', 'p_correo_bitacoras.cia_id')
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
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd','id');
		$bitacoras_ls=['0' => 'Seleccionar'] + Bitacora::lists('bitacora','id');
		$empleados_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('p_correo_bitacoras.create', compact(['bnds_ls', 'bitacoras_ls', 'empleados_ls']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, P_correo_bitacora::$rules, P_correo_bitacora::$rulesMessages);

		if ($validation->passes())
		{
			$this->p_correo_bitacora->create($input);

			return Redirect::route('p_correo_bitacora.index');
		}

		return Redirect::route('p_correo_bitacora.create')
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
		$p_correo_bitacora = $this->p_correo_bitacora->findOrFail($id);

		return View::make('p_correo_bitacoras.show', compact('p_correo_bitacora'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$p_correo_bitacora = $this->p_correo_bitacora->find($id);

		if (is_null($p_correo_bitacora))
		{
			return Redirect::route('p_correo_bitacoras.index');
		}
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1','2'))->lists('bnd','id');
		$bitacoras_ls=['0' => 'Seleccionar'] + Bitacora::lists('bitacora','id');
		$empleados_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		return View::make('p_correo_bitacoras.edit', compact(['p_correo_bitacora', 'bnds_ls', 'bitacoras_ls', 'empleados_ls']));
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
		$validation = Validator::make($input, P_correo_bitacora::$rules, P_correo_bitacora::$rulesMessages);

		if ($validation->passes())
		{
			$p_correo_bitacora = $this->p_correo_bitacora->find($id);
			$p_correo_bitacora->update($input);

			return Redirect::route('p_correo_bitacora.show', $id);
		}

		return Redirect::route('p_correo_bitacora.edit', $id)
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
		if ($this->p_correo_bitacora->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->p_correo_bitacora->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
