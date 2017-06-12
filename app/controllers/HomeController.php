<?php
//use MrJuliuss\Syntara\Controllers\BaseController;
use MrJuliuss\Syntara\Services\Validators\User as UserValidator;
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
        $cia=User::find(Sentry::getUser()->id)->Entidad->id;
        $logo=User::find(Sentry::getUser()->id)->Entidad->logo;
        Artisan::call('ian:envioCorreos');
		return View::make('inicio.inicio', compact('logo'));
		
	}
	
	public function getLogin()
	{
		return View::make('inicio.login1');
		
	}
	
	 /**
    * Login post authentication
    */
    public function postLogin()
    {
        try
        {
            $validator = new UserValidator(Input::all(), 'login');
            $loginAttribute = Config::get('cartalyst/sentry::users.login_attribute');

            if(!$validator->passes())
            {
                 return Response::json(array('logged' => false, 'errorMessages' => $validator->getErrors()));
            }

            $credentials = array(
                $loginAttribute => Input::get('username'),
                'password' => Input::get('pass'),
            );

            // authenticate user
            
            Sentry::authenticate($credentials, Input::get('remember'));
        }
        catch(\Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            return Response::json(array('logged' => false, 'errorMessage' => trans('syntara::all.messages.banned'), 'errorType' => 'danger'));
        }
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            return Response::json(array('logged' => false, 'errorMessage' => trans('syntara::all.messages.suspended'), 'errorType' => 'danger'));
        }
        catch (\RuntimeException $e)
        {
            return Response::json(array('logged' => false, 'errorMessage' => trans('syntara::all.messages.login-failed'), 'errorType' => 'danger'));
        }
		//return View::make('inicio.inicio');
        return Response::json(array('logged' => true));
    }

    /**
    * Logout user
    */
    public function getLogout()
    {
        Sentry::logout();

        return Redirect::route('getLogin2');
    }

    /**
    * Access denied page
    */
    public function getAccessDenied2()
    {
        return View::make('inicio.denied');
    }

}
