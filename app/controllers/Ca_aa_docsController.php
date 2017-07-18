<?php

class Ca_aa_docsController extends BaseController {

	/**
	 * Ca_aa_doc Repository
	 *
	 * @var Ca_aa_doc
	 */
	protected $ca_aa_doc;

	public function __construct(Ca_aa_doc $ca_aa_doc)
	{
		$this->ca_aa_doc = $ca_aa_doc;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		$categorias_ls=['0' => 'Seleccionar'] + Ca_categorium::lists('categoria','id');
		return View::make('ca_aa_docs.index', array('materiales_ls'=>$materiales_ls, 'categorias_ls'=>$categorias_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cia=User::find(Sentry::getUser()->id)->Entidad->id;
		$result = array();

		$count_rows=0;
		$model=array();
		
		$count_rows=$this->ca_aa_doc->cia($cia)->id($id)->withTrashed()->count();

		$model=$this->ca_aa_doc
				->select('ca_aa_docs.id', 'm.material', 'c.categoria', 
						'ca_aa_docs.doc', 'ca_aa_docs.created_at', 
						'ca_aa_docs.updated_at', 'ca_aa_docs.deleted_at')
				->Join('ca_materiales as m', 'm.id', '=', 'ca_aa_docs.material_id')
				->Join('ca_categoria as c', 'c.id', '=', 'ca_aa_docs.categoria_id')
				->Id($id)->cia($cia)
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
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		$categorias_ls=['0' => 'Seleccionar'] + Ca_categorium::lists('categoria','id');
		return View::make('ca_aa_docs.create', array('materiales_ls'=>$materiales_ls, 
													'categorias_ls'=>$categorias_ls));
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
		$validation = Validator::make($input, Ca_aa_doc::$rules, Ca_aa_doc::$rulesMessages);

		if ($validation->passes())
		{
			$this->ca_aa_doc->create($input);

			return Redirect::route('ca_aa_doc.index');
		}

		return Redirect::route('ca_aa_doc.create')
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
		$ca_aa_doc = $this->ca_aa_doc->findOrFail($id);

		return View::make('ca_aa_docs.show', compact('ca_aa_doc'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ca_aa_doc = $this->ca_aa_doc->find($id);

		if (is_null($ca_aa_doc))
		{
			return Redirect::route('ca_aa_docs.index');
		}
		$materiales_ls=['0' => 'Seleccionar'] + Ca_materiale::lists('material','id');
		$categorias_ls=['0' => 'Seleccionar'] + Ca_categorium::lists('categoria','id');
		return View::make('ca_aa_docs.edit', array('ca_aa_doc'=>$ca_aa_doc, 'materiales_ls'=>$materiales_ls, 
												'categorias_ls'=>$categorias_ls));
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
		$validation = Validator::make($input, Ca_aa_doc::$rules, Ca_aa_doc::$rulesMessages);

		if ($validation->passes())
		{
			$ca_aa_doc = $this->ca_aa_doc->find($id);
			$ca_aa_doc->update($input);

			return Redirect::route('ca_aa_doc.show', $id);
		}

		return Redirect::route('ca_aa_doc.edit', $id)
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
		if ($this->ca_aa_doc->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->ca_aa_doc->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbCategorias(){
		if(Request::ajax()){
			$material = e(Input::get('material_id'));
			$categoria = e(Input::get('categoria_id'));
			$final = array();
			$r = DB::table('ca_categoria as c')
					->select('c.id', 'c.categoria')
					->Join('ca_materiales as m', 'm.id', '=', 'c.material_id')
					->where('c.material_id', '=', $material)
					->distinct()->get();
			if(isset($categoria) and $categoria<>0){
				foreach($r as $r1){
					if($r1->id==$categoria){
						array_push($final, array('id'=>$r1->id, 
												 'categoria'=>$r1->categoria, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->id, 
												 'categoria'=>$r1->categoria, 
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
