<?php

class Aspectos_ambientalesController extends BaseController {

	/**
	 * Aspectos_ambientale Repository
	 *
	 * @var Aspectos_ambientale
	 */
	protected $aspectos_ambientale;

	public function __construct(Aspectos_ambientale $aspectos_ambientale)
	{
		$this->aspectos_ambientale = $aspectos_ambientale;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$procesos_ls=['0' => 'Seleccionar'] + Aa_proceso::lists('proceso','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$aspectos_ls=['0' => 'Seleccionar'] + Aa_aspecto::lists('aspectos','id');
		$emes_ls=['0' => 'Seleccionar'] + Aa_eme::lists('eme','id');
		$condiciones_ls=['0' => 'Seleccionar'] + Aa_condicione::lists('condicion','id');
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$severidades_ls=['0' => 'Seleccionar'] + Efecto::lists('descripcion','id');
		$frecuencias_ls=['0' => 'Seleccionar'] + Duracion_accion::lists('duracion_accion','id');
		$probabilidades_ls=['0' => 'Seleccionar'] + Probabilidad::lists('probabilidad','id');
		return View::make('aspectos_ambientales.index', 
					compact(['procesos_ls', 'areas_ls', 'aspectos_ls', 'emes_ls', 'condiciones_ls',
							'impactos_ls', 'bnds_ls', 'severidades_ls', 'frecuencias_ls', 'probabilidades_ls']));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->Entidad->id;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->aspectos_ambientale->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->aspectos_ambientale
				->select('aspectos_ambientales.id', 'p.proceso', 'a.area', 'aspectos_ambientales.actividad', 
						'aspectos_ambientales.descripcion', 'ir.imp_real', 'ip.imp_potencial', 
						'aspectos_ambientales.created_at', 'aspectos_ambientales.updated_at', 
						'aspectos_ambientales.deleted_at')
				->join('aa_procesos as p', 'p.id', '=', 'aspectos_ambientales.proceso_id')
				->join('areas as a', 'a.id', '=', 'aspectos_ambientales.area_id')
				->join('imp_reals as ir', 'ir.id', '=', 'aspectos_ambientales.imp_real_id')
				->join('imp_potencials as ip', 'ip.id', '=', 'aspectos_ambientales.imp_potencial_id')
				->Id($id)->Cia($cia)
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
		$procesos_ls=['0' => 'Seleccionar'] + Aa_proceso::lists('proceso','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$aspectos_ls=['0' => 'Seleccionar'] + Aa_aspecto::lists('aspectos','id');
		$emes_ls=['0' => 'Seleccionar'] + Aa_eme::lists('eme','id');
		$condiciones_ls=['0' => 'Seleccionar'] + Aa_condicione::lists('condicion','id');
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$severidades_ls=['0' => 'Seleccionar'] + Efecto::lists('descripcion','id');
		$frecuencias_ls=['0' => 'Seleccionar'] + Duracion_accion::lists('duracion_accion','id');
		$probabilidades_ls=['0' => 'Seleccionar'] + Probabilidad::lists('probabilidad','id');
		return View::make('aspectos_ambientales.create', compact(['procesos_ls', 'areas_ls', 'aspectos_ls', 'emes_ls', 'condiciones_ls',
							'impactos_ls', 'bnds_ls', 'severidades_ls', 'frecuencias_ls', 'probabilidades_ls']));
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
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, Aspectos_ambientale::$rules, Aspectos_ambientale::$rulesMessages);

		if ($validation->passes())
		{
			$imp_real=DB::Table('m_imp_reals as m')
							->where('m.efecto_id', $input['severidad_id'])
							->where('m.probabilidad_id',$input['probabilidad_id'])
							->pluck('m.imp_real_id');
			//dd($imp_real);
			$input['imp_real_id']=$imp_real;
			$imp_potencial=DB::Table('m_imp_potencials as m')
							->where('m.efecto_id', $input['severidad_id'])
							->where('m.duracion_accion_id',$input['frecuencia_id'])
							->pluck('m.imp_potencial_id');
			$input['imp_potencial_id']=$imp_potencial;

			$this->aspectos_ambientale->create($input);

			return Redirect::route('aspectos_ambientale.index');
		}



		return Redirect::route('aspectos_ambientale.create')
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
		$aspectos_ambientale = $this->aspectos_ambientale->findOrFail($id);

		return View::make('aspectos_ambientales.show', compact('aspectos_ambientale'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$aspectos_ambientale = $this->aspectos_ambientale->find($id);

		if (is_null($aspectos_ambientale))
		{
			return Redirect::route('aspectos_ambientales.index');
		}

		$procesos_ls=['0' => 'Seleccionar'] + Aa_proceso::lists('proceso','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$aspectos_ls=['0' => 'Seleccionar'] + Aa_aspecto::lists('aspectos','id');
		$emes_ls=['0' => 'Seleccionar'] + Aa_eme::lists('eme','id');
		$condiciones_ls=['0' => 'Seleccionar'] + Aa_condicione::lists('condicion','id');
		$impactos_ls=['0' => 'Seleccionar'] + Aa_impacto::lists('impacto','id');
		$bnds_ls=['0' => 'Seleccionar'] + Bnd::wherein('id', array('1', '2'))->lists('bnd','id');
		$severidades_ls=['0' => 'Seleccionar'] + Efecto::lists('descripcion','id');
		$frecuencias_ls=['0' => 'Seleccionar'] + Duracion_accion::lists('duracion_accion','id');
		$probabilidades_ls=['0' => 'Seleccionar'] + Probabilidad::lists('probabilidad','id');

		return View::make('aspectos_ambientales.edit',compact(['procesos_ls', 'areas_ls', 'aspectos_ls', 'emes_ls', 'condiciones_ls',
							'impactos_ls', 'bnds_ls', 'severidades_ls', 'frecuencias_ls', 'probabilidades_ls', 'aspectos_ambientale']));
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
		$validation = Validator::make($input, Aspectos_ambientale::$rules, Aspectos_ambientale::$rulesMessages);

		if ($validation->passes())
		{
			$imp_real=DB::Table('m_imp_reals as m')
							->where('m.efecto_id', $input['severidad_id'])
							->where('m.probabilidad_id',$input['probabilidad_id'])
							->pluck('m.imp_real_id');
			//dd($imp_real);
			$input['imp_real_id']=$imp_real;
			$imp_potencial=DB::Table('m_imp_potencials as m')
							->where('m.efecto_id', $input['severidad_id'])
							->where('m.duracion_accion_id',$input['frecuencia_id'])
							->pluck('m.imp_potencial_id');
			$input['imp_potencial_id']=$imp_potencial;

			$aspectos_ambientale = $this->aspectos_ambientale->find($id);
			$aspectos_ambientale->update($input);

			return Redirect::route('aspectos_ambientale.show', $id);
		}

		return Redirect::route('aspectos_ambientale.edit', $id)
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
		if ($this->aspectos_ambientale->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->aspectos_ambientale->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
