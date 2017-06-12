<?php

class DocumentosController extends BaseController {

	/**
	 * Documento Repository
	 *
	 * @var Documento
	 */
	protected $documento;
	protected $enc_impacto;

	public function __construct(Documento $documento)
	{
		$this->documento = $documento;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->enc_impacto=$_GET['id'];
		return View::make('documentos.index', array('enc_impacto'=>$this->enc_impacto));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$enc_impacto_id = isset($_REQUEST['enc_impacto_id']) ? intval($_REQUEST['end_impacto_id']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->documento->id($id)->EncImpactoId($enc_impacto_id)->withTrashed()->count();

		$model=$this->documento
				->join('doc_proyectos as dp', 'dp.id', '=', 'documentos.doc_proyecto_id')
				->select('documentos.id', 'dp.documento', 'documentos.created_at', 'documentos.updated_at', 'documentos.deleted_at')
				->Id($id)->EncImpactoId($enc_impacto_id)
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
		$doc_proyectos_ls=['0' => 'Seleccionar'] + Doc_proyecto::lists('documento', 'id');
		$enc_impacto=e(Input::get('id'));
		$documento=$this->documento;
		$documento->enc_impacto_id=$enc_impacto;
		return View::make('documentos.create', array('doc_proyectos_ls'=>$doc_proyectos_ls, 
												'enc_impacto'=>$enc_impacto, 'documento'=>$documento));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//$input = Input::all();
		$input['enc_impacto_id']=Input::get('enc_impacto_id');
		$input['doc_proyecto_id']=Input::get('doc_proyecto_id');
		$input['nota']=Input::get('nota');
		
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Documento::$rules, Documento::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('archivo')){
				$input['documento']=Input::file('archivo')->getClientOriginalName();	

			}
			if(!Input::hasFile('archivo')){
				$input['documento']='';
			}

			//print_r(e(Input::get('enc_impacto_id')));

			if ($this->documento->create($input)){
				if(Input::hasFile('archivo')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('archivo')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/enc_impacto', Input::file('archivo')->getClientOriginalName());
				}
			}

			return Redirect::route('documento.index', array('id'=>$input['enc_impacto_id']));
			
		}	
/*
		return Redirect::route('documento.create', array('id'=>$input['enc_impacto_id']))
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
		$documento = $this->documento->findOrFail($id);		
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
		return View::make('documentos.show', array('documento'=>$documento, 'cia'=>$cia, 'usuario'=>$usuario));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$documento = $this->documento->find($id);
		if (is_null($documento))
		{
			return Redirect::route('documentos.index');
		}
		$doc_proyectos_ls=['0' => 'Seleccionar'] + Doc_proyecto::lists('documento', 'id');

		return View::make('documentos.edit', array('documento'=>$documento, 'doc_proyectos_ls'=>$doc_proyectos_ls));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//$input = array_except(Input::all(), '_method');

		$input['enc_impacto_id']=Input::get('enc_impacto_id');
		$input['doc_proyecto_id']=Input::get('doc_proyecto_id');
		$input['nota']=Input::get('nota');
		
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Documento::$rules, Documento::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$documento = $this->documento->find($id);
		

			if(Input::hasFile('archivo')){
				if($documento->documento<>Input::file('archivo')->getClientOriginalName() and $documento->documento<>"") {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/enc_impacto/'.$documento->documento);
				}
				$input['documento']=Input::file('archivo')->getClientOriginalName();	

			}
			if(!Input::hasFile('archivo')){
				$input['documento']='';
			}

			//print_r($_POST);

			if ($documento->update($input)){
				if(Input::hasFile('archivo')){
					
					Input::file('archivo')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/enc_impacto', Input::file('archivo')->getClientOriginalName());
				}
			}

			return Redirect::route('documento.show', $id);
		}

		return Redirect::route('documento.edit', $id)
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
		if ($this->documento->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->documento->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
