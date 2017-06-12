<?php

class Cs_elementos_inspeccionsController extends BaseController {

	/**
	 * Cs_elementos_inspeccion Repository
	 *
	 * @var Cs_elementos_inspeccion
	 */
	protected $cs_elementos_inspeccion;

	public function __construct(Cs_elementos_inspeccion $cs_elementos_inspeccion)
	{
		$this->cs_elementos_inspeccion = $cs_elementos_inspeccion;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$grupo_normas_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		return View::make('cs_elementos_inspeccions.index', array('grupo_normas_ls'=>$grupo_normas_ls, 'normas_ls'=>$normas_ls));
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->cs_elementos_inspeccion->id($id)->withTrashed()->count();

		$model=$this->cs_elementos_inspeccion
				->select('cs_elementos_inspeccions.id', 'gn.grupo_norma', 'n.norma', 
					'cs_elementos_inspeccions.elemento', 'cs_elementos_inspeccions.created_at', 
					'cs_elementos_inspeccions.updated_at', 'cs_elementos_inspeccions.deleted_at')
				->Join('cs_grupo_normas as gn', 'gn.id','=','cs_elementos_inspeccions.grupo_norma_id')
				->Join('cs_normas as n', 'n.id','=', 'cs_elementos_inspeccions.norma_id')
				->Id($id)
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
		$grupo_normas_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		return View::make('cs_elementos_inspeccions.create', array('grupo_normas_ls'=>$grupo_normas_ls, 'normas_ls'=>$normas_ls));
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
		$validation = Validator::make($input, Cs_elementos_inspeccion::$rules, Cs_elementos_inspeccion::$rulesMessages);

		if ($validation->passes())
		{
			$this->cs_elementos_inspeccion->create($input);

			return Redirect::route('cs_elementos_inspeccion.index');
		}

		return Redirect::route('cs_elementos_inspeccion.create')
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
		$cs_elementos_inspeccion = $this->cs_elementos_inspeccion->findOrFail($id);

		return View::make('cs_elementos_inspeccions.show', compact('cs_elementos_inspeccion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_elementos_inspeccion = $this->cs_elementos_inspeccion->find($id);

		if (is_null($cs_elementos_inspeccion))
		{
			return Redirect::route('cs_elementos_inspeccions.index');
		}
		$grupo_normas_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		$normas_ls=['0' => 'Seleccionar'] + Cs_norma::lists('norma','id');
		return View::make('cs_elementos_inspeccions.edit', array('cs_elementos_inspeccion'=>$cs_elementos_inspeccion, 'grupo_normas_ls'=>$grupo_normas_ls, 'normas_ls'=>$normas_ls));
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
		$validation = Validator::make($input, Cs_elementos_inspeccion::$rules, Cs_elementos_inspeccion::$rulesMessages);

		if ($validation->passes())
		{
			$cs_elementos_inspeccion = $this->cs_elementos_inspeccion->find($id);
			$cs_elementos_inspeccion->update($input);

			return Redirect::route('cs_elementos_inspeccion.show', $id);
		}

		return Redirect::route('cs_elementos_inspeccion.edit', $id)
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
		if ($this->cs_elementos_inspeccion->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_elementos_inspeccion->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function cmbNormas(){
		if(Request::ajax()){
			$grupo_norma = e(Input::get('grupo_norma_id'));
			$norma = e(Input::get('norma_id'));
			$final = array();
			$r = DB::table('cs_normas as n')
					->select('n.id', 'n.norma')
					->Join('cs_grupo_normas as gn', 'gn.id', '=', 'n.grupo_norma_id')
					->where('n.grupo_norma_id', '=', $grupo_norma)
					->distinct()->get();
			if(isset($norma) and $norma<>0){
				foreach($r as $r1){
					if($r1->norma_id==$norma){
						array_push($final, array('id'=>$r1->norma_id, 
												 'norma'=>$r1->norma, 
												 'selectec'=>'Selected'));
					}else{
						array_push($final, array('id'=>$r1->norma_id, 
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
