<?php

class PermissionsController extends BaseController {

	/**
	 * permissione Repository
	 *
	 * @var permissione
	 */
	protected $permission;

	public function __construct(Permission $permission)
	{
		$this->permission = $permission;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('permissions.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$name = isset($_POST['name']) ? strval($_POST['name']) : 0;
		$value = isset($_POST['value']) ? strval($_POST['value']) : 0;
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->permission->Value($value)->Name($name)->Id($id)->withTrashed()->count();

		$model=$this->permission
				->select('id', 'name', 'value', 'description', 'deleted_at')
				->Value($value)->Name($name)->Id($id)
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
		return View::make('permissions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, permission::$rules_store, permission::$rulesMessages);

		if ($validation->passes())
		{
			$this->permission->create($input);

			return Redirect::route('permission.index');
		}

		return Redirect::route('permission.create')
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
		$permission = $this->permission->findOrFail($id);

		return View::make('permissions.show', compact('permission'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$permission = $this->permission->find($id);

		if (is_null($permission))
		{
			return Redirect::route('permission.index');
		}

		return View::make('permissions.edit', compact('permission'));
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
		$validation = Validator::make($input, permission::$rules_store, permission::$rulesMessages);

		if ($validation->passes())
		{
			$permission = $this->permission->find($id);

			$permission->update($input);

			return Redirect::route('permission.show', $id);
		}

		return Redirect::route('permission.edit', $id)
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
		if ($this->permission->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->permission->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
