<?php

class ConsultasController extends BaseController {

	public $rulesMessages=array(
			'required' => 'El campo :attribute es obligatorio.',
			'not_in' => 'El campo :attribute es obligatorio.',
		);

	public function getFuenteFija(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$fuentes_fijas_ls=['0' => 'Seleccionar'] + Ca_fuentes_fija::lists('planta','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
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
		
		JasperPHP::process(
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
	}

	public function getPlanta(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$plantas_ls=['0' => 'Seleccionar'] + Ca_planta::lists('planta','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
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
		
		JasperPHP::process(
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
	    return Response::download($carpeta.'/plantas.pdf');	    
	}

	public function getResiduo(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$residuos_ls=['0' => 'Seleccionar'] + Ca_residuo::lists('residuo','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
	return View::make('consultas.residuos', compact('cias_ls', 'residuos_ls', 'responsables_ls'));	
	}

	public function postResiduo(){
		$input = Input::all();
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
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
	}		

	public function getConsumible(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$consumibles_ls=['0' => 'Seleccionar'] + Ca_consumible::lists('consumible','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
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
	}

	public function getNoConformidad(){
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
	$tpo_detecciones_ls=['0' => 'Seleccionar'] + Cs_tpo_deteccion::lists('tpo_deteccion','id');
	$tpo_bitacoras_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_bitacoras')->lists('tpo_bitacora','id');
	$tpo_inconformidades_ls=['0' => 'Seleccionar'] + DB::Table('ca_tpo_noconformidades')->lists('tpo_inconformidad','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
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
		
		
		JasperPHP::process(
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
	    
	}

	public function getAccidente(){
	
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$accidentes_ls=['0' => 'Seleccionar'] + Cs_accidente::lists('accidente','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
	$areas_ls=['0' => 'Seleccionar'] +Area::lists('area','id');
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
		
		JasperPHP::process(
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
	}

	public function getEnfermedad(){
	
	$cias_ls=['0' => 'Seleccionar'] + Entidad::lists('abreviatura','id');
	$enfermedades_ls=['0' => 'Seleccionar'] + Cs_enfermedade::lists('enfermedad','id');
	$responsables_ls=['0' => 'Seleccionar'] + Empleado::lists('nombre','id');
	$areas_ls=['0' => 'Seleccionar'] +Area::lists('area','id');
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
	    
	}

	public function getAspectosAmbientales(){
		$procesos_ls=['0' => 'Seleccionar'] + Aa_proceso::lists('proceso','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
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
		//dd(Input::all());
		JasperPHP::process(
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
	    
	}

	public function getManto(){
		$objetivos_ls=['0' => 'Seleccionar'] + M_objetivo::lists('objetivo','id');
		$estatus_ls=['0' => 'Seleccionar'] + M_estatus::lists('estatus','id');
		$tpo_mantos_ls=['0' => 'Seleccionar'] + M_tpo_manto::lists('tpo_manto','id');
		$areas_ls=['0' => 'Seleccionar'] + Area::lists('area','id');
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
		//dd(Input::all());
		JasperPHP::process(
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
	    
	}
}
