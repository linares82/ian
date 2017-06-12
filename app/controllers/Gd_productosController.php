<?php

class Gd_productosController extends BaseController {

	/**
	 * Gd_producto Repository
	 *
	 * @var Gd_producto
	 */
	protected $gd_producto;

	public function __construct(Gd_producto $gd_producto)
	{
		$this->gd_producto = $gd_producto;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('gd_productos.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$producto = isset($_POST['producto']) ? intval($_POST['producto']) : 0;
		$abreviacion = isset($_POST['abreviacion']) ? intval($_POST['abreviacion']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->gd_producto
				->id($id)->Producto($producto)->Abreviacion($abreviacion)
				->withTrashed()->count();

		$model=$this->gd_producto
				->select('id', 'producto', 'abreviacion', 'created_at', 'updated_at', 'deleted_at')
				->Id($id)->Producto($producto)->Abreviacion($abreviacion)
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
		return View::make('gd_productos.create');
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
		$validation = Validator::make($input, Gd_producto::$rules, Gd_producto::$rulesMessages);

		if ($validation->passes())
		{
			$this->gd_producto->create($input);

			return Redirect::route('gd_productos.index');
		}

		return Redirect::route('gd_productos.create')
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
		$gd_producto = $this->gd_producto->findOrFail($id);

		return View::make('gd_productos.show', compact('gd_producto'));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$gd_producto = $this->gd_producto->find($id);

		if (is_null($gd_producto))
		{
			return Redirect::route('gd_producto.index');
		}

		return View::make('gd_productos.edit', compact('gd_producto'));
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
		$validation = Validator::make($input, Gd_producto::$rules, Gd_producto::$rulesMessages);

		if ($validation->passes())
		{
			$gd_producto = $this->gd_producto->find($id);
			$gd_producto->update($input);

			return Redirect::route('gd_producto.show', $id);
		}

		return Redirect::route('gd_producto.edit', $id)
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
		if ($this->gd_producto->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->gd_producto->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

}
