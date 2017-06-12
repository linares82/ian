<?php

class ClientesController extends BaseController {

	/**
	 * Cliente Repository
	 *
	 * @var Cliente
	 */
	protected $cliente;

	public function __construct(Cliente $cliente)
	{
		$this->cliente = $cliente;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('clientes.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$cliente = isset($_POST['cliente']) ? intval($_POST['cliente']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->cliente->id($id)->Cliente($cliente)->withTrashed()->count();

		$model=$this->cliente
				->select('id', 'cliente', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Cliente($cliente)
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
		return View::make('clientes.create');
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
		$validation = Validator::make($input, Cliente::$rules, Cliente::$rulesMessages);

		if ($validation->passes())
		{
			$this->cliente->create($input);

			return Redirect::route('cliente.index');
		}

		return Redirect::route('cliente.create')
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
		$cliente = $this->cliente->findOrFail($id);

		return View::make('clientes.show', compact('cliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cliente = $this->cliente->find($id);

		if (is_null($cliente))
		{
			return Redirect::route('clientes.index');
		}

		return View::make('clientes.edit', compact('cliente'));
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
		$validation = Validator::make($input, Cliente::$rules, Cliente::$rulesMessages);

		if ($validation->passes())
		{
			$cliente = $this->cliente->find($id);
			$cliente->update($input);

			return Redirect::route('cliente.show', $id);
		}

		return Redirect::route('cliente.edit', $id)
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
		if ($this->cliente->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->cliente->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
