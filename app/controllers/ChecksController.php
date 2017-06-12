<?php

class ChecksController extends BaseController {

	/**
	 * Check Repository
	 *
	 * @var Check
	 */
	protected $check;

	public function __construct(Check $check)
	{
		$this->check = $check;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clientes_ls=['0' => 'Seleccionar'] + Cliente::lists('cliente','id');	
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');	
		return View::make('checks.index', array('clientes_ls'=>$clientes_ls, 'areas_ls'=>$areas_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cliente = isset($_POST['cliente']) ? intval($_POST['cliente']) : 0;
		$area = isset($_POST['area']) ? intval($_POST['area']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->check->id($id)->Cliente($cliente)->Area($area)->withTrashed()->count();

		$model=$this->check
				->select('checks.id', 'c.cliente', 'a.area', 'checks.solicitud', 'checks.fec_apertura', 'checks.fec_cierre', 
						 'checks.created_at', 'checks.updated_at', 'checks.deleted_at')
				->join('clientes as c', 'c.id', '=', 'checks.cliente')
				->join('achecks as a', 'a.id', '=', 'checks.a_chequeo')
				->Id($id)->Cliente($cliente)->Area($area)
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
		$clientes_ls=['0' => 'Seleccionar'] + Cliente::lists('cliente','id');
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');	
		$normas_ls=array();
		$n=DB::table('normas')
						->join('mchecks as mc', 'mc.norma_id', '=', 'normas.id')
						->select('normas.norma', 'normas.id')
						->distinct()
						//->lists('normas.norma', 'normas.id');
						->get();
		foreach($n as $norma){
			$normas_ls[$norma->id] = $norma->norma;
		}
		return View::make('checks.create', array('clientes_ls'=>$clientes_ls, 'areas_ls'=>$areas_ls, 'normas_ls'=>$normas_ls));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input_normas=Input::get('normas');
		unset($input['normas']);
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Check::$rules, Check::$rulesMessages);

		DB::beginTransaction();
		try{
			if ($validation->passes()){
				//Crea cabecera
				$check=$this->check->create($input);

				//Crea normas
				if(isset($input_normas) and is_array($input_normas)){
					foreach($input_normas as $norma){
						$check->Norma()->attach($norma);
					}
				}

				//Crea Lineas
				$lineas=DB::table('mchecks')
							->select('a_chequeo', 'norma_id', 'no_conformidad', 'correccion', 'requisito', 'rnc', 'minimo_vsm', 'maximo_vsm')
							->where('a_chequeo', $check->a_chequeo)
							->wherein('norma_id', $input_normas)
							->orderBy('norma_id')->orderBy('orden')->get();
				$sm=DB::table('sms')->select('monto')->where('id', '1')->pluck('monto');
				foreach($lineas as $ln){
					$linea=array();
					$linea['a_chequeo']		= $ln->a_chequeo;
					$linea['norma_id']		= $ln->norma_id;
					$linea['no_conformidad']= $ln->no_conformidad;
					$linea['correccion']	= $ln->correccion;
					$linea['requisito']		= $ln->requisito;
					$linea['rnc']			= $ln->rnc;
					$linea['cumplimiento']	= 1;
					$linea['minimo_vsm']	= $ln->minimo_vsm;
					$linea['maximo_vsm']	= $ln->maximo_vsm;
					$linea['monto_min'] 	= $ln->minimo_vsm*$sm;
					$linea['monto_max']   	= $ln->maximo_vsm*$sm;
					$linea['monto_medio'] 	= ($linea['monto_min']+$linea['monto_max'])/2;
					$linea['t_semanas']		= 0;					
					$linea['responsable']	= "";					
					$linea['monto_estimado']= 0;					
					$linea['usu_alta_id'] 	= Sentry::getUser()->id;
					$linea['usu_mod_id']  	= Sentry::getUser()->id;
					$l=new Checkl($linea);
					Check::find($check->id)->ln()->save($l);
				}
			}else{
				return Redirect::route('check.create')
				->withInput()
				->withErrors($validation)
				->with('message', 'Existen errores de validación.');
			}
		}
		catch(\Exception $e){
			DB::rollback();
    		throw $e;
		}
		DB::commit();
		return Redirect::route('check.index');

		/*if ($validation->passes())
		{
			$this->check->create($input);
			return Redirect::route('check.index');
		}

		return Redirect::route('check.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
		*/
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$check = $this->check->findOrFail($id);

		return View::make('checks.show', compact('check'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$check = $this->check->find($id);
		$check->fec_cierre=($check->fec_cierre=="0000-00-00")?"":$check->fec_cierre;

		$normas=$check->Norma;
		$normas_seleccionadas=array();

		foreach($normas as $n){
			array_push($normas_seleccionadas, $n->id);
		}

		if (is_null($check))
		{
			return Redirect::route('checks.index');
		}
		$clientes_ls=['0' => 'Seleccionar'] + Cliente::lists('cliente','id');
		$areas_ls=['0' => 'Seleccionar'] + Acheck::lists('area','id');	
		$normas_ls=array();
		$n=DB::table('normas')
						->join('mchecks as mc', 'mc.norma_id', '=', 'normas.id')
						->select('normas.norma', 'normas.id')
						->distinct()
						//->lists('normas.norma', 'normas.id');
						->get();
		foreach($n as $norma){
			$normas_ls[$norma->id] = $norma->norma;
		}
		
		return View::make('checks.edit', array('check'=>$check, 'clientes_ls'=>$clientes_ls, 
						  'areas_ls'=>$areas_ls, 'normas_ls'=>$normas_ls, 'normas_seleccionadas'=>$normas_seleccionadas));
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
		$normas_seleccionadas=input::get('normas');
		$input['fec_cierre']=($input['fec_cierre']=="")?NULL:$input['fec_cierre'];
		unset($input['normas']);
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Check::$rules, Check::$rulesMessages);

		$normas_eliminar=array();
		$normas_agregar=array();

		DB::beginTransaction();
		try{
			if ($validation->passes())
			{
				//Busca y actualiza cabecera
				$check = $this->check->find($id);
				$check->update($input);
				$normas_db=$check->Norma;
				//$check = $this->check->find($id);

				
				if(isset($normas_seleccionadas) and is_array($normas_seleccionadas)){
					//Busca y agrega normas faltantes
					foreach($normas_db as $n){
						$existe=0;
						foreach($normas_seleccionadas as $n1){
							if($n->id==$n1){
								$existe=1;
								
							}
						}
						if($existe==0){
							
							array_push($normas_eliminar, $n->id);
						}
					}
					//Busca y elimina normas sobrantes
					foreach($normas_seleccionadas as $n){
						$existe=0;
						foreach($normas_db as $n1){
							if($n==$n1->id){
								$existe=1;
								echo "<br/>";
							}
						}
						if($existe==0){
							
							array_push($normas_agregar, $n);
						}
					}
				}

				//Eliminar Lineas Sobrantes
				if(count($normas_eliminar)>0){
					$lineas=DB::table('checkls')
								->select('id', 'norma_id')
								->where('check_id', $check->id)
								->wherein('norma_id', $normas_eliminar)
								->orderBy('norma_id')->get();
					foreach($lineas as $ln){
						Checkl::find($ln->id)->delete();
						$check->Norma()->detach($ln->norma_id);
					}
				}

				//Agregar Lineas Faltantes
				if(count($normas_agregar)>0)
					{
					$lineas=DB::table('mchecks')
								->select('a_chequeo', 'norma_id', 'no_conformidad', 'correccion', 'requisito', 'rnc', 'minimo_vsm', 'maximo_vsm')
								->where('a_chequeo', $check->a_chequeo)
								->wherein('norma_id', $normas_agregar)
								->orderBy('norma_id')->orderBy('orden')->get();
					$sm=DB::table('sms')->select('monto')->where('id', '1')->pluck('monto');
					foreach($lineas as $ln){
						$linea=array();
						$linea['a_chequeo']		= $ln->a_chequeo;
						$linea['norma_id']		= $ln->norma_id;
						$linea['no_conformidad']= $ln->no_conformidad;
						$linea['correccion']	= $ln->correccion;
						$linea['requisito']		= $ln->requisito;
						$linea['rnc']			= $ln->rnc;
						$linea['cumplimiento']	= 1;
						$linea['minimo_vsm']	= $ln->minimo_vsm;
						$linea['maximo_vsm']	= $ln->maximo_vsm;
						$linea['monto_min'] 	= $ln->minimo_vsm*$sm;
						$linea['monto_max']   	= $ln->maximo_vsm*$sm;
						$linea['monto_medio'] 	= ($linea['monto_min']+$linea['monto_max'])/2;
						$linea['t_semanas']		= 0;					
						$linea['responsable']	= "";					
						$linea['monto_estimado']= 0;					
						$linea['usu_alta_id'] 	= Sentry::getUser()->id;
						$linea['usu_mod_id']  	= Sentry::getUser()->id;
						$l=new Checkl($linea);
						Check::find($check->id)->ln()->save($l);
						$check->Norma()->attach($ln->norma_id);
					}
				}
			}else{
				return Redirect::route('check.edit', array('id'=>$id, 
														   'normas_seleccionadas'=>$normas_seleccionadas))
					->withInput()
					->withErrors($validation)
					->with('message', 'There were validation errors.');		
			}
		}
		catch(\Exception $e){
			DB::rollback();
    		throw $e;
		}

		DB::commit();
		echo "<pre>";
					echo 'agregar';
					print_r($normas_agregar);
					echo 'eliminar';
					print_r($normas_eliminar);
					echo "</pre>";
		return Redirect::route('check.index');		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->check->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->check->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function lineas($id)
	{
		return Redirect::route('checkl.index', array('id'=>$id));
	}

	public function imprimirGeneral($id){
		
		$check = $this->check->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/checklist/rpt_general.pdf')){
			unlink(base_path() . '/public/reportes/checklist/rpt_general.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/checklist/rpt_general.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    sleep(20);
	    return View::make('checks.rpt_general');	

	}

	public function dictamenGeneral($id){
		
		$check = $this->check->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/checklist/dictamen.pdf')){
			unlink(base_path() . '/public/reportes/checklist/dictamen.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/checklist/dictamen.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    sleep(20);
	    return View::make('checks.dictamen');	

	}

	public function programa($id){
		
		$check = $this->check->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/checklist/programa.pdf')){
			unlink(base_path() . '/public/reportes/checklist/programa.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/checklist/programa.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    sleep(20);
	    return View::make('checks.programa');	

	}

	public function costos($id){
		
		$check = $this->check->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/checklist/costos.pdf')){
			unlink(base_path() . '/public/reportes/checklist/costos.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/checklist/costos.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    sleep(20);
	    return View::make('checks.costos');	
	}

	public function cmbNormas(){
		
		if(Request::ajax()){
			$a_chequeo = e(Input::get('a_chequeo'));
			$normas_seleccionadas=Input::get('normas');
			//$id=$_POST[]
			$final=array();
			$r= DB::table('mchecks')
					->join('normas as n', 'n.id', '=', 'mchecks.norma_id')
					->select('mchecks.norma_id', 'n.norma')
					->where('mchecks.a_chequeo', '=', $a_chequeo)
					->distinct()->get();
			if(isset($normas_seleccionadas) and is_array($normas_seleccionadas)){

				foreach($r as $r1){
					if(in_array($r1->norma_id, $normas_seleccionadas)){
						array_push($final, array('norma_id'=>$r1->norma_id, 
												 'norma'=>$r1->norma, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('norma_id'=>$r1->norma_id, 
												 'norma'=>$r1->norma, 
												 'selectec'=>''));
					}
				}
				return $final;	
			}else{
				return $r;
			}
			
					
		}
	}
}
