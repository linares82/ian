<?php

class Ln_dossiersController extends BaseController {

	/**
	 * Ln_dossier Repository
	 *
	 * @var Ln_dossier
	 */
	protected $ln_dossier;

	public function __construct(Ln_dossier $ln_dossier)
	{
		$this->ln_dossier = $ln_dossier;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('ln_dossiers.index');
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

		$count_rows=$this->ln_dossier->id($id)->withTrashed()->count();

		$model=$this->ln_dossier
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
		return View::make('ln_dossiers.create');
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
		$validation = Validator::make($input, Ln_dossier::$rules, Ln_dossier::$rulesMessages);

		if ($validation->passes())
		{
			$this->ln_dossier->create($input);

			return Redirect::route('ln_dossier.index');
		}

		return Redirect::route('ln_dossier.create')
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
		$ln_dossier = $this->ln_dossier->findOrFail($id);

		return View::make('ln_dossiers.show', compact('ln_dossier'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ln_dossier = $this->ln_dossier->find($id);

		if (is_null($ln_dossier))
		{
			return Redirect::route('ln_dossiers.index');
		}

		return View::make('ln_dossiers.edit', compact('ln_dossier'));
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
		$validation = Validator::make($input, Ln_dossier::$rules, Ln_dossier::$rulesMessages);

		if ($validation->passes())
		{
			$ln_dossier = $this->ln_dossier->find($id);
			$ln_dossier->update($input);

			return Redirect::route('ln_dossier.show', $id);
		}

		return Redirect::route('ln_dossier.edit', $id)
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
		if ($this->ln_dossier->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ln_dossier->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
