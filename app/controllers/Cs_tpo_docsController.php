<?php

class Cs_tpo_docsController extends BaseController {

	/**
	 * Cs_tpo_doc Repository
	 *
	 * @var Cs_tpo_doc
	 */
	protected $cs_tpo_doc;

	public function __construct(Cs_tpo_doc $cs_tpo_doc)
	{
		$this->cs_tpo_doc = $cs_tpo_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tpo_procedimientos_ls=['0' => 'Seleccionar'] + Cs_tpo_procedimiento::lists('tpo_procedimiento','id');
		return View::make('cs_tpo_docs.index', array('tpo_procedimientos_ls'=>$tpo_procedimientos_ls));
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

		$count_rows=$this->cs_tpo_doc->id($id)->withTrashed()->count();

		$model=$this->cs_tpo_doc
				->select('cs_tpo_docs.id', 'p.tpo_procedimiento','cs_tpo_docs.tpo_doc', 
					'cs_tpo_docs.created_at', 'cs_tpo_docs.updated_at', 'cs_tpo_docs.deleted_at')
				->Join('cs_tpo_procedimientos as p', 'p.id', '=', 'cs_tpo_docs.tpo_procedimiento_id')
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
		$tpo_procedimientos_ls=['0' => 'Seleccionar'] + Cs_tpo_procedimiento::lists('tpo_procedimiento','id');
		return View::make('cs_tpo_docs.create', array('tpo_procedimientos_ls'=>$tpo_procedimientos_ls));
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
		$validation = Validator::make($input, Cs_tpo_doc::$rules, Cs_tpo_doc::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_tpo_doc->create($input);

			return Redirect::route('cs_tpo_doc.index');
		}

		return Redirect::route('cs_tpo_doc.create')
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
		$cs_tpo_doc = $this->cs_tpo_doc->findOrFail($id);

		return View::make('cs_tpo_docs.show', compact('cs_tpo_doc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_tpo_doc = $this->cs_tpo_doc->find($id);

		if (is_null($cs_tpo_doc))
		{
			return Redirect::route('cs_tpo_docs.index');
		}
		$tpo_procedimientos_ls=['0' => 'Seleccionar'] + Cs_tpo_procedimiento::lists('tpo_procedimiento','id');
		return View::make('cs_tpo_docs.edit', array('cs_tpo_doc'=>$cs_tpo_doc, 'tpo_procedimientos_ls'=>$tpo_procedimientos_ls));
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
		$validation = Validator::make($input, Cs_tpo_doc::$rules, Cs_tpo_doc::$rulesMessages);

		if ($validation->passes())
		{
			$cs_tpo_doc = $this->cs_tpo_doc->find($id);
			$cs_tpo_doc->update($input);

			return Redirect::route('cs_tpo_doc.show', $id);
		}

		return Redirect::route('cs_tpo_doc.edit', $id)
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
		if ($this->cs_tpo_doc->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_tpo_doc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
