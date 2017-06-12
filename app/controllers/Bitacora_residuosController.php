<?php

class Bitacora_residuosController extends BaseController {

	/**
	 * Bitacora_residuo Repository
	 *
	 * @var Bitacora_residuo
	 */
	protected $bitacora_residuo;

	public function __construct(Bitacora_residuo $bitacora_residuo)
	{
		$this->bitacora_residuo = $bitacora_residuo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$residuos_ls=['0' => 'Seleccionar'] + Ca_residuo::lists('residuo','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		return View::make('bitacora_residuos.index', array('residuos_ls'=>$residuos_ls, 'responsables_ls'=>$responsables_ls, 'bnds_ls'=>$bnds_ls));
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

		$count_rows=$this->bitacora_residuo->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_residuo
				->select('bitacora_residuos.id', 'r.residuo', 'bitacora_residuos.fecha', 'bitacora_residuos.cantidad', 
					DB::raw('datediff(CURDATE(), bitacora_residuos.fecha) as ultima_captura'),  
					'bitacora_residuos.created_at', 'bitacora_residuos.updated_at', 'bitacora_residuos.deleted_at')
				->join('ca_residuos as r', 'r.id', '=', 'bitacora_residuos.residuo')
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
		$residuos_ls=['0' => 'Seleccionar'] + Ca_residuo::lists('residuo','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		//print_r($bnds_ls);
		return View::make('bitacora_residuos.create',array('responsables_ls'=>$responsables_ls, 'residuos_ls'=>$residuos_ls, 'bnds_ls'=>$bnds_ls));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['anio']=date('Y', strtotime(Input::get('fecha')));;
		$input['mes']=date('m', strtotime(Input::get('fecha')));
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, Bitacora_residuo::$rules, Bitacora_residuo::$rulesMessages);

		if ($validation->passes())
		{
			$input['factor_calculado']=$input['cantidad']/$input['factor_indicador'];
			$this->bitacora_residuo->create($input);

			return Redirect::route('bitacora_residuo.index');
		}

		return Redirect::route('bitacora_residuo.create')
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
		$bitacora_residuo = $this->bitacora_residuo->findOrFail($id);

		return View::make('bitacora_residuos.show', compact('bitacora_residuo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_residuo = $this->bitacora_residuo->find($id);

		if (is_null($bitacora_residuo))
		{
			return Redirect::route('bitacora_residuos.index');
		}
		$residuos_ls=['0' => 'Seleccionar'] + Ca_residuo::lists('residuo','id');
		$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		return View::make('bitacora_residuos.edit', array('bitacora_residuo'=>$bitacora_residuo, 'residuos_ls'=>$residuos_ls, 'responsables_ls'=>$responsables_ls, 'bnds_ls'=>$bnds_ls));
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
		$input['anio']=date('Y', strtotime(Input::get('fecha')));;
		$input['mes']=date('m', strtotime(Input::get('fecha')));
		
		$validation = Validator::make($input, Bitacora_residuo::$rules, Bitacora_residuo::$rulesMessages);

		if ($validation->passes())
		{
			$input['factor_calculado']=$input['cantidad']/$input['factor_indicador'];
			$bitacora_residuo = $this->bitacora_residuo->find($id);
			$bitacora_residuo->update($input);

			return Redirect::route('bitacora_residuo.show', $id);
		}

		return Redirect::route('bitacora_residuo.edit', $id)
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
		if ($this->bitacora_residuo->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_residuo->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
