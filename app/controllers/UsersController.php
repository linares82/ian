<?php

class UsersController extends BaseController {

	/**
	 * usere Repository
	 *
	 * @var usere
	 */
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		return View::make('users.index');
	}
	
	public function contentListIndex(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$offset = ($page-1)*$rows;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$username = isset($_POST['username']) ? strval($_POST['username']) : 0;
		$email = isset($_POST['email']) ? strval($_POST['email']) : 0;
		$baneado = isset($_POST['baneado']) ? intval($_POST['baneado']) : 0;
		
		$result = array();

		$count_rows=0;
		$model=array();

		$count_rows=$this->user->Id($id)->username($username)->Email($email)->count();

		$model=$this->user
				->Leftjoin('throttle', 'throttle.user_id', '=', 'users.id')
				->Leftjoin('bnds as b_activated', 'b_activated.id', '=', 'users.activated')
				->Leftjoin('bnds as b_banned', 'b_banned.id', '=', 'throttle.banned')
				->Leftjoin('bnds as b_suspended', 'b_suspended.id', '=', 'throttle.suspended')
				->select('users.id', 'users.username', 'users.email', 'b_activated.bnd as activated', 
						 'b_banned.bnd as banned', 'throttle.attempts', 'b_suspended.bnd as suspended')
				->Id($id)->username($username)->Email($email)
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
		$groups = Sentry::getGroupProvider()->findAll();
		//$permissions = Permission::All();
		$permissions=DB::Table('permissions')->get();
		return View::make('users.create', array('groups'=>$groups, 'permissions'=>$permissions));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try{
			$input = Input::all();
			$validation = Validator::make($input, user::$rules_store, user::$rulesMessages);

			$permissionsValues = Input::get('permission');
			$permissions = $this->_formatPermissions($permissionsValues);

			if (!$validation->passes())
			{
				return Redirect::route('user.create')
						->withInput()
						->withErrors($validation)
						->with('message', 'Existen errores de validación.');	
			}

			$multi_entidad=$this->mEntidad(Input::get('multi_entidad'));
            

			$user = Sentry::getUserProvider()->create(array(
	                'email'    => Input::get('email'),
	                'password' => Input::get('password'),
	                'username' => Input::get('username'),
	                'last_name' => (string)Input::get('last_name'),
	                'first_name' => (string)Input::get('first_name'),
	                'multi_entidad'=>$multi_entidad,
	                'entidad_id'=>Input::get('entidad_id'),
	                'empleado_id'=>Input::get('empleado_id'),
	                'permissions' => $permissions
	            ));
			//genera la linea en throttle
			$throttle = Sentry::getThrottleProvider()->findByUserId($user->getId());

			$activationCode = $user->getActivationCode();
	        if(Config::get('app.sentry-user-activation') === 'auto')
	        {
	            $user->attemptActivation($activationCode);
	        }
	        elseif(Config::get('app.sentry-user-activation') === 'email')
	        {
	            $datas = array(
	                'code' => $activationCode,
	                'username' => $user->username
	            );

	            // send email
	            Mail::queue('mail.user-activation', $datas, function($message) use ($user)
	            {
	                $message->from(Config::get('app.sentry-email'), Config::get('app.sentry-contact'))
	                        ->subject(Config::get('app.sentry-user-activation-object'));
	                $message->to($user->getLogin());
	            });
	        }

	        $groups = Input::get('groups');
	        if(isset($groups) && is_array($groups))
	        {
	            foreach($groups as $groupId)
	            {
	                $group = Sentry::getGroupProvider()->findById($groupId);
	                $user->addGroup($group);
	            }
	        }
	    }
	    catch (\Cartalyst\Sentry\Users\LoginRequiredException $e){} // already catch by validators
        catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e){} // already catch by validators
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e){}
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            return Redirect::route('user.create')
						->withInput()
						->withErrors("Usuario ya existe.")
						->with('message', 'Usuario ya existe.');
        }
        catch(\Exception $e)
        {
            return Redirect::route('user.create')
						->withInput()
						->withErrors('Error en la creación.')
						->with('message', 'Existen errores.');
        }
		
		Redirect::route('user.index');
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUserProvider()->findById($id);
		$throttle = Sentry::getThrottleProvider()->findByUserId($id);
        $groups = Sentry::getGroupProvider()->findAll();
		//$permissions = PermissionProvider::findAll();
		$permissions=DB::Table('permissions')->get();
        $userPermissions = array();
        foreach($user->getPermissions() as $permissionValue => $key)
        {
            try
            {
                $p = PermissionProvider::findByValue($permissionValue);
                foreach($permissions as $key => $permission)
                {
                    if($p->getId() === $permission->getId())
                    {
                        $userPermissions[] = $permission;
                        unset($permissions[$key]);
                    }
                }
            }
            catch(\MrJuliuss\Syntara\Models\Permissions\PermissionNotFoundException $e){}
        }

		return View::make('users.show', array(
                'user' => $user,
                'throttle' => $throttle,
                'groups' => $groups,
                'userPermissions' => $userPermissions,
                'permissions' => $permissions
            ));
	}

	public function getPerfil()
	{
		try
        {
			$user = Sentry::getUser();
			
            return View::make('users.perfil', array(
                'user' => $user,
            ));
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            //$this->layout = View::make(Config::get('syntara::views.error'), array('message' => trans('syntara::users.messages.not-found')));
        }

	}

	public function postPerfil()
	{

		try
        {
        	$input = array_except(Input::all(), '_method');	

            $user = Sentry::getUser();
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->last_name = Input::get('last_name');
            $user->first_name = Input::get('first_name');;
            $user->multi_entidad = $user->multi_entidad;
            $user->permissions = $user->permissions;

            $enti=Input::get('entidad_id');;
            if(!empty($enti)){
            	$user->entidad_id=$enti;
            }

            $pass = Input::get('password');
            if(!empty($pass))
            {
                $user->password = $pass;
            }
            /*else{
            	$user->password = $user->password;
            }*/

            // Update the user
            if($user->save())
            {
                return Redirect::route('inicio');
                //echo "Registro Actualizado, actuaizar navegador";
            }
            else 
            {
                //return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.update-fail'), 'messageType' => 'danger'));
                return Redirect::route('user.postPerfil', $user->getId())
					->withInput()
					->withErrors('Actualización no pudo realizarse.')
					->with('message', 'Actualización no pudo realizarse.');
            }
            

        }
        catch(\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            //return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.user-email-exists'), 'messageType' => 'danger'));
             return Redirect::route('user.postPerfil', $user->getId())
					->withInput()
					->withErrors('Email ya existe.')
					->with('message', 'Email ya existe.');
        }
        catch(\Exception $e)
        {
            //return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.user-name-exists'), 'messageType' => 'danger'));
            return Redirect::route('user.postPerfil', $user->getId())
					->withInput()
					->withErrors('Usuario ya existe.')
					->with('message', 'Usuario ya existe.');
        }

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try
        {
			$user = Sentry::getUserProvider()->findById($id);
			$user_me= User::find($id);
            $throttle = Sentry::getThrottleProvider()->findByUserId($id);
            $groups = Sentry::getGroupProvider()->findAll();

            // get user permissions
            $permissions=DB::Table('permissions')->get();
            $userPermissions = array();
            //print_r($permissions);
            foreach($user->permissions as $permissionValue => $key)
            {
                try
                {
                    $p = Permission::Value($permissionValue)->first();
                    foreach($permissions as $key => $permission)
                    {
                        if($p->id === $permission->id)
                        {
                            $userPermissions[] = $permission;
                            unset($permissions[$key]);
                        }
                    }
                }
                catch(\MrJuliuss\Syntara\Models\Permissions\PermissionNotFoundException $e){}
            }


            return View::make('users.edit', array(
                'user' => $user,
                'user_me'=>$user_me,
                'throttle' => $throttle,
                'groups' => $groups,
                'ownPermissions' => $userPermissions,
                'permissions' => $permissions
            ));
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            //$this->layout = View::make(Config::get('syntara::views.error'), array('message' => trans('syntara::users.messages.not-found')));
        }

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		try
        {
        	$input = array_except(Input::all(), '_method');	

			$validation = Validator::make($input, user::$rules_update, user::$rulesMessages);
			
			if (!$validation->passes())
			{
				 return Redirect::route('user.edit', $id)
				 	->withInput()
				 	->withErrors($validation)
				 	->with('message', 'Existen errores de validación.');
			}
			
			$permissionsValues = Input::get('permission');
            $permissions = $this->_formatPermissions($permissionsValues);

            $multi_entidad=$this->mEntidad(Input::get('multi_entidad'));
            // Find the user using the user id
            $user = Sentry::getUserProvider()->findById($id);
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->last_name = Input::get('last_name');
            $user->first_name = Input::get('first_name');
            $user->multi_entidad = $multi_entidad;
            $user->entidad_id=Input::get('entidad_id');
            $user->empleado_id=Input::get('empleado_id');
            $user->permissions = $permissions;

            $permissions = (empty($permissions)) ? '' : json_encode($permissions);
            
            DB::table('users')
                ->where('id', $id)
                ->update(array('permissions' => $permissions));

            $pass = Input::get('password');
            if(!empty($pass))
            {
                $user->password = $pass;
            }
            

            // Update the user
            if($user->save())
            {
                // if the user has permission to update
                $banned = Input::get('banned');
                if(isset($banned) && Sentry::getUser()->getId() !== $user->getId())
                {
                    $this->_banUser($id, $banned);
                }

                
                $groups = (Input::get('groups') === null) ? array() : Input::get('groups');
                $userGroups = $user->getGroups()->toArray();
                
                foreach($userGroups as $group)
                {
                    if(!in_array($group['id'], $groups))
                    {
                        $group = Sentry::getGroupProvider()->findById($group['id']);
                        $user->removeGroup($group);
                    }
                }
                if(isset($groups) && is_array($groups))
                {
                    foreach($groups as $groupId)
                    {
                        $group = Sentry::getGroupProvider()->findById($groupId);
                        $user->addGroup($group);
                    }
                }
                

                return Redirect::route('user.show', $id);
            }
            else 
            {
                //return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.update-fail'), 'messageType' => 'danger'));
                return Redirect::route('user.edit', $id)
					->withInput()
					->withErrors('Actualización no pudo realizarse.')
					->with('message', 'Actualización no pudo realizarse.');
            }
            

        }
        catch(\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            //return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.user-email-exists'), 'messageType' => 'danger'));
             return Redirect::route('user.edit', $id)
					->withInput()
					->withErrors('Email ya existe.')
					->with('message', 'Email ya existe.');
        }
        catch(\Exception $e)
        {
            //return Response::json(array('userUpdated' => false, 'message' => trans('syntara::users.messages.user-name-exists'), 'messageType' => 'danger'));
            return Redirect::route('user.edit', $id)
					->withInput()
					->withErrors('Usuario ya existe.')
					->with('message', 'Usuario ya existe.');
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
		// if ($this->user->find($id)->delete()){
		// 	echo json_encode(array('success'=>true));
		// }else{
		// 	echo json_encode(array('msg'=>'Errores en el proceso.'));
		// }		
		try
        {
            if($id !== Sentry::getUser()->getId())
            {
                $user = Sentry::getUserProvider()->findById($id);
                $user->delete();
                
            }
            else
            {
                //return Response::json(array('deletedUser' => false, 'message' => trans('syntara::users.messages.remove-own-user'), 'messageType' => 'danger'));
                echo json_encode(array('msg'=>'No se puede borrar el usuario propio.'));
            }
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            //return Response::json(array('deletedUser' => false, 'message' => trans('syntara::users.messages.not-found'), 'messageType' => 'danger'));
            echo json_encode(array('msg'=>'Usuario no encontrado.'));
        }

        echo json_encode(array('success'=>true));
	}
	
	public function recover($id)
	{
		if ($this->user->withTrashed()->find($id)->restore()){
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('msg'=>'Errores en el proceso.'));
		}
	}

	public function unblock($id)
	{
		try
			{
			    // Find the user using the user id
			    $throttle = Sentry::findThrottlerByUserId($id);

			    // Unsuspend the user
			    $throttle->unsuspend();
			    
			    echo json_encode(array('success'=>true));
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    echo json_encode(array('msg'=>'Errores en el proceso.'));
			}
	}

	protected function _formatPermissions($permissionsValues)
    {
        $permissions = array();
        if(!empty($permissionsValues))
        {
            foreach($permissionsValues as $key => $permission)
            {
               $permissions[$key] = 1;
            }
        }

        return $permissions;
    }

    protected function _banUser($userId, $value)
    {
        $throttle = Sentry::findThrottlerByUserId($userId);
        if($value === 'no' && $throttle->isBanned() === true)
        {
            $throttle->unBan();
        }
        elseif($value === 'yes' && $throttle->isBanned() === false)
        {
            $throttle->ban();
        }
    }

    /**
     * Activate a user (from an email)
     * @param  string $activationCode
     */
    public function getActivate($activationCode)
    {
        $activated = false;
        try
        {
            // Find the user using the activation code
            $user = Sentry::getUserProvider()->findByActivationCode($activationCode);

            // Attempt to activate the user
            if($user->attemptActivation($activationCode))
            {
                $message = "Tu cuenta fue activada con exito.";
                $activated = true;
            }
            else
            {
                // User activation failed
                $message = "Tu cuenta no pudo ser activada.";
            }
        }
        catch(\Exception $e)
        {
            // User not found, activation found or other errors
            $message = "Tu cuenta no pudo ser activada.";
        }

        $this->layout = View::make('users.activation', array('activated' => $activated, 'message' => $message));
    }

    public function mEntidad($value){
    	if($value==="no")
            {
                return False;
            }else{
            	return True;
            }
    }

    public function bannedReg($id){
    	$u=$this->user->find($id);
    	$throttle = Sentry::getThrottleProvider()->findByUserId($id);
    	if ($throttle->isBanned()===False){
			$this->_banUser($id, 'yes');
			echo json_encode(array('success'=>true));
		}else{
			$this->_banUser($id, 'no');
			echo json_encode(array('success'=>true));
		}
		//echo json_encode(array('msg'=>'Errores en el proceso.'));
    }
}

