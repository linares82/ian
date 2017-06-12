<?php

class Reg_impactosController extends BaseController {

	/**
	 * Reg_impacto Repository
	 *
	 * @var Reg_impacto
	 */
	protected $reg_impacto;
	protected $enc_impacto=0;
	protected $ln_caracteristica; 

	public function __construct(Reg_impacto $reg_impacto)
	{
		$this->reg_impacto = $reg_impacto;
		$this->ln_caracteristica= new Ln_caracteristica;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->enc_impacto=$_GET['id'];
		$clientes_ls=['0' => 'Seleccionar'] + Cliente::lists('cliente','id');
		return View::make('reg_impactos.index', array('clientes_ls'=>$clientes_ls, 'id'=>$this->enc_impacto));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id_ln = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$id=isset($_REQUEST['id_enc']) ? intval($_REQUEST['id_enc']) : 0;
		$this->enc_impacto=$id;
		$created_at = isset($_POST['created_at']) ? strval($_POST['created_at']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->reg_impacto->EncImpacto($id)->CreatedAt($created_at)->count();
		//print_r($count_rows);
		if($count_rows==0){
			$this->generaLineas($id);
			$count_rows=$this->reg_impacto
				->EncImpacto($this->enc_impacto)->CreatedAt($created_at)->withTrashed()->count();
		}

		$model=$this->reg_impacto
				->join('enc_impactos as ei', 'ei.id', '=', 'reg_impactos.enc_impacto_id')
				->join('factors as f', 'f.id', '=', 'reg_impactos.factor_id')
				->join('rubros as r', 'r.id', '=', 'reg_impactos.rubro_id')
				->join('especificos as e', 'e.id', '=', 'reg_impactos.especifico_id')
				->join('st_reg_impactos as st', 'st.id', '=', 'reg_impactos.estatus_id')
				->select('reg_impactos.id', 'f.factor', 'r.rubro', 'e.especifico', 'st.st_reg_impacto','reg_impactos.created_at', 'reg_impactos.updated_at', 'reg_impactos.deleted_at')
				->EncImpacto($this->enc_impacto)->CreatedAt($created_at)
				->skip($offset)->take($rows)->orderBy($sort, $order)->withTrashed()->get();	
		
		$result["total"] = $count_rows;
		$result["rows"] = $model;

		echo json_encode($result);
		
	}

	public function generaLineas($enc_impacto){
		$m_enc_impacto=DB::table('enc_impactos')->where('id', '=', $enc_impacto)->first();
		$m_matriz=Db::table('matrizs as m')
						->select('m.id','m.factor_id', 'm.rubro_id', 'm.especifico_id')
						->where('m.tipo_impacto_id','=', $m_enc_impacto->tipo_impacto_id)->get();
		
		foreach($m_matriz as $combinacion){
			//log::info(print_r($combinacion));
			$m_linea = array();
			$m_linea['enc_impacto_id']=$enc_impacto;
			$m_linea['factor_id']=$combinacion->factor_id;
			$m_linea['rubro_id']=$combinacion->rubro_id;
			$m_linea['especifico_id']=$combinacion->especifico_id;
			$m_linea['usu_alta_id'] = Sentry::getUser()->id;	
			$m_linea['usu_mod_id'] = Sentry::getUser()->id;
			$m_linea['estatus_id'] = 1;
			$r=$this->reg_impacto->create($m_linea);
			if ($r){
				$m_caracteristicas=DB::table('caracteristica_matriz as cm')
										->select('matriz_id', 'caracteristica_id')
										->where('cm.matriz_id', '=', $combinacion->id)
										->get();
				foreach($m_caracteristicas as $caracteristica){
					$m_ln_caracteristica=new Ln_caracteristica;
					$m_ln_caracteristica->reg_impacto_id=$r->id;
					$m_ln_caracteristica->caracteristica_id=$caracteristica->caracteristica_id;
					$m_ln_caracteristica->efecto_id=1;
					$m_ln_caracteristica->desc_efecto="";
                    $m_ln_caracteristica->descripcion="";
                    $m_ln_caracteristica->resarcion="";
					$m_ln_caracteristica->emision_efecto_id=1;
					$m_ln_caracteristica->duracion_accion_id=1;
					$m_ln_caracteristica->continuidad_efecto_id=1;
					$m_ln_caracteristica->reversibilidad_id=1;
					$m_ln_caracteristica->probabilidad_id=1;
					$m_ln_caracteristica->mitigacion_id=1;
					$m_ln_caracteristica->intensidad_impacto_id=1;
					$m_ln_caracteristica->imp_potencial_id=1;
					$m_ln_caracteristica->imp_real_id=1;
					$m_ln_caracteristica->intensidad_impacto_id=1;
					$m_ln_caracteristica->usu_alta_id = Sentry::getUser()->id;	
					$m_ln_caracteristica->usu_mod_id = Sentry::getUser()->id;
					$m_ln_caracteristica->save();
				}
			}
		}
		return;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$factor_ls=['0' => 'Seleccionar'] + Factor::lists('factor','id');
		$rubro_ls=['0' => 'Seleccionar'] + Rubro::lists('rubro','id');
		$especifico_ls=['0' => 'Seleccionar'] + Especifico::lists('especifico','id');
		$caracteristica_ls=['0' => 'Seleccionar'] + Caracteristica::lists('caracteristica','id');
		$efecto_ls=['0' => 'Seleccionar'] + Efecto::lists('efecto','id');
		$emision_efecto_ls=['0' => 'Seleccionar'] + Emision_efecto::lists('Emision_efecto','id');
		$duracion_accion_ls=['0' => 'Seleccionar'] + Duracion_accion::lists('duracion_accion','id');
		$continuidad_efecto_ls=['0' => 'Seleccionar'] + Continuidad_efecto::lists('continuidad_efecto','id');
		$reversibilidad_ls=['0' => 'Seleccionar'] + Reversibilidad::lists('reversibilidad','id');
		$probabilidad_ls=['0' => 'Seleccionar'] + Probabilidad::lists('probabilidad','id');
		$mitigacion_ls=['0' => 'Seleccionar'] + Mitigacion::lists('mitigacion','id');
		$intensidad_impacto_ls=['0' => 'Seleccionar'] + Intensidad_impacto::lists('intensidad_impacto','id');
		return View::make('reg_impactos.create', array('factor_ls'=>$factor_ls,
						  'rubro_ls'=>$rubro_ls, 'especifico_ls'=>$especifico_ls, 'caracteristica_ls'=>$caracteristica_ls,
						  'efecto_ls'=>$efecto_ls, 'emision_efecto_ls'=>$emision_efecto_ls, 'duracion_accion_ls'=>$duracion_accion_ls,
						  'continuidad_efecto_ls'=>$continuidad_efecto_ls, 'reversibilidad_ls'=>$reversibilidad_ls,
						  'probabilidad_ls'=>$probabilidad_ls, 'mitigacion_ls'=>$mitigacion_ls, 'intensidad_impacto_ls'=>$intensidad_impacto_ls));
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
		$validation = Validator::make($input, Reg_impacto::$rules, Reg_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$this->reg_impacto->create($input);

			return Redirect::route('reg_impacto.index');
		}

		return Redirect::route('reg_impacto.create')
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
		$reg_impacto = $this->reg_impacto->findOrFail($id);
		return View::make('reg_impactos.show', compact('reg_impacto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$reg_impacto = $this->reg_impacto->find($id);
		$efecto_ls=['0' => 'Seleccionar'] + Efecto::lists('descripcion','id');
		$estatus_ls=['0' => 'Seleccionar'] + St_reg_impacto::lists('st_reg_impacto','id');
		if (is_null($reg_impacto))
		{
			return Redirect::route('reg_impactos.index');
		}
		$factor_ls=['0' => 'Seleccionar'] + Factor::lists('factor','id');
		$rubro_ls=['0' => 'Seleccionar'] + Rubro::lists('rubro','id');
		$especifico_ls=['0' => 'Seleccionar'] + Especifico::lists('especifico','id');
		$caracteristica_ls=['0' => 'Seleccionar'] + Caracteristica::lists('caracteristica','id');
		$efectos_ls=['0' => 'Seleccionar'] + Efecto::lists('efecto','id');
		$emision_efecto_ls=['0' => 'Seleccionar'] + Emision_efecto::lists('Emision_efecto','id');
		$duracion_accion_ls=['0' => 'Seleccionar'] + Duracion_accion::lists('duracion_accion','id');
		$continuidad_efecto_ls=['0' => 'Seleccionar'] + Continuidad_efecto::lists('continuidad_efecto','id');
		$reversibilidad_ls=['0' => 'Seleccionar'] + Reversibilidad::lists('reversibilidad','id');
		$probabilidad_ls=['0' => 'Seleccionar'] + Probabilidad::lists('probabilidad','id');
		$mitigacion_ls=['0' => 'Seleccionar'] + Mitigacion::lists('mitigacion','id');
		$intensidad_impacto_ls=['0' => 'Seleccionar'] + Intensidad_impacto::lists('intensidad_impacto','id');

		return View::make('reg_impactos.edit', array('factor_ls'=>$factor_ls, 'estatus_ls'=>$estatus_ls,
						  'rubro_ls'=>$rubro_ls, 'especifico_ls'=>$especifico_ls, 'caracteristica_ls'=>$caracteristica_ls,
						  'efecto_ls'=>$efecto_ls, 'emision_efecto_ls'=>$emision_efecto_ls, 'duracion_accion_ls'=>$duracion_accion_ls,
						  'continuidad_efecto_ls'=>$continuidad_efecto_ls, 'reversibilidad_ls'=>$reversibilidad_ls,
						  'probabilidad_ls'=>$probabilidad_ls, 'mitigacion_ls'=>$mitigacion_ls, 'efectos_ls'=>$efectos_ls, 
						  'intensidad_impacto_ls'=>$intensidad_impacto_ls, 'reg_impacto'=>$reg_impacto));
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
		$validation = Validator::make($input, Reg_impacto::$rules, Reg_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$reg_impacto = $this->reg_impacto->find($id);
			$reg_impacto->update($input);

			return Redirect::route('reg_impacto.index', array('id'=>$reg_impacto->enc_impacto_id));
		}

		return Redirect::route('reg_impacto.edit', $id)
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
		if ($this->reg_impacto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->reg_impacto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbRubro(){
		if(Request::ajax()){
			$id = e(Input::get('id'));
			return DB::table('matrizs')
					->join('rubros as r', 'r.id', '=', 'matrizs.rubro_id')
					->select('r.id', 'r.rubro')
					->where('matrizs.factor_id', '=', $id)
					->distinct()->get();
		}
	}
	public function cmbEspecifico(){
		if(Request::ajax()){
			$id = e(Input::get('id'));
			return DB::table('matrizs')
					->join('especificos as e', 'e.id', '=', 'matrizs.especifico_id')
					->select('e.id', 'e.especifico')
					->where('matrizs.rubro_id', '=', $id)
					->distinct()->get();
		}
	}
	
	public function descEfecto(){
		if(Request::ajax()){
			$id = e(Input::get('id'));
			return Efecto::find($id);
		}
	}

/////////////////////////////Lineas de caracteristicas////////////////////////////////
	public function contentListLn(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 11;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$id_ln=isset($_REQUEST['id_ln']) ? intval($_REQUEST['id_ln']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();


		$count_rows=$this->ln_caracteristica->id($id)->where('ln_caracteristicas.reg_impacto_id','=', $id_ln)->count();

		$model=$this->ln_caracteristica
				->join('caracteristicas as c', 'c.id', '=', 'ln_caracteristicas.caracteristica_id')
				->join('efectos as e', 'e.id', '=', 'ln_caracteristicas.efecto_id')
				->join('emision_efectos as ee','ee.id','=','ln_caracteristicas.emision_efecto_id')
				->join('duracion_accions as da','da.id','=','ln_caracteristicas.duracion_accion_id')
				->join('continuidad_efectos as ce','ce.id','=','ln_caracteristicas.continuidad_efecto_id')
				->join('reversibilidads as r','r.id','=','ln_caracteristicas.reversibilidad_id')
				->join('probabilidads as p','p.id','=','ln_caracteristicas.probabilidad_id')
				->join('mitigacions as m','m.id','=','ln_caracteristicas.mitigacion_id')
				->join('intensidad_impactos as ii','ii.id','=','ln_caracteristicas.intensidad_impacto_id')
				->join('imp_reals as ir', 'ir.id', '=', 'ln_caracteristicas.imp_real_id')
				->join('imp_potencials as ip', 'ip.id', '=', 'ln_caracteristicas.imp_potencial_id')
				->select('ln_caracteristicas.id','ln_caracteristicas.reg_impacto_id','ln_caracteristicas.caracteristica_id', 'ln_caracteristicas.descripcion', 'ln_caracteristicas.resarcion',
						 'c.caracteristica','ln_caracteristicas.efecto_id','e.efecto', 'e.descripcion as desc_efecto', 'ln_caracteristicas.emision_efecto_id',
						 'ln_caracteristicas.duracion_accion_id', 'ln_caracteristicas.continuidad_efecto_id', 'ln_caracteristicas.reversibilidad_id', 'ln_caracteristicas.probabilidad_id',
						 'ln_caracteristicas.mitigacion_id', 'ln_caracteristicas.intensidad_impacto_id', 'ir.imp_real', 'ip.imp_potencial')
				->Id($id)
				->where('ln_caracteristicas.reg_impacto_id','=', $id_ln)
				->skip($offset)->take($rows)->orderBy($sort, $order)->withTrashed()->get();	
		
		$result["total"] = $count_rows;
		$result["rows"] = $model;

		echo json_encode($result);
	}

	public function updateLn()
	{
		$m_ln=Ln_caracteristica::find($_POST['id']);

		$m_ln['reg_impacto_id']=$_POST['reg_impacto_id'];
		$m_ln['caracteristica_id']=$_POST['caracteristica_id'];
		$m_ln['efecto_id']=$_POST['efecto_id'];
		$m_ln['desc_efecto']=$_POST['desc_efecto'];
		$m_ln['descripcion']=$_POST['descripcion'];
		$m_ln['resarcion']=$_POST['resarcion'];
		$m_ln['emision_efecto_id']=$_POST['emision_efecto_id'];
		$m_ln['duracion_accion_id']=$_POST['duracion_accion_id'];
		$m_ln['continuidad_efecto_id']=$_POST['continuidad_efecto_id'];
		$m_ln['reversibilidad_id']=$_POST['reversibilidad_id'];
		$m_ln['probabilidad_id']=$_POST['probabilidad_id'];
		$m_ln['mitigacion_id']=$_POST['mitigacion_id'];
		$m_ln['intensidad_impacto_id']=$_POST['intensidad_impacto_id'];
		$m_ln['usu_mod_id']=Sentry::getUser()->id;
		$imp_real=DB::Table('m_imp_reals as m')
						->where('m.efecto_id', $m_ln['efecto_id'])
						->where('m.probabilidad_id',$m_ln['probabilidad_id'])
						->pluck('m.imp_real_id');
		//dd($imp_real);
		$m_ln['imp_real_id']=$imp_real;
		$imp_potencial=DB::Table('m_imp_potencials as m')
						->where('m.efecto_id', $m_ln['efecto_id'])
						->where('m.duracion_accion_id',$m_ln['duracion_accion_id'])
						->pluck('m.imp_potencial_id');
		$m_ln['imp_potencial_id']=$imp_potencial;

		if ($m_ln->save()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Problemas al editar registro.'));
		}
		
	}

}
