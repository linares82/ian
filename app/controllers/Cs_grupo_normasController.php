<?php

class Cs_grupo_normasController extends BaseController {

	/**
	 * Cs_grupo_norma Repository
	 *
	 * @var Cs_grupo_norma
	 */
	protected $cs_grupo_norma;

	public function __construct(Cs_grupo_norma $cs_grupo_norma)
	{
		$this->cs_grupo_norma = $cs_grupo_norma;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('cs_grupo_normas.index');
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

		$count_rows=$this->cs_grupo_norma->id($id)->withTrashed()->count();

		$model=$this->cs_grupo_norma
				->select('id', 'grupo_norma', 'created_at', 'updated_at', 'deleted_at')
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
		return View::make('cs_grupo_normas.create');
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
		$validation = Validator::make($input, Cs_grupo_norma::$rules, Cs_grupo_norma::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_grupo_norma->create($input);

			return Redirect::route('cs_grupo_norma.index');
		}

		return Redirect::route('cs_grupo_norma.create')
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
		$cs_grupo_norma = $this->cs_grupo_norma->findOrFail($id);

		return View::make('cs_grupo_normas.show', compact('cs_grupo_norma'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_grupo_norma = $this->cs_grupo_norma->find($id);

		if (is_null($cs_grupo_norma))
		{
			return Redirect::route('cs_grupo_normas.index');
		}

		return View::make('cs_grupo_normas.edit', compact('cs_grupo_norma'));
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
		$validation = Validator::make($input, Cs_grupo_norma::$rules, Cs_grupo_norma::$rulesMessages);

		if ($validation->passes())
		{
			$cs_grupo_norma = $this->cs_grupo_norma->find($id);
			$cs_grupo_norma->update($input);

			return Redirect::route('cs_grupo_norma.show', $id);
		}

		return Redirect::route('cs_grupo_norma.edit', $id)
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
		if ($this->cs_grupo_norma->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_grupo_norma->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
