<?php

class EntidadesController extends BaseController {

	/**
	 * Entidade Repository
	 *
	 * @var Entidade
	 */
	protected $entidad;

	public function __construct(Entidad $entidad)
	{
		$this->entidad = $entidad;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('entidades.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$razon = isset($_POST['razon']) ? strval($_POST['razon']) : 0;
		$responsable = isset($_POST['responsable']) ? strval($_POST['responsable']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->entidad->id($id)->withTrashed()->count();

		$model=$this->entidad
				->select('id', 'rzon_social', 'abreviatura', 'responsable', 'rfc', 'dir1', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Razon($razon)->Responsable($responsable)
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
		return View::make('entidades.create');
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
		$validation = Validator::make($input, Entidad::$rules_store, Entidad::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('logo')){
				$input['logo']=Input::file('logo')->getClientOriginalName();	

			}
			if(!Input::hasFile('logo')){
				$input['logo']=$entidad->logo;	
			}

			if ($this->entidad->create($input)){
				if(Input::hasFile('logo')){
					Input::file('logo')->move(public_path().'/uploads/cias', Input::file('logo')->getClientOriginalName());
				}
			}

			return Redirect::route('entidad.index');
		}

		return Redirect::route('entidad.create')
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
		$entidad = $this->entidad->findOrFail($id);

		return View::make('entidades.show', compact('entidad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$entidad = $this->entidad->find($id);

		if (is_null($entidad))
		{
			return Redirect::route('entidad.index');
		}

		return View::make('entidades.edit', compact('entidad'));
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
		$validation = Validator::make($input, Entidad::$rules_update, Entidad::$rulesMessages);

		if ($validation->passes())
		{

			if(Input::hasFile('logo')){
				$input['logo']=Input::file('logo')->getClientOriginalName();	

			}
			
			$entidad = $this->entidad->find($id);

			if(!Input::hasFile('logo')){
				$input['logo']=$entidad->logo;	
			}

			if ($entidad->update($input)){
				if(Input::hasFile('logo')){
					Input::file('logo')->move(public_path().'/uploads/cias', Input::file('logo')->getClientOriginalName());
				}
			}

			return Redirect::route('entidad.show', $id);
		}

		return Redirect::route('entidad.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->entidad->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->entidad->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
