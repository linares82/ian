<?php

class Bitacora_consumiblesController extends BaseController {

	/**
	 * Bitacora_consumible Repository
	 *
	 * @var Bitacora_consumible
	 */
	protected $bitacora_consumible;

	public function __construct(Bitacora_consumible $bitacora_consumible)
	{
		$this->bitacora_consumible = $bitacora_consumible;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$consumibles_ls=['0' => 'Seleccionar'] + Ca_consumible::lists('consumible','id');
		return View::make('bitacora_consumibles.index', array('consumibles_ls'=>$consumibles_ls));
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

		$count_rows=$this->bitacora_consumible->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->bitacora_consumible
				->select('bitacora_consumibles.id', 'c.consumible', 'bitacora_consumibles.consumo', 'bitacora_consumibles.fecha', 'c.unidad',  
					DB::raw('datediff(CURDATE(), bitacora_consumibles.fecha) as ultima_captura'), 
					'bitacora_consumibles.created_at', 'bitacora_consumibles.updated_at', 'bitacora_consumibles.deleted_at')
				->join('ca_consumibles as c', 'c.id', '=', 'bitacora_consumibles.consumible_id')
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
		$consumibles_ls=['0' => 'Seleccionar'] + Ca_consumible::lists('consumible','id');
		return View::make('bitacora_consumibles.create',array('consumibles_ls'=>$consumibles_ls));
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
		$validation = Validator::make($input, Bitacora_consumible::$rules, Bitacora_consumible::$rulesMessages);

		if ($validation->passes())
		{
			$input['factor_calculado']=$input['consumo']/$input['factor_indicador'];
			$this->bitacora_consumible->create($input);

			return Redirect::route('bitacora_consumible.index');
		}

		return Redirect::route('bitacora_consumible.create')
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
		$bitacora_consumible = $this->bitacora_consumible->findOrFail($id);

		return View::make('bitacora_consumibles.show', compact('bitacora_consumible'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bitacora_consumible = $this->bitacora_consumible->find($id);

		if (is_null($bitacora_consumible))
		{
			return Redirect::route('bitacora_consumibles.index');
		}
		$consumibles_ls=['0' => 'Seleccionar'] + Ca_consumible::lists('consumible','id');
		return View::make('bitacora_consumibles.edit', array('bitacora_consumible'=>$bitacora_consumible, 'consumibles_ls'=>$consumibles_ls));
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
		$input['anio']=date('Y', strtotime(Input::get('fecha')));;
		$input['mes']=date('m', strtotime(Input::get('fecha')));
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Bitacora_consumible::$rules, Bitacora_consumible::$rulesMessages);

		if ($validation->passes())
		{
			$input['factor_calculado']=$input['consumo']/$input['factor_indicador'];
			$bitacora_consumible = $this->bitacora_consumible->find($id);
			$bitacora_consumible->update($input);

			return Redirect::route('bitacora_consumible.show', $id);
		}

		return Redirect::route('bitacora_consumible.edit', $id)
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
		if ($this->bitacora_consumible->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bitacora_consumible->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
