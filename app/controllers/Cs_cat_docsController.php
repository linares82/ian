<?php

class Cs_cat_docsController extends BaseController {

	/**
	 * Cs_cat_doc Repository
	 *
	 * @var Cs_cat_doc
	 */
	protected $cs_cat_doc;

	public function __construct(Cs_cat_doc $cs_cat_doc)
	{
		$this->cs_cat_doc = $cs_cat_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('cs_cat_docs.index');
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

		$count_rows=$this->cs_cat_doc->id($id)->withTrashed()->count();

		$model=$this->cs_cat_doc
				->select('id', 'cat_doc', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('cs_cat_docs.create');
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
		$validation = Validator::make($input, Cs_cat_doc::$rules, Cs_cat_doc::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_cat_doc->create($input);

			return Redirect::route('cs_cat_doc.index');
		}

		return Redirect::route('cs_cat_doc.create')
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
		$cs_cat_doc = $this->cs_cat_doc->findOrFail($id);

		return View::make('cs_cat_docs.show', compact('cs_cat_doc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_cat_doc = $this->cs_cat_doc->find($id);

		if (is_null($cs_cat_doc))
		{
			return Redirect::route('cs_cat_docs.index');
		}

		return View::make('cs_cat_docs.edit', compact('cs_cat_doc'));
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
		$validation = Validator::make($input, Cs_cat_doc::$rules, Cs_cat_doc::$rulesMessages);

		if ($validation->passes())
		{
			$cs_cat_doc = $this->cs_cat_doc->find($id);
			$cs_cat_doc->update($input);

			return Redirect::route('cs_cat_doc.show', $id);
		}

		return Redirect::route('cs_cat_doc.edit', $id)
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
		if ($this->cs_cat_doc->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_cat_doc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
