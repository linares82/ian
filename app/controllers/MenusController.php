<?php

class MenusController extends BaseController {

	/**
	 * Menus Repository
	 *
	 * @var Menus
	 */
	protected $menu;

	public function __construct(Menu $menu)
	{
		$this->menu = $menu;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('menus.index');
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
		$menus=array();

		$count_rows=$this->menu->id($id)->withTrashed()->count();

		$menus=$this->menu
				->leftJoin('menus as m2', 'menus.depende_de', '=', 'm2.id')
				//->join('users as ua', 'ua.id', '=', 'menus.usu_alta_id')
				//->join('users as um', 'um.id', '=', 'menus.usu_mod_id')
				->select('menus.id', 'menus.item', 'menus.orden', 'm2.item as depende_de', 'menus.link', 
						 'menus.permiso_id', 'menus.target', 'menus.created_at', 'menus.updated_at', 'menus.deleted_at')
				->Id($id)
				->skip($offset)->take($rows)->orderBy('menus.orden')->withTrashed()->get();	
		
		$result["total"] = $count_rows;
		$result["rows"] = $menus;

		echo json_encode($result);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('menus.create');
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
		$validation = Validator::make($input, Menu::$rules, Menu::$rulesMessages);

		if ($validation->passes())
		{
			$this->menu->create($input);

			return Redirect::route('menus.index');
		}

		return Redirect::route('menus.create')
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
		$menu = $this->menu->findOrFail($id);
		
		return View::make('menus.show', compact('menu'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$menu = $this->menu->find($id);
		
		if (is_null($menu))
		{
			return Redirect::route('menus.index');
		}

		return View::make('menus.edit', compact('menu'));
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
		//print_r($input);
		$input['usu_mod_id']=Sentry::getUser()->id;
		$validation = Validator::make($input, Menu::$rules, Menu::$rulesMessages);

		if ($validation->passes())
		{
			$menu = $this->menu->find($id);
			$menu->update($input);

			return Redirect::route('menus.index');
		}

		return Redirect::route('menus.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'Existen errores de validación.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->menu->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}

		//return Redirect::route('menus.index');
	}
	
	
	public function recover($id)
	{
		if ($this->menu->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}

		//return Redirect::route('menus.index');
	}

}
