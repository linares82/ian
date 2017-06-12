<?php

class GroupsController extends BaseController {

	/**
	 * groupe Repository
	 *
	 * @var groupe
	 */
	protected $group;

	public function __construct(Group $group)
	{
		$this->group = $group;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('groups.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$name = isset($_POST['name']) ? strval($_POST['name']) : 0;
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->group->Name($name)->Id($id)->count();

		$model=$this->group
				->select('id', 'name', 'permissions')
				->Name($name)->Id($id)
				->skip($offset)->take($rows)->orderBy($sort, $order)->get();	
		
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
		$permissions=Permission::all();
		return View::make('groups.create', compact('permissions'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// echo "<pre>";
		// print_r(Input::all());
		// echo "</pre>";
		// $input = Input::all();
		// $validation = Validator::make($input, group::$rules_store, group::$rulesMessages);

		// if ($validation->passes())
		// {
		// 	$this->group->create($input);

		// 	return Redirect::route('group.index');
		// }

		// return Redirect::route('group.create')
		// 	->withInput()
		// 	->withErrors($validation)
		// 	->with('message', 'Existen errores de validación.');
		$groupname = Input::get('name');
        $permissions = array();
        
        $errors = $this->_validateGroup(Input::get('permission'), $groupname, $permissions);
        
        if(!empty($errors))
        {
            return Redirect::route('group.create')
		 	->withInput()
		 	->withErrors($errors)
		 	->with('message', 'Existen errores de validación.');
        }
        else 
        {
            try
            {
                // create group
                Sentry::getGroupProvider()->create(array(
                    'name' => $groupname,
                    'permissions' => $permissions,
                ));
            }
            catch (\Cartalyst\Sentry\Groups\NameRequiredException $e) {}
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                //return Response::json(array('groupCreated' => false, 'message' => trans('syntara::groups.messages.exists'), 'messageType' => 'danger'));
                return Redirect::route('group.create')
				 	->withInput()
				 	->withErrors($e)
				 	->with('message', 'Existen errores de validación.');
            }
        }

        return Redirect::route('group.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$group = Sentry::getGroupProvider()->findById($id);
		//$permissions=Permission::all();
		$permissions=DB::Table('permissions')->get();

		$groupPermissions = array();

            foreach($group->permissions as $permissionValue => $key)
            {
                try
                {
                    //$p = Permission::Value($permissionValue)->get()->first();
                    $p = DB::Table('permissions')->where('value', '=', $permissionValue)->first();
                   
                    foreach($permissions as $key => $permission)
                    {
                    	
                        if($p->id === $permission->id)
                        {
                            $groupPermissions[] = $permission;

                            unset($permissions[$key]);
                        }
                    }
                }
                catch(\MrJuliuss\Syntara\Models\Permissions\PermissionNotFoundException $e){}
            }

		return View::make('groups.show', compact('group'))->with(compact('groupPermissions'));
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//$group = $this->group->find($id);
		$group = Sentry::getGroupProvider()->findById($id);
		$permissions=DB::table('permissions')->get();

		$groupPermissions = array();
            foreach($group->permissions as $permissionValue => $key)
            {
                try
                {
                    $p=DB::table('permissions')->where('value', '=', $permissionValue)->first();
                   	// echo "<pre>";
                   	// echo $permissionValue;
                   	// print_r($p);
                   	// echo "</pre>";
                    foreach($permissions as $key => $permission)
                    {
                    	//echo $p['id']."--".$permission->id."<br>";
                        if($p->id === $permission->id)
                        {
                            $groupPermissions[] = $permission;
                            unset($permissions[$key]);
                        }
                    }
                }
                catch(\MrJuliuss\Syntara\Models\Permissions\PermissionNotFoundException $e){}
            }

		if (is_null($group))
		{
			return Redirect::route('group.index');
		}


		return View::make('groups.edit', array('group'=>$group, 'permissions'=>$permissions, 'ownPermissions' => $groupPermissions));
	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		// $input = array_except(Input::all(), '_method');	
		// $validation = Validator::make($input, group::$rules_store, group::$rulesMessages);

		// if ($validation->passes())
		// {
		// 	$group = $this->group->find($id);

		// 	$group->update($input);

		// 	return Redirect::route('group.show', $id);
		// }

		// return Redirect::route('group.edit', $id)
		// 	->withInput()
		// 	->withErrors($validation)
		// 	->with('message', 'Existen errores de validación.');
		$groupname = Input::get('name');
        $permissions = array();

        $errors = $this->_validateGroup(Input::get('permission'), $groupname, $permissions);
        if(!empty($errors))
        {
            return Redirect::route('group.edit', $id)
		 	->withInput()
		 	->withErrors($errors)
		 	->with('message', 'Existen errores de validación.');
        }
        else 
        {
            try
            {
                $group = Sentry::getGroupProvider()->findById($id);
                $group->name = $groupname;
                $group->permissions = $permissions;

                $permissions = (empty($permissions)) ? '' : json_encode($permissions);
                // delete permissions in db
                DB::table('groups')
                    ->where('id', $id)
                    ->update(array('permissions' => $permissions));

                if($group->save())
                {
                    return Redirect::route('group.show', $id);
                }
                else 
                {
                    return Redirect::route('group.edit', $id)
					 	->withInput()
					 	->withErrors($errors)
					 	->with('message', 'Existen errores de validación.');
                }
            }
            catch (\Cartalyst\Sentry\Groups\NameRequiredException $e) {}
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                return Redirect::route('group.edit', $id)
				 	->withInput()
				 	->withErrors($errors)
				 	->with('message', 'Existen errores de validación.');
            }
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->group->find($id)->delete()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}		
	}
	
	public function recover($id)
	{
		if ($this->group->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function duplicate($id)
	{
		$r=Sentry::getGroupProvider()->findById($id);
		if (
			Sentry::getGroupProvider()->create(array(
                    'name' => $r->name."_Copia",
                    'permissions' => $r->permissions,
                ))
			){
			echo json_encode(array('success'=>true));
    	}else{
    		echo json_encode(array('msg'=>'Errores en el proceso.'));
    	}
	}

	/**
     * Validate group informations
     * @param array $permissionsValues
     * @param string $groupname
     * @return array
     */
    protected function _validateGroup($permissionsValues, $groupname, &$permissions)
    {
        $errors = array();
        // validate permissions
        if(!empty($permissionsValues))
        {
            foreach($permissionsValues as $key => $permission)
            {
               $permissions[$key] = 1;
            }
        }
        // validate group name
        // $validation = Validator::make($input, group::$rules_store, group::$rulesMessages);
        //$validator = new GroupValidator(Input::all());
        $validator = Validator::make(Input::all(), group::$rules_store, group::$rulesMessages);

        $gnErrors = array();
        if(!$validator->passes())
        {
            $gnErrors = $validator;
        }
        
        return $gnErrors;
    }

}
