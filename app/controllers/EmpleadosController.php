<?php

class EmpleadosController extends BaseController {

	/**
	 * Empleado Repository
	 *
	 * @var Empleado
	 */
	protected $empleado;

	public function __construct(Empleado $empleado)
	{
		$this->empleado = $empleado;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$puestos_ls=['0' => 'Seleccionar'] + Puesto::lists('puesto','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$jefes_ls=['0' => 'Seleccionar'] + Empleado::wherein('bnd_subordinados', array('1'))
											->Cia(User::find(Sentry::getUser()->id)->getCia())
											->lists('nombre','id');
		return View::make('empleados.index', array('areas_ls'=>$areas_ls, 'puestos_ls'=>$puestos_ls, 
											'bnds_ls'=>$bnds_ls, 'jefes_ls'=>$jefes_ls));
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

		$count_rows=$this->empleado->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->empleado
				->select('empleados.id', 'empleados.nombre', 'a.area', 'p.puesto', 
					'empleados.created_at', 'empleados.updated_at', 'empleados.deleted_at')
				->Join('areas as a', 'a.id', '=', 'empleados.area_id')
				->Join('puestos as p', 'p.id', '=', 'empleados.puesto_id')
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
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$puestos_ls=['0' => 'Seleccionar'] + Puesto::lists('puesto','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$jefes_ls=['0' => 'Seleccionar'] + Empleado::wherein('bnd_subordinados', array('1'))
											->Cia(User::find(Sentry::getUser()->id)->getCia())
											->lists('nombre','id');
		return View::make('empleados.create', array('areas_ls'=>$areas_ls, 'puestos_ls'=>$puestos_ls, 
											'bnds_ls'=>$bnds_ls, 'jefes_ls'=>$jefes_ls));
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
		$validation = Validator::make($input, Empleado::$rules, Empleado::$rulesMessages);

		if ($validation->passes())
		{
			$this->empleado->create($input);

			return Redirect::route('empleado.index');
		}

		return Redirect::route('empleado.create')
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
		$empleado = $this->empleado->findOrFail($id);

		return View::make('empleados.show', compact('empleado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$empleado = $this->empleado->find($id);

		if (is_null($empleado))
		{
			return Redirect::route('empleados.index');
		}
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$puestos_ls=['0' => 'Seleccionar'] + Puesto::lists('puesto','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$jefes_ls=['0' => 'Seleccionar'] + Empleado::wherein('bnd_subordinados', array('1'))
											->Cia(User::find(Sentry::getUser()->id)->getCia())		
											->lists('nombre','id');
		return View::make('empleados.edit', array('empleado'=>$empleado,'areas_ls'=>$areas_ls, 'puestos_ls'=>$puestos_ls, 
											'bnds_ls'=>$bnds_ls, 'jefes_ls'=>$jefes_ls));
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
		$validation = Validator::make($input, Empleado::$rules, Empleado::$rulesMessages);

		if ($validation->passes())
		{
			$empleado = $this->empleado->find($id);
			$empleado->update($input);

			return Redirect::route('empleado.show', $id);
		}

		return Redirect::route('empleado.edit', $id)
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
		if ($this->empleado->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->empleado->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
