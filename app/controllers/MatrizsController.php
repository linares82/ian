<?php

class MatrizsController extends BaseController {

	/**
	 * Matriz Repository
	 *
	 * @var Matriz
	 */
	protected $matriz;

	public function __construct(Matriz $matriz)
	{
		$this->matriz = $matriz;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipo_impacto_ls=['0' => 'Seleccionar'] + Tipo_impacto::lists('tipo_impacto','id');
		$factor_ls=['0' => 'Seleccionar'] + Factor::lists('factor','id');
		$rubro_ls=['0' => 'Seleccionar'] + Rubro::lists('rubro','id');
		$especifico_ls=['0' => 'Seleccionar'] + Especifico::lists('especifico','id');
		return View::make('matrizs.index', array('factor_ls'=>$factor_ls, 'rubro_ls'=>$rubro_ls, 
												  'especifico_ls'=>$especifico_ls, 'tipo_impacto_ls'=>$tipo_impacto_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$tipo_impacto = isset($_POST['tipo_impacto_id']) ? intval($_POST['tipo_impacto_id']) : 0;
		$factor = isset($_POST['factor_id']) ? intval($_POST['factor_id']) : 0;
		$especifico = isset($_POST['especifico_id']) ? intval($_POST['especifico_id']) : 0;
		$rubro = isset($_POST['rubro_id']) ? intval($_POST['rubro_id']) : 0;

		Log::info("Linares");
		Log::info($_POST);

		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->matriz->id($id)
				->TipoImpacto($tipo_impacto)->Factor($factor)->Rubro($rubro)
				->Especifico($especifico)
				->withTrashed()->count();

		$model=$this->matriz
				->join('tipo_impactos as ti', 'ti.id', '=', 'matrizs.tipo_impacto_id')
				->join('factors as f', 'f.id', '=', 'matrizs.factor_id')
				->join('rubros as r', 'r.id', '=', 'matrizs.rubro_id')
				->join('especificos as e', 'e.id', '=', 'matrizs.especifico_id')
				->select('matrizs.id', 'ti.tipo_impacto', 'f.factor', 'r.rubro', 'e.especifico', 'matrizs.created_at', 'matrizs.updated_at', 'matrizs.deleted_at')
				->Id($id)->TipoImpacto($tipo_impacto)->Factor($factor)->Rubro($rubro)->Especifico($especifico)
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
		$tipo_impacto_ls=['0' => 'Seleccionar'] + Tipo_impacto::lists('tipo_impacto','id');
		$factor_ls=['0' => 'Seleccionar'] + Factor::lists('factor','id');
		$rubro_ls=['0' => 'Seleccionar'] + Rubro::lists('rubro','id');
		$especifico_ls=['0' => 'Seleccionar'] + Especifico::lists('especifico','id');
		$caracteristicas_ls=Caracteristica::lists('caracteristica','id');
		return View::make('matrizs.create', array('factor_ls'=>$factor_ls, 'rubro_ls'=>$rubro_ls, 'tipo_impacto_ls'=>$tipo_impacto_ls, 
												  'especifico_ls'=>$especifico_ls, 'caracteristicas_ls'=>$caracteristicas_ls));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = array();
		$input['tipo_impacto_id']=Input::get('tipo_impacto_id');
		$input['factor_id']=Input::get('factor_id');
		$input['rubro_id']=Input::get('rubro_id');
		$input['especifico_id']=Input::get('especifico_id');
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;

		$caracteristicas=Input::get('caracteristicas');

		$validation = Validator::make($input, Matriz::$rules, Matriz::$rulesMessages);

		if ($validation->passes())
		{
			$m_matriz=$this->matriz->create($input);
			if(isset($caracteristicas) and is_array($caracteristicas)){
				foreach($caracteristicas as $caracteristica){
						$m_matriz->caracteristicas()->attach($caracteristica);
				}
			}

			return Redirect::route('matriz.index');
		}

		return Redirect::route('matriz.create')
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
		$matriz = $this->matriz->findOrFail($id);

		return View::make('matrizs.show', compact('matriz'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$matriz = $this->matriz->find($id);
		if (is_null($matriz))
		{
			return Redirect::route('matrizs.index');
		}

		$caracteristicas=$matriz->caracteristicas;
		$caracteristicas_seleccionadas=array();
		foreach($caracteristicas as $caracteristica){
			array_push($caracteristicas_seleccionadas, $caracteristica->id);
		}

		$tipo_impacto_ls=['0' => 'Seleccionar'] + Tipo_impacto::lists('tipo_impacto','id');
		$factor_ls=['0' => 'Seleccionar'] + Factor::lists('factor','id');
		$rubro_ls=['0' => 'Seleccionar'] + Rubro::lists('rubro','id');
		$especifico_ls=['0' => 'Seleccionar'] + Especifico::lists('especifico','id');
		$caracteristicas_ls=Caracteristica::lists('caracteristica','id');

		return View::make('matrizs.edit', array('factor_ls'=>$factor_ls, 'rubro_ls'=>$rubro_ls, 'tipo_impacto_ls'=>$tipo_impacto_ls,
											'especifico_ls'=>$especifico_ls, 'caracteristicas_ls'=>$caracteristicas_ls,
											'caracteristicas_seleccionadas'=>$caracteristicas_seleccionadas,'matriz'=>$matriz));
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

		$m_matriz=array();
		$m_matriz['usu_alta_id']=Sentry::getUser()->id;
		$m_matriz['usu_mod_id']=Sentry::getUser()->id;
		$m_matriz['tipo_impacto_id']=Input::get('tipo_impacto_id');
		$m_matriz['factor_id']=Input::get('factor_id');
		$m_matriz['rubro_id']=Input::get('rubro_id');
		$m_matriz['especifico_id']=Input::get('especifico_id');

		$validation = Validator::make($m_matriz, Matriz::$rules, Matriz::$rulesMessages);

		if ($validation->passes())
		{
			$matriz = $this->matriz->find($id);

			if ($matriz->update($m_matriz)){
				$db_cs=$matriz->caracteristicas->toArray();
				$sc_cs=Input::get('caracteristicas');
				foreach($db_cs as $db_c){
					if(!in_array($db_c['id'], $sc_cs)){
						$matriz->caracteristicas()->detach($db_c['id']);
					}
				}
				if(isset($sc_cs) and is_array($sc_cs)){
					foreach($sc_cs as $sc_c){
						$existe=false;
						foreach($db_cs as $db_c){
							if($db_c['id']==$sc_c){
								$existe=true;
							}
						}
						if(!$existe){
							$matriz->caracteristicas()->attach($sc_c);
						}
					}
				}

			}

			return Redirect::route('matriz.show', $id);
		}

		return Redirect::route('matriz.edit', $id)
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
		if ($this->matriz->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->matriz->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
