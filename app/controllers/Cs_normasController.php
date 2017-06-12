<?php

class Cs_normasController extends BaseController {

	/**
	 * Cs_norma Repository
	 *
	 * @var Cs_norma
	 */
	protected $cs_norma;

	public function __construct(Cs_norma $cs_norma)
	{
		$this->cs_norma = $cs_norma;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$grupo_normas_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		return View::make('cs_normas.index', array('grupo_normas_ls'=>$grupo_normas_ls));
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

		$count_rows=$this->cs_norma->id($id)->withTrashed()->count();

		$model=$this->cs_norma
				->select('cs_normas.id', 'gn.grupo_norma', 'cs_normas.norma', 'cs_normas.archivo', 
					'cs_normas.created_at', 'cs_normas.updated_at', 'cs_normas.deleted_at')
				->Join('cs_grupo_normas as gn', 'gn.id', '=', 'cs_normas.grupo_norma_id')
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
		return View::make('cs_normas.create', array('grupo_normas_ls'=>$grupo_normas_ls));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		unset($input['file']);
		$input['usu_alta_id']=Sentry::getUser()->id;
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Cs_norma::$rules, Cs_norma::$rulesMessages);

		if ($validation->passes())
		{
			if(Input::hasFile('file')){
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']='';
			}

			
			if($this->cs_norma->create($input)){
				if(Input::hasFile('file')){
					$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
					$usuario=User::find(Sentry::getUser()->id)->username;
					Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/cs_normas', Input::file('file')->getClientOriginalName());
				}
			}

			return Redirect::route('cs_norma.index');
		}

		return Redirect::route('cs_norma.create')
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
		$cs_norma = $this->cs_norma->findOrFail($id);
		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;
		return View::make('cs_normas.show', array('cs_norma'=>$cs_norma, 'cia'=>$cia, 'usuario'=>$usuario));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cs_norma = $this->cs_norma->find($id);

		if (is_null($cs_norma))
		{
			return Redirect::route('cs_normas.index');
		}
		$grupo_normas_ls=['0' => 'Seleccionar'] + Cs_grupo_norma::lists('grupo_norma','id');
		return View::make('cs_normas.edit', array('cs_norma'=>$cs_norma, 'grupo_normas_ls'=>$grupo_normas_ls));
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
		unset($input['file']);
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Cs_norma::$rules, Cs_norma::$rulesMessages);

		$cia=User::find(Sentry::getUser()->id)->Entidad->rzon_social;
		$usuario=User::find(Sentry::getUser()->id)->username;

		if ($validation->passes())
		{
			$cs_norma = $this->cs_norma->find($id);
			
			if(Input::hasFile('file')){
				if($cs_norma->archivo<>Input::file('file')->getClientOriginalName() 
					and $cs_norma->archivo<>""
					and file_exists(public_path().'/uploads/'.$cia.'/'.$usuario.'/cs_normas/'.$cs_norma->archivo)) {
					unlink(public_path().'/uploads/'.$cia.'/'.$usuario.'/cs_normas/'.$cs_norma->archivo);
				}
				$input['archivo']=Input::file('file')->getClientOriginalName();	

			}
			if(!Input::hasFile('file')){
				$input['archivo']=$input['archivo'];
			}

			if($cs_norma->update($input) and Input::hasFile('file')){
				Input::file('file')->move(public_path().'/uploads/'.$cia.'/'.$usuario.'/cs_normas', Input::file('file')->getClientOriginalName());
			}

			return Redirect::route('cs_norma.show', $id);
		}

		return Redirect::route('cs_norma.edit', $id)
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
		if ($this->cs_norma->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cs_norma->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
