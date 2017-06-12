<?php

class Bit_doc_accidentesController extends BaseController {

	/**
	 * Bit_doc_accidente Repository
	 *
	 * @var Bit_doc_accidente
	 */
	protected $bit_doc_accidente;

	public function __construct(Bit_doc_accidente $bit_doc_accidente)
	{
		$this->bit_doc_accidente = $bit_doc_accidente;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('bit_doc_accidentes.index');
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

		$count_rows=$this->bit_doc_accidente->id($id)->count();

		$model=$this->bit_doc_accidente
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
		return View::make('bit_doc_accidentes.create');
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
		$validation = Validator::make($input, Bit_doc_accidente::$rules, Bit_doc_accidente::$rulesMessages);

		if ($validation->passes())
		{
			$this->bit_doc_accidente->create($input);

			return Redirect::route('bit_doc_accidente.index');
		}

		return Redirect::route('bit_doc_accidente.create')
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
		$bit_doc_accidente = $this->bit_doc_accidente->findOrFail($id);

		return View::make('bit_doc_accidentes.show', compact('bit_doc_accidente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bit_doc_accidente = $this->bit_doc_accidente->find($id);

		if (is_null($bit_doc_accidente))
		{
			return Redirect::route('bit_doc_accidentes.index');
		}

		return View::make('bit_doc_accidentes.edit', compact('bit_doc_accidente'));
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
		$validation = Validator::make($input, Bit_doc_accidente::$rules, Bit_doc_accidente::$rulesMessages);

		if ($validation->passes())
		{
			$bit_doc_accidente = $this->bit_doc_accidente->find($id);
			$bit_doc_accidente->update($input);

			return Redirect::route('bit_doc_accidente.show', $id);
		}

		return Redirect::route('bit_doc_accidente.edit', $id)
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
		$r=$this->bit_doc_accidente->find($id);
		if ($r->delete()){
			return Redirect::route('bitacora_accidente.edit', $r->bitacora_accidente_id)
			->withInput()
			->with('message', 'There were validation errors.');
			//echo json_encode(array('success'=>true));
		}else{
			return Redirect::route('bitacora_accidente.edit', $r->bitacora_accidente_id)
			->withInput()
			->with('message', 'There were validation errors.');
			//echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->bit_doc_accidente->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
