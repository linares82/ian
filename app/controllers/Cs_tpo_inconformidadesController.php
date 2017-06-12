<?php

class Cs_tpo_inconformidadesController extends BaseController {

	/**
	 * Cs_tpo_inconformidade Repository
	 *
	 * @var Cs_tpo_inconformidade
	 */
	protected $cs_tpo_inconformidade;

	public function __construct(Cs_tpo_inconformidade $cs_tpo_inconformidade)
	{
		$this->cs_tpo_inconformidade = $cs_tpo_inconformidade;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Cs_tpo_bitacora::lists('tpo_bitacora','id');
		return View::make('cs_tpo_inconformidades.index', array('tpo_bitacoras_ls'=>$tpo_bitacoras_ls));
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

		$count_rows=$this->cs_tpo_inconformidade->id($id)->withTrashed()->count();

		$model=$this->cs_tpo_inconformidade
				->select('cs_tpo_inconformidades.id', 'tb.tpo_bitacora','cs_tpo_inconformidades.tpo_inconformidad', 
					'cs_tpo_inconformidades.created_at', 'cs_tpo_inconformidades.updated_at', 'cs_tpo_inconformidades.deleted_at')
				->Join('cs_tpo_bitacoras as tb', 'tb.id', '=', 'cs_tpo_inconformidades.tpo_bitacora_id')
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
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Cs_tpo_bitacora::lists('tpo_bitacora','id');
		return View::make('cs_tpo_inconformidades.create', array('tpo_bitacoras_ls'=>$tpo_bitacoras_ls));
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
		$validation = Validator::make($input, Cs_tpo_inconformidade::$rules, Cs_tpo_inconformidade::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_tpo_inconformidade->create($input);

			return Redirect::route('cs_tpo_inconformidade.index');
		}

		return Redirect::route('cs_tpo_inconformidade.create')
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
		$cs_tpo_inconformidade = $this->cs_tpo_inconformidade->findOrFail($id);

		return View::make('cs_tpo_inconformidades.show', compact('cs_tpo_inconformidade'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_tpo_inconformidade = $this->cs_tpo_inconformidade->find($id);

		if (is_null($cs_tpo_inconformidade))
		{
			return Redirect::route('cs_tpo_inconformidades.index');
		}
		$tpo_bitacoras_ls=['0' => 'Seleccionar'] + Cs_tpo_bitacora::lists('tpo_bitacora','id');
		return View::make('cs_tpo_inconformidades.edit', array('cs_tpo_inconformidade'=>$cs_tpo_inconformidade, 'tpo_bitacoras_ls'=>$tpo_bitacoras_ls));
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
		$validation = Validator::make($input, Cs_tpo_inconformidade::$rules, Cs_tpo_inconformidade::$rulesMessages);

		if ($validation->passes())
		{
			$cs_tpo_inconformidade = $this->cs_tpo_inconformidade->find($id);
			$cs_tpo_inconformidade->update($input);

			return Redirect::route('cs_tpo_inconformidade.show', $id);
		}

		return Redirect::route('cs_tpo_inconformidade.edit', $id)
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
		if ($this->cs_tpo_inconformidade->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_tpo_inconformidade->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
