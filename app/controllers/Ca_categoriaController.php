<?php

class Ca_categoriaController extends BaseController {

	/**
	 * Ca_categorium Repository
	 *
	 * @var Ca_categorium
	 */
	protected $ca_categorium;

	public function __construct(Ca_categorium $ca_categorium)
	{
		$this->ca_categorium = $ca_categorium;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		return View::make('ca_categoria.index', array('materiales_ls'=>$materiales_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->ca_categorium->id($id)->withTrashed()->count();

		$model=$this->ca_categorium
				->select('ca_categoria.id', 'm.material', 'ca_categoria.categoria', 
					'ca_categoria.created_at', 'ca_categoria.updated_at', 
					'ca_categoria.deleted_at')
				->Join('ca_materiales as m', 'm.id', '=', 'ca_categoria.material_id')
				->Id($id)
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
		return View::make('ca_categoria.create', array('materiales_ls'=>$materiales_ls));
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
		$validation = Validator::make($input, Ca_categorium::$rules, Ca_categorium::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_categorium->create($input);

			return Redirect::route('ca_categoria.index');
		}

		return Redirect::route('ca_categoria.create')
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
		$ca_categorium = $this->ca_categorium->findOrFail($id);

		return View::make('ca_categoria.show', compact('ca_categorium'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_categorium = $this->ca_categorium->find($id);

		if (is_null($ca_categorium))
		{
			return Redirect::route('ca_categoria.index');
		}
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		return View::make('ca_categoria.edit', array('ca_categorium'=>$ca_categorium, 'materiales_ls'=>$materiales_ls));
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
		$validation = Validator::make($input, Ca_categorium::$rules, Ca_categorium::$rulesMessages);

		if ($validation->passes())
		{
			$ca_categorium = $this->ca_categorium->find($id);
			$ca_categorium->update($input);

			return Redirect::route('ca_categoria.show', $id);
		}

		return Redirect::route('ca_categoria.edit', $id)
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
		if ($this->ca_categorium->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_categorium->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
