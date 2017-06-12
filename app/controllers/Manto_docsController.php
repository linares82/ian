<?php

class Manto_docsController extends BaseController {

	/**
	 * Manto_doc Repository
	 *
	 * @var Manto_doc
	 */
	protected $manto_doc;

	public function __construct(Manto_doc $manto_doc)
	{
		$this->manto_doc = $manto_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('manto_docs.index');
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

		$count_rows=$this->manto_doc->id($id)->count();

		$model=$this->manto_doc
				->select('id', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('manto_docs.create');
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
		$validation = Validator::make($input, Manto_doc::$rules, Manto_doc::$rulesMessages);

		if ($validation->passes())
		{
			$this->manto_doc->create($input);

			return Redirect::route('manto_doc.index');
		}

		return Redirect::route('manto_doc.create')
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
		$manto_doc = $this->manto_doc->findOrFail($id);

		return View::make('manto_docs.show', compact('manto_doc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$manto_doc = $this->manto_doc->find($id);

		if (is_null($manto_doc))
		{
			return Redirect::route('manto_docs.index');
		}

		return View::make('manto_docs.edit', compact('manto_doc'));
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
		$validation = Validator::make($input, Manto_doc::$rules, Manto_doc::$rulesMessages);

		if ($validation->passes())
		{
			$manto_doc = $this->manto_doc->find($id);
			$manto_doc->update($input);

			return Redirect::route('manto_doc.show', $id);
		}

		return Redirect::route('manto_doc.edit', $id)
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
		$r=$this->manto_doc->find($id);
		if ($r->delete()){
			return Redirect::route('m_mantenimiento.edit', $r->mantenimiento_id)
			->withInput()
			->with('message', 'There were validation errors.');
			//echo json_encode(array('success'=>true));
		}else{
			return Redirect::route('m_mantenimiento.edit', $r->mantenimiento_id)
			->withInput()
			->with('message', 'There were validation errors.');
			//echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->manto_doc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
