<?php

class A_rr_amb_docsController extends BaseController {

	/**
	 * A_rr_amb_doc Repository
	 *
	 * @var A_rr_amb_doc
	 */
	protected $a_rr_amb_doc;

	public function __construct(A_rr_amb_doc $a_rr_amb_doc)
	{
		$this->a_rr_amb_doc = $a_rr_amb_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('a_rr_amb_docs.index');
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

		$count_rows=$this->a_rr_amb_doc->id($id)->count();

		$model=$this->a_rr_amb_doc
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
		return View::make('a_rr_amb_docs.create');
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
		$validation = Validator::make($input, A_rr_amb_doc::$rules, A_rr_amb_doc::$rulesMessages);

		if ($validation->passes())
		{
			$this->a_rr_amb_doc->create($input);

			return Redirect::route('a_rr_amb_doc.index');
		}

		return Redirect::route('a_rr_amb_doc.create')
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
		$a_rr_amb_doc = $this->a_rr_amb_doc->findOrFail($id);

		return View::make('a_rr_amb_docs.show', compact('a_rr_amb_doc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$a_rr_amb_doc = $this->a_rr_amb_doc->find($id);

		if (is_null($a_rr_amb_doc))
		{
			return Redirect::route('a_rr_amb_docs.index');
		}

		return View::make('a_rr_amb_docs.edit', compact('a_rr_amb_doc'));
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
		$validation = Validator::make($input, A_rr_amb_doc::$rules, A_rr_amb_doc::$rulesMessages);

		if ($validation->passes())
		{
			$a_rr_amb_doc = $this->a_rr_amb_doc->find($id);
			$a_rr_amb_doc->update($input);

			return Redirect::route('a_rr_amb_doc.show', $id);
		}

		return Redirect::route('a_rr_amb_doc.edit', $id)
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
		/*if ($this->a_rr_amb_doc->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}*/
                $r=$this->a_rr_amb_doc->find($id);
		if ($r->delete()){
			return Redirect::route('a_rr_ambientale.edit', $r->a_rr_ambiental_id)
			->withInput()
			->with('message', 'There were validation errors.');
			//echo json_encode(array('success'=>true));
		}else{
			return Redirect::route('a_rr_ambientale.edit', $r->a_rr_ambiental_id)
			->withInput()
			->with('message', 'There were validation errors.');
			//echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->a_rr_amb_doc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
