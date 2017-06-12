<?php

class Enc_impactosController extends BaseController {

	/**
	 * Enc_impacto Repository
	 *
	 * @var Enc_impacto
	 */
	protected $enc_impacto;

	public function __construct(Enc_impacto $enc_impacto)
	{
		$this->enc_impacto = $enc_impacto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clientes_ls=['0' => 'Seleccionar'] + Cliente::lists('cliente','id');
		$tipo_impactos_ls=['0' => 'Seleccionar'] + Tipo_impacto::lists('tipo_impacto','id');
		return View::make('enc_impactos.index', array('clientes_ls'=>$clientes_ls, 
													  'tipo_impactos_ls'=>$tipo_impactos_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cliente = isset($_POST['cliente_id']) ? intval($_POST['cliente_id']) : 0;
		$tipo_impacto = isset($_POST['tipo_impacto_id']) ? intval($_POST['tipo_impacto_id']) : 0;
		$fecha = isset($_POST['fecha']) ? strval($_POST['fecha']) : 0;
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->getCia();
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->enc_impacto
				->id($id)->Cliente($cliente)->TipoImpacto($tipo_impacto)->Fecha($fecha)->Cia($cia)
				->withTrashed()->count();

		$model=$this->enc_impacto
				->join('clientes as c', 'c.id', '=','enc_impactos.cliente_id')
				->join('tipo_impactos as ti', 'ti.id', '=', 'enc_impactos.tipo_impacto_id')
				->select('enc_impactos.id', 'enc_impactos.proyecto','c.cliente', 'ti.tipo_impacto',
						 'enc_impactos.fecha_inicio', 'enc_impactos.fecha_fin', DB::raw('IF(enc_impactos.fecha_fin<=CURDATE(),(DATEDIFF(CURDATE(), enc_impactos.fecha_inicio)),0) as dias'),
						 'enc_impactos.created_at', 'enc_impactos.updated_at', 'enc_impactos.deleted_at')
				->Id($id)->Cliente($cliente)->TipoImpacto($tipo_impacto)->Fecha($fecha)->Cia($cia)
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
		$tipo_impactos_ls=['0' => 'Seleccionar'] + Tipo_impacto::lists('tipo_impacto','id');
		return View::make('enc_impactos.create', array('clientes_ls'=>$clientes_ls, 'tipo_impactos_ls'=>$tipo_impactos_ls));
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
		$input['fecha_inicio']=(Input::get('fecha_inicio')=="") ? Null : Input::get('fecha_inicio');
		$input['fecha_fin']=(Input::get('fecha_fin')=="") ? Null : Input::get('fecha_fin');
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$validation = Validator::make($input, Enc_impacto::$rules, Enc_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$this->enc_impacto->create($input);

			return Redirect::route('enc_impacto.index');
		}

		return Redirect::route('enc_impacto.create')
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
		$enc_impacto = $this->enc_impacto->findOrFail($id);
		
		return View::make('enc_impactos.show', array('enc_impacto'=>$enc_impacto));
	}

	public function imprimir($id){
		
		$enc_impacto = $this->enc_impacto->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/enc_impacto/enc_impacto.pdf')){
			unlink(base_path() . '/public/reportes/enc_impacto/enc_impacto.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/enc_impacto/enc_impacto.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    //sleep(20);
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists(base_path() . '/public/reportes/enc_impacto/enc_impacto.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return View::make('enc_impactos.reportes');	

	    //echo link_to('reportes/enc_impacto/enc_impacto.pdf',  'Ver Reporte', $attributes = array('target'=>'blank', 'class' => 'easyui-linkbutton'), $secure = null);
	    //echo link_to_route('enc_impacto.index', 'Regresar', $id, array('class' => 'easyui-linkbutton', 'style'=>'height:30px;width:100px;')); 

		/*$reg_impactos = Enc_impacto::find($id)->reg_impactos;
		$total=DB::table('reg_impactos')->select('ln.id')
							->where('enc_impacto_id', '=', $id)
							->join('ln_caracteristicas as ln', 'ln.reg_impacto_id', '=', 'reg_impactos.id')
							->join('efectos as e', 'e.id', '=', 'ln.efecto_id')
							->where('ln.efecto_id', '>', '1')
							->count('ln.efecto_id');
		$segmentos=DB::table('reg_impactos')->where('enc_impacto_id', '=', $id)
							->join('ln_caracteristicas as ln', 'ln.reg_impacto_id', '=', 'reg_impactos.id')
							->join('efectos as e', 'e.id', '=', 'ln.efecto_id')
							->where('ln.efecto_id', '>', '1')
							->select('e.efecto', DB::raw('count(e.efecto) as total'))
							->groupBy('e.efecto')->get();
		
		return View::make('enc_impactos.imprimir', array('enc_impacto'=>$enc_impacto,'total'=>$total, 'segmentos'=>$segmentos,));	
		*/
		
		

	}

	public function imprimir2($id){
		
		$enc_impacto = $this->enc_impacto->findOrFail($id);
		$efectos = Efecto::where('id','>', '1')->get();
		
		$total=DB::table('reg_impactos')->select('ln.id')
							->where('enc_impacto_id', '=', $id)
							->join('ln_caracteristicas as ln', 'ln.reg_impacto_id', '=', 'reg_impactos.id')
							->join('efectos as e', 'e.id', '=', 'ln.efecto_id')
							->where('ln.efecto_id', '>', '1')
							->count('ln.efecto_id');
		$segmentos=DB::table('reg_impactos')->where('enc_impacto_id', '=', $id)
							->join('ln_caracteristicas as ln', 'ln.reg_impacto_id', '=', 'reg_impactos.id')
							->join('efectos as e', 'e.id', '=', 'ln.efecto_id')
							->where('ln.efecto_id', '>', '1')
							->select('e.efecto', DB::raw('count(e.efecto) as total'))
							->groupBy('ln.efecto_id')->get();
		
		return View::make('enc_impactos.imprimir2', 
					array('enc_impacto'=>$enc_impacto, 
						'efectos'=>$efectos, 
						'total'=>$total, 
						'segmentos'=>$segmentos));	
		/*Excel::create('archivo', function($excel) use($enc_impacto, $efectos, $total, $segmentos) {
    		$excel->sheet('Hoja', function($sheet) use($enc_impacto, $efectos, $total, $segmentos){
	        	$sheet->loadView('enc_impactos.imprimir2', array('enc_impacto'=>$enc_impacto, 
							'efectos'=>$efectos, 
							'total'=>$total, 
							'segmentos'=>$segmentos));
	        	$sheet->setStyle(array(
				    'font' => array(
				        'name'      =>  'Arial',
				        'size'      =>  8
				    )
				));
    		});

		})->download('xls');*/
			
		/*
		Excel::create('New file', function($excel) use($enc_impacto, $efectos,
						  $caracteristicas, $emision_efectos, $duracion_acciones,
						  $continuidad_efectos, $emision_efectos, $reversibilidades,
						  $probabilidades, $mitigaciones, $intensidad_impactos) {
		    $excel->sheet('New sheet', function($sheet) use($enc_impacto, $efectos,
						  $caracteristicas, $emision_efectos, $duracion_acciones,
						  $continuidad_efectos, $emision_efectos, $reversibilidades,
						  $probabilidades, $mitigaciones, $intensidad_impactos) {
		        $sheet->loadView('enc_impactos.imprimir2', array('enc_impacto'=>$enc_impacto, 'efectos'=>$efectos,
						  'caracteristicas'=>$caracteristicas, 'emision_efectos'=>$emision_efectos, 'duracion_acciones'=>$duracion_acciones,
						  'continuidad_efectos'=>$continuidad_efectos, 'emision_efectos'=>$emision_efectos, 'reversibilidades'=>$reversibilidades,
						  'probabilidades'=>$probabilidades, 'mitigaciones'=>$mitigaciones, 'intensidad_impactos'=>$intensidad_impactos));
		    });
		})->export('xls');*/
		

	}

	public function grfPie($id){
		
		$enc_impacto = $this->enc_impacto->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/enc_impacto/enc_impacto_pie.pdf')){
			unlink(base_path() . '/public/reportes/enc_impacto/enc_impacto_pie.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/enc_impacto/enc_impacto_pie.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id, 'proyecto'=>$enc_impacto->proyecto),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    //sleep(20);
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists(base_path() . '/public/reportes/enc_impacto/enc_impacto_pie.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return View::make('enc_impactos.reportes_pie');	
	}

	public function grfBarras($id){
		
		$enc_impacto = $this->enc_impacto->findOrFail($id);
		if(file_exists(base_path() . '/public/reportes/enc_impacto/enc_impacto_barras.pdf')){
			unlink(base_path() . '/public/reportes/enc_impacto/enc_impacto_barras.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/enc_impacto/enc_impacto_barras.jasper', 
	    false, 
	    array("pdf"), 
	    array('id'=>$id, 'proyecto'=>$enc_impacto->proyecto),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists(base_path() . '/public/reportes/enc_impacto/enc_impacto_barras.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return View::make('enc_impactos.reportes_barras');	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$enc_impacto = $this->enc_impacto->find($id);
		if (is_null($enc_impacto))
		{
			return Redirect::route('enc_impactos.index');
		}

		$clientes_ls=['0' => 'Seleccionar'] + Cliente::lists('cliente','id');
		$tipo_impactos_ls=['0' => 'Seleccionar'] + Tipo_impacto::lists('tipo_impacto','id');

		return View::make('enc_impactos.edit', array('clientes_ls'=>$clientes_ls, 'tipo_impactos_ls'=>$tipo_impactos_ls, 
													'enc_impacto'=>$enc_impacto));
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
		$input['fecha_inicio']=(Input::get('fecha_inicio')=="") ? Null : Input::get('fecha_inicio');
		$input['fecha_fin']=(Input::get('fecha_fin')=="") ? Null : Input::get('fecha_fin');
		$validation = Validator::make($input, Enc_impacto::$rules, Enc_impacto::$rulesMessages);

		if ($validation->passes())
		{
			$enc_impacto = $this->enc_impacto->find($id);
			$enc_impacto->update($input);

			return Redirect::route('enc_impacto.show', $id);
		}

		return Redirect::route('enc_impacto.edit', $id)
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
		if ($this->enc_impacto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->enc_impacto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function lineas($id)
	{
		return Redirect::route('reg_impacto.index', array('id'=>$id));
	}

	public function documentos($id)
	{

		return Redirect::route('documento.index', array('id'=>$id));
	}
}
