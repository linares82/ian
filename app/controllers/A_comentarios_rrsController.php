<?php

class A_comentarios_rrsController extends BaseController {

	/**
	 * A_comentarios_rr Repository
	 *
	 * @var A_comentarios_rr
	 */
	protected $a_comentarios_rr;

	public function __construct(A_comentarios_rr $a_comentarios_rr)
	{
		$this->a_comentarios_rr = $a_comentarios_rr;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_comentarios_rrs.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$rr =isset($_REQUEST['a_rr']) ? intval($_REQUEST['a_rr']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->a_comentarios_rr->id($id)->Rr($rr)->withTrashed()->count();

		$model=$this->a_comentarios_rr
				->select('a_comentarios_rrs.id', 'a_comentarios_rrs.comentario', 'st.estatus', 'u.username', 
					'a_comentarios_rrs.created_at', 'a_comentarios_rrs.updated_at', 'a_comentarios_rrs.deleted_at')
				->join('a_st_archivos as st', 'st.id', '=', 'a_comentarios_rrs.a_st_rr_id')
				->join('users as u', 'u.id', '=', 'a_comentarios_rrs.usu_alta_id')
				->Id($id)->Rr($rr)
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
		return View::make('a_comentarios_rrs.create');
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
		$validation = Validator::make($input, A_comentarios_rr::$rules, A_comentarios_rr::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_comentarios_rr->create($input);

			return Redirect::route('a_comentarios_rr.index');
		}

		return Redirect::route('a_comentarios_rr.create')
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
		$a_comentarios_rr = $this->a_comentarios_rr->findOrFail($id);

		return View::make('a_comentarios_rrs.show', compact('a_comentarios_rr'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_comentarios_rr = $this->a_comentarios_rr->find($id);

		if (is_null($a_comentarios_rr))
		{
			return Redirect::route('a_comentarios_rrs.index');
		}

		return View::make('a_comentarios_rrs.edit', compact('a_comentarios_rr'));
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
		$validation = Validator::make($input, A_comentarios_rr::$rules, A_comentarios_rr::$rulesMessages);

		if ($validation->passes())
		{
			$a_comentarios_rr = $this->a_comentarios_rr->find($id);
			$a_comentarios_rr->update($input);

			return Redirect::route('a_comentarios_rr.show', $id);
		}

		return Redirect::route('a_comentarios_rr.edit', $id)
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
		if ($this->a_comentarios_rr->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_comentarios_rr->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
