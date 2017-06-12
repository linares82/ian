<?php

class R_documentosController extends BaseController {

	/**
	 * R_documento Repository
	 *
	 * @var R_documento
	 */
	protected $r_documento;

	public function __construct(R_documento $r_documento)
	{
		$this->r_documento = $r_documento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tpo_docs_ls=['0' => 'Seleccionar'] + Tpo_doc::lists('tpo_doc','id');
		return View::make('r_documentos.index', compact('tpo_docs_ls'));
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

		$count_rows=$this->r_documento->id($id)->withTrashed()->count();

		$model=$this->r_documento
				->select('r_documentos.id', 'td.tpo_doc', 'r_documentos.r_documento', 
					'r_documentos.created_at', 'r_documentos.updated_at', 'r_documentos.deleted_at')
				->join('tpo_docs as td', 'td.id', '=', 'r_documentos.tpo_documento_id')
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
		$tpo_docs_ls=['0' => 'Seleccionar'] + Tpo_doc::lists('tpo_doc','id');
		return View::make('r_documentos.create', compact('tpo_docs_ls'));
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
		$validation = Validator::make($input, R_documento::$rules, R_documento::$rulesMessages);

		if ($validation->passes())
		{
			$this->r_documento->create($input);

			return Redirect::route('r_documento.index');
		}

		return Redirect::route('r_documento.create')
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
		$r_documento = $this->r_documento->findOrFail($id);

		return View::make('r_documentos.show', compact('r_documento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$r_documento = $this->r_documento->find($id);

		if (is_null($r_documento))
		{
			return Redirect::route('r_documentos.index');
		}
		$tpo_docs_ls=['0' => 'Seleccionar'] + Tpo_doc::lists('tpo_doc','id');
		return View::make('r_documentos.edit', compact('r_documento', 'tpo_docs_ls'));
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
		$validation = Validator::make($input, R_documento::$rules, R_documento::$rulesMessages);

		if ($validation->passes())
		{
			$r_documento = $this->r_documento->find($id);
			$r_documento->update($input);

			return Redirect::route('r_documento.show', $id);
		}

		return Redirect::route('r_documento.edit', $id)
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
		if ($this->r_documento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->r_documento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
