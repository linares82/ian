<?php

class Doc_proyectosController extends BaseController {

	/**
	 * Doc_proyecto Repository
	 *
	 * @var Doc_proyecto
	 */
	protected $doc_proyecto;

	public function __construct(Doc_proyecto $doc_proyecto)
	{
		$this->doc_proyecto = $doc_proyecto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('doc_proyectos.index');
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

		$count_rows=$this->doc_proyecto->id($id)->withTrashed()->count();

		$model=$this->doc_proyecto
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
		return View::make('doc_proyectos.create');
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
		$validation = Validator::make($input, Doc_proyecto::$rules, Doc_proyecto::$rulesMessages);

		if ($validation->passes())
		{
			$this->doc_proyecto->create($input);

			return Redirect::route('doc_proyecto.index');
		}

		return Redirect::route('doc_proyecto.create')
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
		$doc_proyecto = $this->doc_proyecto->findOrFail($id);

		return View::make('doc_proyectos.show', compact('doc_proyecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$doc_proyecto = $this->doc_proyecto->find($id);

		if (is_null($doc_proyecto))
		{
			return Redirect::route('doc_proyectos.index');
		}

		return View::make('doc_proyectos.edit', compact('doc_proyecto'));
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
		$validation = Validator::make($input, Doc_proyecto::$rules, Doc_proyecto::$rulesMessages);

		if ($validation->passes())
		{
			$doc_proyecto = $this->doc_proyecto->find($id);
			$doc_proyecto->update($input);

			return Redirect::route('doc_proyecto.show', $id);
		}

		return Redirect::route('doc_proyecto.edit', $id)
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
		if ($this->doc_proyecto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->doc_proyecto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
