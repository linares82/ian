<?php

class A_st_ncsController extends BaseController {

	/**
	 * A_st_nc Repository
	 *
	 * @var A_st_nc
	 */
	protected $a_st_nc;

	public function __construct(A_st_nc $a_st_nc)
	{
		$this->a_st_nc = $a_st_nc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_st_ncs.index');
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

		$count_rows=$this->a_st_nc->id($id)->withTrashed()->count();

		$model=$this->a_st_nc
				->select('', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('a_st_ncs.create');
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
		$validation = Validator::make($input, A_st_nc::$rules, A_st_nc::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_st_nc->create($input);

			return Redirect::route('a_st_nc.index');
		}

		return Redirect::route('a_st_nc.create')
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
		$a_st_nc = $this->a_st_nc->findOrFail($id);

		return View::make('a_st_ncs.show', compact('a_st_nc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_st_nc = $this->a_st_nc->find($id);

		if (is_null($a_st_nc))
		{
			return Redirect::route('a_st_ncs.index');
		}

		return View::make('a_st_ncs.edit', compact('a_st_nc'));
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
		$validation = Validator::make($input, A_st_nc::$rules, A_st_nc::$rulesMessages);

		if ($validation->passes())
		{
			$a_st_nc = $this->a_st_nc->find($id);
			$a_st_nc->update($input);

			return Redirect::route('a_st_nc.show', $id);
		}

		return Redirect::route('a_st_nc.edit', $id)
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
		if ($this->a_st_nc->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_st_nc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
