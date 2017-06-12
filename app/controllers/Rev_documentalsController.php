<?php

class Rev_documentalsController extends BaseController {

	/**
	 * Rev_documental Repository
	 *
	 * @var Rev_documental
	 */
	protected $rev_documental;

	public function __construct(Rev_documental $rev_documental)
	{
		$this->rev_documental = $rev_documental;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$meses_ls=['0' => 'Seleccionar'] + Mese::lists('mes','id');
		return View::make('rev_documentals.index', compact('meses_ls'));
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

		$count_rows=$this->rev_documental->id($id)->Cia($cia)->withTrashed()->count();

		$model=$this->rev_documental
				->select('rev_documentals.id','m.mes', 'rev_documentals.anio', 
					'rev_documentals.created_at', 'rev_documentals.updated_at', 'rev_documentals.deleted_at')
				->join('meses as m', 'm.id', '=', 'rev_documentals.mes_id')
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
		return View::make('rev_documentals.create', compact('meses_ls'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['cia_id']=User::find(Sentry::getUser()->id)->Entidad->id;
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Rev_documental::$rules, Rev_documental::$rulesMessages);

		if ($validation->passes())
		{
			$this->rev_documental->create($input);

			return Redirect::route('rev_documental.index');
		}

		return Redirect::route('rev_documental.create')
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
		$rev_documental = $this->rev_documental->findOrFail($id);

		return View::make('rev_documentals.show', compact('rev_documental'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rev_documental = $this->rev_documental->find($id);

		if (is_null($rev_documental))
		{
			return Redirect::route('rev_documentals.index');
		}
		$meses_ls=['0' => 'Seleccionar'] + Mese::lists('mes','id');
		return View::make('rev_documentals.edit', compact(['rev_documental', 'meses_ls']));
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
		$validation = Validator::make($input, Rev_documental::$rules, Rev_documental::$rulesMessages);

		if ($validation->passes())
		{
			$rev_documental = $this->rev_documental->find($id);
			$rev_documental->update($input);

			return Redirect::route('rev_documental.show', $id);
		}

		return Redirect::route('rev_documental.edit', $id)
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
		if ($this->rev_documental->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->rev_documental->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function lineas($id){
		return Redirect::route('rev_documentoal_ln.index', array('id'=>$id));
	}

	public function imprimirLista($id){
		$usuario=User::find(Sentry::getUser()->id)->username;
		$carpeta=base_path().'/public/reportes/reportes/'.$usuario;
		$img  =  User::find(Sentry::getUser()->id)->Entidad->logo;
		
		if(!file_exists($carpeta)){
			mkdir($carpeta);
		}

		if(file_exists($carpeta . '/revDocumental.pdf')){
			unlink($carpeta . '/revDocumental.pdf');
		}

		JasperPHP::process(
	    base_path() . '/public/reportes/reportes/revDocumental.jasper', 
	    $carpeta . '/revDocumental',
	    array("pdf"), 
	    array('id'=>$id,
	    	  'ruta_img'=>base_path().'/public/uploads/cias/'.$img),
	    Config::get('database.connections.mysql') //DB connection array
	    )
	    ->execute();
	    for($i=0;$i<1000;$i++){
	    	if(!file_exists($carpeta.'/revDocumental.pdf')){
	    		sleep(3);
	    	}else{
	    		sleep(3);
	    		break;
	    	}
	    }
	    return Response::download($carpeta.'/revDocumental.pdf');	    
	}
}
