<?php

class ConsultasController extends BaseController {

	protected $residuos;
	protected $consumibles;
	protected $mantenimientos;
	protected $fuentesFijas;
	protected $plantas;
	protected $no_conformidades;
	protected $accidentes;
	protected $enfermedades;
	protected $aspectos_ambientales;

	public function __construct(Bitacora_residuo $bitacora_res, 
								Bitacora_consumible $bitacora_consu,
								M_mantenimiento $m_manto,
								Bitacora_ff $bitacora_ff,
								Bitacora_planta $bitacora_plan,
								A_no_conformidade $a_no_confor,
								Bitacora_accidente $bitacora_acci,
								Bitacora_enfermedade $bitacora_enfer,
								Aspectos_ambientale $aspectos_amb)
	{
		$this->residuos = $bitacora_res;
		$this->consumibles=$bitacora_consu;
		$this->mantenimientos=$m_manto;
		$this->fuentesFijas=$bitacora_ff;
		$this->plantas=$bitacora_plan;
		$this->no_conformidades=$a_no_confor;
		$this->accidentes=$bitacora_acci;
		$this->enfermedades=$bitacora_enfer;
		$this->aspectos_ambientales=$aspectos_amb;
	}

	public $rulesMessages=array(
			'required' => 'El campo :attribute es obligatorio.',
			'not_in' => 'El campo :attribute es obligatorio.',
		);

	public function getFuenteFija(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$fuentes_fijas_ls=['0' => 'Seleccionar'] + Ca_fuentes_fija::lists('planta','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	return View::make('consultas.fuentesFijas', compact('cias_ls', 'fuentes_fijas_ls', 'responsables_ls'));	
	}

	public function postFuenteFija(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'fuente_f' => 'not_in:0',
			'fuente_t' => 'not_in:0',
			'responsable_f' => 'required',
			'responsable_t' => 'required',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.fuenteFija')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}
	

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/fuentesFijas.pdf')){
			unlink($carpeta . '/fuentesFijas.pdf');
		}

		$fs=$this->plantas->select('bitacora_ffs.*', 'e.nombre')
									->whereBetween('bitacora_ffs.cia_id', array($input['cia_f'], $input['cia_t']))
									->join('empleados as e', 'e.id', '=', 'bitacora_ffs.responsable_id')
									->whereBetween('bitacora_ffs.ca_fuente_fija_id', array($input['fuente_f'], $input['fuente_t']))
									->whereBetween('bitacora_ffs.responsable_id', array($input['responsable_f'], $input['responsable_t']))
									->whereBetween('bitacora_ffs.fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();
		
		/*JasperPHP::process(
	    base_path() . '/public/reportes/reportes/fuentesFijas.jasper', 
	    $carpeta . '/fuentesFijas', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'fuente_f'=>Input::get('fuente_f'), 'fuente_t'=> Input::get('fuente_t'),
	    	  'responsable_f'=>Input::get('responsable_f'), 'responsable_t'=> Input::get('responsable_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/fuentesFijas.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/fuentesFijas.pdf');	    
		*/
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.fuentesFijasr', array('fs'=>$fs, 'img'=>$img, 'fecha'=>'fecha'))
		->setPaper('letter')->setOrientation('landscape');
		return $pdf->download('reporte.pdf');
		
	}

	public function getPlanta(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$plantas_ls=['0' => 'Seleccionar'] + Ca_planta::lists('planta','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	return View::make('consultas.plantas', compact('cias_ls', 'plantas_ls', 'responsables_ls'));	
	}

	public function postPlanta(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'planta_f' => 'not_in:0',
			'planta_t' => 'not_in:0',
			'responsable_f' => 'required',
			'responsable_t' => 'required',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.planta')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/plantas.pdf')){
			unlink($carpeta . '/plantas.pdf');
		}

		$ps=$this->plantas->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('planta_id', array($input['planta_f'], $input['planta_t']))
									->whereBetween('responsable_id', array($input['responsable_f'], $input['responsable_t']))
									->whereBetween('fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();
		
		/*JasperPHP::process(
	    base_path() . '/public/reportes/reportes/plantas.jasper', 
	    $carpeta . '/plantas', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'planta_f'=>Input::get('planta_f'), 'planta_t'=> Input::get('planta_t'),
	    	  'responsable_f'=>Input::get('responsable_f'), 'responsable_t'=> Input::get('responsable_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/plantas.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/plantas.pdf');	    */
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.plantasr', array('ps'=>$ps, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('landscape');
		return $pdf->download('reporte.pdf');
	}

	public function getResiduo(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$residuos_ls=['0' => 'Seleccionar'] + Ca_residuo::lists('residuo','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	return View::make('consultas.residuos', compact('cias_ls', 'residuos_ls', 'responsables_ls'));	
	}

	public function postResiduo(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		//dd($input['cia_f']);
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'residuo_f' => 'not_in:0',
			'residuo_t' => 'not_in:0',
			'responsable_f' => 'required',
			'responsable_t' => 'required',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		
		if (!$validation->passes()){
			return Redirect::route('consulta.residuo')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}
		//dd('fil');
		$rs=$this->residuos->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('residuo', array($input['residuo_f'], $input['residuo_t']))
									->whereBetween('responsable_id', array($input['responsable_f'], $input['responsable_t']))
									->whereBetween('fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();
		//dd($rs);
		//Generacion para pdf
		/* 
		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/residuos.pdf')){
			unlink($carpeta . '/residuos.pdf');
		}
		
		JasperPHP::process(
	    base_path() . '/public/reportes/reportes/residuos.jasper', 
	    $carpeta . '/residuos', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'residuo_f'=>Input::get('residuo_f'), 'residuo_t'=> Input::get('residuo_t'),
	    	  'responsable_f'=>Input::get('responsable_f'), 'responsable_t'=> Input::get('responsable_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/residuos.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/residuos.pdf');	    
		*/
		//return View::make('consultas.residuosr', compact('rs'));
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.residuosr', array('rs'=>$rs, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('landscape');
		return $pdf->download('reporte.pdf');
	}		

	public function getConsumible(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$consumibles_ls=['0' => 'Seleccionar'] + Ca_consumible::lists('consumible','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	return View::make('consultas.consumibles', compact('cias_ls', 'consumibles_ls', 'responsables_ls'));	
	}

	public function postConsumible(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'consumible_f' => 'not_in:0',
			'consumible_t' => 'not_in:0',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.consumible')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/consumibles.pdf')){
			unlink($carpeta . '/consumibles.pdf');
		}
		
		$cs=$this->consumibles->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('consumible_id', array($input['consumible_f'], $input['consumible_t']))
									->whereBetween('fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();

		/*
		JasperPHP::process(
	    base_path() . '/public/reportes/reportes/consumibles.jasper', 
	    $carpeta . '/consumibles', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'consumible_f'=>Input::get('consumible_f'), 'consumible_t'=> Input::get('consumible_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/consumibles.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/consumibles.pdf');	    
		*/
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.consumosr', array('cs'=>$cs, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('portrait');
		return $pdf->download('reporte.pdf');
	}

	public function getNoConformidad(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
	$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
	$tpo_bitacoras_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_bitacoras')->lists('tpo_bitacora','id');
	$tpo_inconformidades_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_noconformidades')->lists('tpo_inconformidad','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
	$estatus_ls=['0' => 'Seleccionar'] + A_st_nc::lists('estatus','id');
	
	return View::make('consultas.noConformidades', compact('cias_ls',
		'areas_ls', 'tpo_detecciones_ls', 'tpo_bitacoras_ls', 
		'tpo_inconformidades_ls','tpo_detecciones_ls','responsables_ls', 
		'estatus_ls'));	
	}

	public function postNoConformidad(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'area_f' => 'not_in:0',
			'area_t' => 'not_in:0',
			'tpo_deteccion_f' => 'not_in:0',
			'tpo_deteccion_t' => 'not_in:0',
			'tpo_bitacora_f' => 'not_in:0',
			'tpo_bitacora_t' => 'not_in:0',
			'tpo_inconformidad_f' => 'not_in:0',
			'tpo_inconformidad_t' => 'not_in:0',
			'responsable_f' => 'required',
			'responsable_t' => 'required',
			'estatus_f' => 'not_in:0',
			'estatus_t' => 'not_in:0',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		//print_r($input);
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.noConformidad')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/noConformidades.pdf')){
			unlink($carpeta . '/noConformidades.pdf');
		}
		$ncs=$this->no_conformidades->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('area_id', array($input['area_f'], $input['area_t']))
									->whereBetween('tpo_deteccion_id', array($input['tpo_deteccion_f'], $input['tpo_deteccion_t']))
									->whereBetween('tpo_bitacora_id', array($input['tpo_bitacora_f'], $input['tpo_bitacora_t']))
									->whereBetween('tpo_inconformidad_id', array($input['tpo_inconformidad_f'], $input['tpo_inconformidad_t']))
									->whereBetween('responsable_id', array($input['responsable_f'], $input['responsable_t']))
									->whereBetween('estatus_id', array($input['estatus_f'], $input['estatus_t']))
									->whereBetween('fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();
		
		/*JasperPHP::process(
	    base_path() . '/public/reportes/reportes/noConformidades.jasper', 
	    $carpeta . '/noConformidades', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'area_f'=>Input::get('area_f'), 'area_t'=> Input::get('area_t'),
	    	  'tpo_deteccion_f'=>Input::get('tpo_deteccion_f'), 'tpo_deteccion_t'=> Input::get('tpo_deteccion_t'),
	    	  'tpo_bitacora_f'=>Input::get('tpo_bitacora_f'), 'tpo_bitacora_t'=> Input::get('tpo_bitacora_t'),
	    	  'tpo_inconformidad_f'=>Input::get('tpo_inconformidad_f'), 'tpo_inconformidad_t'=> Input::get('tpo_inconformidad_t'),
	    	  'responsable_f'=>Input::get('responsable_f'), 'responsable_t'=> Input::get('responsable_t'),
	    	  'estatus_f'=>Input::get('estatus_f'), 'estatus_t'=> Input::get('estatus_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )->execute();
		
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/noConformidades.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/noConformidades.pdf');	    
	    */
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.noConformidadesr', array('ncs'=>$ncs, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('portrait');
		return $pdf->download('reporte.pdf');
	}

	public function getAccidente(){
	
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$accidentes_ls=['0' => 'Seleccionar'] + Cs_accidente::lists('accidente','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	$areas_ls=['0' => 'Seleccionar'] +Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
	$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
	return View::make('consultas.accidentes', compact('cias_ls', 'accidentes_ls', 'responsables_ls', 'areas_ls', 'acciones_ls'));	
	}

	public function postAccidente(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'accidente_f' => 'not_in:0',
			'accidente_t' => 'not_in:0',
			'responsable_f' => 'not_in:0',
			'responsable_t' => 'not_in:0',
			'area_f' => 'not_in:0',
			'area_t' => 'not_in:0',
			'accion_f' => 'not_in:0',
			'accion_t' => 'not_in:0',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.accidente')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/accidentes.pdf')){
			unlink($carpeta . '/accidentes.pdf');
		}
		
		$as=$this->accidentes->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('accidente_id', array($input['accidente_f'], $input['accidente_t']))
									->whereBetween('responsable_id', array($input['responsable_f'], $input['responsable_t']))
									->whereBetween('area_id', array($input['area_f'], $input['area_t']))
									->whereBetween('accion_id', array($input['accion_f'], $input['accion_t']))
									->whereBetween('fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();

		/*JasperPHP::process(
	    base_path() . '/public/reportes/reportes/accidentes.jasper', 
	    $carpeta . '/accidentes', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'accidente_f'=>Input::get('accidente_f'), 'accidente_t'=> Input::get('accidente_t'),
	    	  'responsable_f'=>Input::get('responsable_f'), 'responsable_t'=> Input::get('responsable_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'area_f'=>Input::get('area_f'), 'area_t'=> Input::get('area_t'),
	    	  'accion_f'=>Input::get('accion_f'), 'accion_t'=> Input::get('accion_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/accidentes.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/accidentes.pdf');	    
		*/
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.accidentesr', array('as'=>$as, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('portrait');
		return $pdf->download('reporte.pdf');
	}

	public function getEnfermedad(){
	
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$enfermedades_ls=['0' => 'Seleccionar'] + Cs_enfermedade::lists('enfermedad','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('nombre','id');
	$areas_ls=['0' => 'Seleccionar'] +Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
	$acciones_ls=['0' => 'Seleccionar'] + Cs_accione::lists('accion','id');
	return View::make('consultas.enfermedades', compact('cias_ls', 'enfermedades_ls', 'responsables_ls', 'areas_ls', 'acciones_ls'));	
	}

	public function postEnfermedad(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'enfermedad_f' => 'not_in:0',
			'enfermedad_t' => 'not_in:0',
			'area_f' => 'not_in:0',
			'area_t' => 'not_in:0',
			'accion_f' => 'not_in:0',
			'accion_t' => 'not_in:0',
			'fecha_f' => 'required',
			'fecha_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.enfermedad')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/enfermedades.pdf')){
			unlink($carpeta . '/enfermedades.pdf');
		}

		$es=$this->enfermedades->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('enfermedad_id', array($input['enfermedad_f'], $input['enfermedad_t']))
									->whereBetween('area_id', array($input['area_f'], $input['area_t']))
									->whereBetween('accion_id', array($input['accion_f'], $input['accion_t']))
									->whereBetween('fecha', array($input['fecha_f'], $input['fecha_t']))
									->get();

		/*
		JasperPHP::process(
	    base_path() . '/public/reportes/reportes/enfermedades.jasper', 
	    $carpeta . '/enfermedades', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 'cia_t'=> Input::get('cia_t'),
	    	  'enfermedad_f'=>Input::get('enfermedad_f'), 'enfermedad_t'=> Input::get('enfermedad_t'),
	    	  'area_f'=>Input::get('area_f'), 'area_t'=> Input::get('area_t'),
	    	  'accion_f'=>Input::get('accion_f'), 'accion_t'=> Input::get('accion_t'),
	    	  'fecha_f'=>Input::get('fecha_f'), 'fecha_t'=> Input::get('fecha_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/enfermedades.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/enfermedades.pdf');	    
	    */
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.enfermedadesr', array('es'=>$es, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('portrait');
		return $pdf->download('reporte.pdf');
	}

	public function getAspectosAmbientales(){
		$procesos_ls=['0' => 'Seleccionar'] + Aa_proceso::lists('proceso','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$imp_reals_ls=['0' => 'Seleccionar'] + Imp_real::lists('imp_real','id');
		$imp_potencials_ls=['0' => 'Seleccionar'] + Imp_potencial::lists('imp_potencial','id');
		$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
		return View::make('consultas.aspectosAmbientales', compact('cias_ls', 'imp_potencials_ls', 'imp_reals_ls', 'areas_ls', 'procesos_ls'));	
	}

	public function postAspectosAmbientales(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'proceso_f' => 'not_in:0',
			'proceso_t' => 'not_in:0',
			'area_f' => 'not_in:0',
			'area_t' => 'not_in:0',
			'imp_real_f' => 'not_in:0',
			'imp_real_t' => 'not_in:0',
			'imp_potencial_f' => 'required',
			'imp_potencial_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.aspectosAmbientales')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/aspectosAmbientales.pdf')){
			unlink($carpeta . '/aspectosAmbientales.pdf');
		}

		$ass=$this->aspectos_ambientales->whereBetween('cia_id', array($input['cia_f'], $input['cia_t']))
									->whereBetween('proceso_id', array($input['proceso_f'], $input['proceso_t']))
									->whereBetween('area_id', array($input['area_f'], $input['area_t']))
									->whereBetween('imp_real_id', array($input['imp_real_f'], $input['imp_real_t']))
									->whereBetween('imp_potencial_id', array($input['imp_potencial_f'], $input['imp_potencial_t']))
									->get();

		//dd(Input::all());
		/*JasperPHP::process(
	    base_path() . '/public/reportes/reportes/aspectosAmbientales.jasper', 
	    $carpeta . '/aspectosAmbientales', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 
	    	  'cia_t'=> Input::get('cia_t'),
	    	  'proceso_f'=>Input::get('proceso_f'), 
	    	  'proceso_t'=> Input::get('proceso_t'),
	    	  'area_f'=>Input::get('area_f'), 
	    	  'area_t'=> Input::get('area_t'),
	    	  'imp_real_f'=>Input::get('imp_real_f'), 
	    	  'imp_real_t'=> Input::get('imp_real_t'),
	    	  'imp_potencial_f'=>Input::get('imp_potencial_f'), 
	    	  'imp_potencial_t'=> Input::get('imp_potencial_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )->execute();

	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/aspectosAmbientales.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/aspectosAmbientales.pdf');	    
	    */
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		$pdf = PDF::loadView('consultas.aspectosAmbientalesr', array('ass'=>$ass, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('letter')->setOrientation('portrait');
		return $pdf->download('reporte.pdf');
	}

	public function getManto(){
		$objetivos_ls=['0' => 'Seleccionar'] + M_objetivo::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('objetivo','id');
		$estatus_ls=['0' => 'Seleccionar'] + M_estatus::lists('estatus','id');
		$tpo_mantos_ls=['0' => 'Seleccionar'] + M_tpo_manto::lists('tpo_manto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::Cia(User::find(Sentry::getUser()->id)->getCia())->lists('area','id');
		$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
		return View::make('consultas.manto', 
				  compact('cias_ls', 'objetivos_ls', 'estatus_ls', 'tpo_mantos_ls',
				  		  'areas_ls'));	
	}

	public function postManto(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		/* Reglas de validacion */
		$rules = array(
			'cia_f' => 'not_in:0',
			'cia_t' => 'not_in:0',
			'area_f' => 'not_in:0',
			'area_t' => 'not_in:0',
			'objetivo_f' => 'not_in:0',
			'objetivo_t' => 'not_in:0',
			'estatus_f' => 'not_in:0',
			'estatus_t' => 'not_in:0',
			'tpo_manto_f' => 'required',
			'tpo_manto_t' => 'required',
		);
		
		$validation = Validator::make($input, $rules, $this->rulesMessages);
		if (!$validation->passes()){
			return Redirect::route('consulta.manto')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		}

		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/manto.pdf')){
			unlink($carpeta . '/manto.pdf');
		}
		$ms=$this->mantenimientos->whereBetween('m_mantenimientos.cia_id', array($input['cia_f'], $input['cia_t']))
									->join('subequipos as s', 's.id', '=', 'm_mantenimientos.subequipo_id')
									->whereBetween('s.area_id', array($input['area_f'], $input['area_t']))
									->whereBetween('objetivo_id', array($input['objetivo_f'], $input['objetivo_t']))
									->whereBetween('estatus_id', array($input['estatus_f'], $input['estatus_t']))
									->whereBetween('m_tpo_manto_id', array($input['tpo_manto_f'], $input['tpo_manto_t']))
									->get();
		
		//dd(Input::all());
		/*JasperPHP::process(
	    base_path() . '/public/reportes/reportes/manto.jasper', 
	    $carpeta . '/manto', 
	    array("pdf"), 
	    array('cia_f'=>Input::get('cia_f'), 
	    	  'cia_t'=> Input::get('cia_t'),
	    	  'area_f'=>Input::get('area_f'), 
	    	  'area_t'=> Input::get('area_t'),
	    	  'objetivo_f'=>Input::get('objetivo_f'), 
	    	  'objetivo_t'=> Input::get('objetivo_t'),
	    	  'estatus_f'=>Input::get('estatus_f'), 
	    	  'estatus_t'=> Input::get('estatus_t'),
	    	  'tpo_manto_f'=>Input::get('tpo_manto_f'), 
	    	  'tpo_manto_t'=> Input::get('tpo_manto_t'),
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img
	    	  ),
	    Config::get('database.connections.mysql') //DB connection array
	    )->execute();

	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/manto.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/manto.pdf');	    
	    */
		$img=asset('uploads/cias/'.$img);
		$fecha=date('d/m/Y');
		//dd($img);
		$pdf = PDF::loadView('consultas.mantenimientosr', array('ms'=>$ms, 'img'=>$img, 'fecha'=>$fecha))
		->setPaper('legal')->setOrientation('landscape');
		return $pdf->download('reporte.pdf');		
		
		//return View::make('consultas.mantenimientosr', compact('ms', 'img', 'fecha'));
	}
}
