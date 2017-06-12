<?php

class Rev_requisitosController extends BaseController {

	/**
	 * Rev_requisito Repository
	 *
	 * @var Rev_requisito
	 */
	protected $rev_requisito;

	public function __construct(Rev_requisito $rev_requisito)
	{
		$this->rev_requisito = $rev_requisito;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$meses_ls=['0' => 'Seleccionar'] + Mese::lists('mes','id');
		return View::make('rev_requisitos.index', compact('meses_ls'));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$result = array();
		$cia=0;
		$cia=User::find(Sentry::getUser()->id)->Entidad->id;

		$count_rows=0;
		$model=array();

		$count_rows=$this->rev_requisito->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->rev_requisito
				->select('rev_requisitos.id', 'm.mes', 'rev_requisitos.anio', 
					'rev_requisitos.created_at', 'rev_requisitos.updated_at', 'rev_requisitos.deleted_at')
				->join('meses as m', 'm.id', '=', 'rev_requisitos.mes_id')
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
		$meses_ls=['0' => 'Seleccionar'] + Mese::lists('mes','id');
		return View::make('rev_requisitos.create', compact('meses_ls'));
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
		$validation = Validator::make($input, Rev_requisito::$rules, Rev_requisito::$rulesMessages);

		if ($validation->passes())
		{
			$this->rev_requisito->create($input);

			return Redirect::route('rev_requisito.index');
		}

		return Redirect::route('rev_requisito.create')
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
		$rev_requisito = $this->rev_requisito->findOrFail($id);

		return View::make('rev_requisitos.show', compact('rev_requisito'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rev_requisito = $this->rev_requisito->find($id);

		if (is_null($rev_requisito))
		{
			return Redirect::route('rev_requisitos.index');
		}
		$meses_ls=['0' => 'Seleccionar'] + Mese::lists('mes','id');
		return View::make('rev_requisitos.edit', compact(['rev_requisito', 'meses_ls']));
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
		$validation = Validator::make($input, Rev_requisito::$rules, Rev_requisito::$rulesMessages);

		if ($validation->passes())
		{
			$rev_requisito = $this->rev_requisito->find($id);
			$rev_requisito->update($input);

			return Redirect::route('rev_requisito.show', $id);
		}

		return Redirect::route('rev_requisito.edit', $id)
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
		if ($this->rev_requisito->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->rev_requisito->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function lineas($id){
		return Redirect::route('rev_requisitos_ln.index', array('id'=>$id));
	}

	public function imprimirLista($id){
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/revRequisitos.pdf')){
			unlink($carpeta . '/revRequisitos.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/reportes/revRequisitos.jasper', 
	    $carpeta . '/revRequisitos',
	    array("pdf"), 
	    array('id'=>$id,
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/revRequisitos.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/revRequisitos.pdf');	    
	}
}
