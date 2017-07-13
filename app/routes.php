<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('hello');
});*/


/**
 * Loggued routes without permission
 */
// Display all SQL executed in Eloquent
/*Event::listen('illuminate.query', function($sql, $bindings)
{
    foreach ($bindings as $val) {
        $sql = preg_replace('/\?/', "'{$val}'", $sql, 1);
    }
     
    Log::info($sql);
});
*/
Route::group(array('before' => 'basicAuth2'), function()
{
Route::get('/', array(
				'as'=>'inicio',
				'http',
				'uses'=>'HomeController@showWelcome'));
				
Route::get('/logout', array(
        'as' => 'logout2',
        'uses' => 'HomeController@getLogout')
    );
	
Route::get('/denied2', array(
        'as' => 'denied2',
        'uses' => 'HomeController@getAccessDenied2')
    );
});

/**
 * Unlogged routes
 */
Route::group(array('before' => 'notAuth2'), function()
{
    Route::get('/login', array(
        'as' => 'getLogin2',
        'uses' => 'HomeController@getLogin')
    );

    Route::post('/login', array(
        'as' => 'postLogin2',
        'uses' => 'HomeController@postLogin')
    );
});

/**
 * Loggued routes with permissions
 */
/*-------Menus------*/
Route::get('/menus/index', array(
	'as' => 'menus.index',
	'before' => 'basicAuth2|hasPermissions2:menus-index',
	'uses' => 'MenusController@index')
);
Route::get('/menus/create', array(
        'as' => 'menus.create',
		'before' => 'basicAuth2|hasPermissions2:menus-create',
        'uses' => 'MenusController@create')
    );
Route::post('/menus/store', array(
        'as' => 'menus.store',
		'before' => 'basicAuth2|hasPermissions2:menus-store',
        'uses' => 'MenusController@store')
    );
Route::get('/menus/show/{id}', array(
        'as' => 'menus.show',
		'before' => 'basicAuth2|hasPermissions2:menus-show',
        'uses' => 'MenusController@show')
    );
Route::get('/menus/edit/{id}', array(
        'as' => 'menus.edit',
		'before' => 'basicAuth2|hasPermissions2:menus-edit',
        'uses' => 'MenusController@edit')
    );
Route::put('/menus/update/{id}', array(
        'as' => 'menus.update',
		'before' => 'basicAuth2|hasPermissions2:menus-update',
        'uses' => 'MenusController@update')
    );
Route::post('/menus/destroy/{id}', array(
        'as' => 'menus.destroy',
		'before' => 'basicAuth2|hasPermissions2:menus-destroy',
        'uses' => 'MenusController@destroy')
    );
Route::post('/menus/recover/{id}', array(
        'as' => 'menus.recover',
		'before' => 'basicAuth2|hasPermissions2:menus-recover',
        'uses' => 'MenusController@recover')
    );
Route::post('/menus/contentListIndex', array(
        'as' => 'menus.contentListIndex',
		'before' => 'basicAuth2|hasPermissions2:menus-contentListIndex',
        'uses' => 'MenusController@contentListIndex')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Productos-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/gd_producto/index', array(
	'as' => 'gd_producto.index',
	'before' => 'basicAuth2|hasPermissions2:productos-index',
	'uses' => 'Gd_productosController@index')
);
Route::post('/gd_producto/contentListIndex', array(
        'as' => 'gd_producto.contentListIndex',
		'before' => 'basicAuth2|hasPermissions2:productos-contentListIndex',
        'uses' => 'Gd_productosController@contentListIndex')
    );
Route::get('/gd_producto/create', array(
        'as' => 'gd_producto.create',
		'before' => 'basicAuth2|hasPermissions2:productos-create',
        'uses' => 'Gd_productosController@create')
    );
Route::post('/gd_productos/store', array(
        'as' => 'gd_producto.store',
		'before' => 'basicAuth2|hasPermissions2:productos-store',
        'uses' => 'Gd_productosController@store')
    );
Route::get('/gd_producto/show/{id}', array(
        'as' => 'gd_producto.show',
		'before' => 'basicAuth2|hasPermissions2:productos-show',
        'uses' => 'Gd_productosController@show')
    );
Route::get('/gd_producto/edit/{id}', array(
        'as' => 'gd_producto.edit',
		'before' => 'basicAuth2|hasPermissions2:productos-edit',
        'uses' => 'Gd_productosController@edit')
    );
Route::put('/gd_producto/update/{id}', array(
        'as' => 'gd_producto.update',
		'before' => 'basicAuth2|hasPermissions2:productos-update',
        'uses' => 'Gd_productosController@update')
    );
Route::post('/gd_producto/destroy/{id}', array(
        'as' => 'gd_producto.destroy',
		'before' => 'basicAuth2|hasPermissions2:productos-destroy',
        'uses' => 'Gd_productosController@destroy')
    );
Route::post('/gd_producto/recover/{id}', array(
        'as' => 'gd_producto.recover',
		'before' => 'basicAuth2|hasPermissions2:productos-recover',
        'uses' => 'Gd_productosController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Entidades-----------------------------*/
/*---------------------------------------------------------------------*/

Route::get('/entidad/index', array(
    'as' => 'entidad.index',
    'before' => 'basicAuth2|hasPermissions2:entidades-index',
    'uses' => 'EntidadesController@index')
);
Route::post('/entidad/contentListIndex', array(
        'as' => 'entidad.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:entidades-contentListIndex',
        'uses' => 'EntidadesController@contentListIndex')
    );
Route::get('/entidad/create', array(
        'as' => 'entidad.create',
        'before' => 'basicAuth2|hasPermissions2:entidades-create',
        'uses' => 'EntidadesController@create')
    );
Route::post('/entidads/store', array(
        'as' => 'entidad.store',
        'before' => 'basicAuth2|hasPermissions2:entidades-store',
        'uses' => 'EntidadesController@store')
    );
Route::get('/entidad/show/{id}', array(
        'as' => 'entidad.show',
        'before' => 'basicAuth2|hasPermissions2:entidades-show',
        'uses' => 'EntidadesController@show')
    );
Route::get('/entidad/edit/{id}', array(
        'as' => 'entidad.edit',
        'before' => 'basicAuth2|hasPermissions2:entidades-edit',
        'uses' => 'EntidadesController@edit')
    );
Route::put('/entidad/update/{id}', array(
        'as' => 'entidad.update',
        'before' => 'basicAuth2|hasPermissions2:entidades-update',
        'uses' => 'EntidadesController@update')
    );
Route::post('/entidad/destroy/{id}', array(
        'as' => 'entidad.destroy',
        'before' => 'basicAuth2|hasPermissions2:entidades-destroy',
        'uses' => 'EntidadesController@destroy')
    );
Route::post('/entidad/recover/{id}', array(
        'as' => 'entidad.recover',
        'before' => 'basicAuth2|hasPermissions2:entidades-recover',
        'uses' => 'EntidadesController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Productos-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/gd_producto/index', array(
    'as' => 'gd_producto.index',
    'before' => 'basicAuth2|hasPermissions2:productos-index',
    'uses' => 'Gd_productosController@index')
);
Route::post('/gd_producto/contentListIndex', array(
        'as' => 'gd_producto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:productos-contentListIndex',
        'uses' => 'Gd_productosController@contentListIndex')
    );
Route::get('/gd_producto/create', array(
        'as' => 'gd_producto.create',
        'before' => 'basicAuth2|hasPermissions2:productos-create',
        'uses' => 'Gd_productosController@create')
    );
Route::post('/gd_productos/store', array(
        'as' => 'gd_producto.store',
        'before' => 'basicAuth2|hasPermissions2:productos-store',
        'uses' => 'Gd_productosController@store')
    );
Route::get('/gd_producto/show/{id}', array(
        'as' => 'gd_producto.show',
        'before' => 'basicAuth2|hasPermissions2:productos-show',
        'uses' => 'Gd_productosController@show')
    );
Route::get('/gd_producto/edit/{id}', array(
        'as' => 'gd_producto.edit',
        'before' => 'basicAuth2|hasPermissions2:productos-edit',
        'uses' => 'Gd_productosController@edit')
    );
Route::put('/gd_producto/update/{id}', array(
        'as' => 'gd_producto.update',
        'before' => 'basicAuth2|hasPermissions2:productos-update',
        'uses' => 'Gd_productosController@update')
    );
Route::post('/gd_producto/destroy/{id}', array(
        'as' => 'gd_producto.destroy',
        'before' => 'basicAuth2|hasPermissions2:productos-destroy',
        'uses' => 'Gd_productosController@destroy')
    );
Route::post('/gd_producto/recover/{id}', array(
        'as' => 'gd_producto.recover',
        'before' => 'basicAuth2|hasPermissions2:productos-recover',
        'uses' => 'Gd_productosController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Permisos-----------------------------*/
/*---------------------------------------------------------------------*/

Route::get('/permission/index', array(
    'as' => 'permission.index',
    'before' => 'basicAuth2|hasPermissions2:permissions-index',
    'uses' => 'PermissionsController@index')
);
Route::post('/permission/contentListIndex', array(
        'as' => 'permission.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:permissions-contentListIndex',
        'uses' => 'PermissionsController@contentListIndex')
    );
Route::get('/permission/create', array(
        'as' => 'permission.create',
        'before' => 'basicAuth2|hasPermissions2:permissions-create',
        'uses' => 'permissionsController@create')
    );
Route::post('/permissions/store', array(
        'as' => 'permission.store',
        'before' => 'basicAuth2|hasPermissions2:permissions-store',
        'uses' => 'PermissionsController@store')
    );
Route::get('/permission/show/{id}', array(
        'as' => 'permission.show',
        'before' => 'basicAuth2|hasPermissions2:permissions-show',
        'uses' => 'PermissionsController@show')
    );
Route::get('/permission/edit/{id}', array(
        'as' => 'permission.edit',
        'before' => 'basicAuth2|hasPermissions2:permissions-edit',
        'uses' => 'PermissionsController@edit')
    );
Route::put('/permission/update/{id}', array(
        'as' => 'permission.update',
        'before' => 'basicAuth2|hasPermissions2:permissions-update',
        'uses' => 'PermissionsController@update')
    );
Route::post('/permission/destroy/{id}', array(
        'as' => 'permission.destroy',
        'before' => 'basicAuth2|hasPermissions2:permissions-destroy',
        'uses' => 'PermissionsController@destroy')
    );
Route::post('/permission/recover/{id}', array(
        'as' => 'permission.recover',
        'before' => 'basicAuth2|hasPermissions2:permissions-recover',
        'uses' => 'PermissionsController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Grupos-----------------------------*/
/*---------------------------------------------------------------------*/

Route::get('/group/index', array(
    'as' => 'group.index',
    'before' => 'basicAuth2|hasPermissions2:groups-index',
    'uses' => 'GroupsController@index')
);
Route::post('/group/contentListIndex', array(
        'as' => 'group.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:groups-contentListIndex',
        'uses' => 'GroupsController@contentListIndex')
    );
Route::get('/group/create', array(
        'as' => 'group.create',
        'before' => 'basicAuth2|hasPermissions2:groups-create',
        'uses' => 'GroupsController@create')
    );
Route::post('/group/store', array(
        'as' => 'group.store',
        'before' => 'basicAuth2|hasPermissions2:groups-store',
        'uses' => 'GroupsController@store')
    );
Route::get('/group/show/{id}', array(
        'as' => 'group.show',
        'before' => 'basicAuth2|hasPermissions2:groups-show',
        'uses' => 'GroupsController@show')
    );
Route::get('/group/edit/{id}', array(
        'as' => 'group.edit',
        'before' => 'basicAuth2|hasPermissions2:groups-edit',
        'uses' => 'GroupsController@edit')
    );
Route::put('/group/update/{id}', array(
        'as' => 'group.update',
        'before' => 'basicAuth2|hasPermissions2:groups-update',
        'uses' => 'GroupsController@update')
    );
Route::post('/group/destroy/{id}', array(
        'as' => 'group.destroy',
        'before' => 'basicAuth2|hasPermissions2:groups-destroy',
        'uses' => 'GroupsController@destroy')
    );
Route::post('/group/recover/{id}', array(
        'as' => 'group.recover',
        'before' => 'basicAuth2|hasPermissions2:groups-recover',
        'uses' => 'GroupsController@recover')
    );
Route::post('/group/duplicate/{id}', array(
        'as' => 'group.duplicate',
        'before' => 'basicAuth2|hasPermissions2:groups-duplicate',
        'uses' => 'GroupsController@duplicate')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Usuarios-----------------------------*/
/*---------------------------------------------------------------------*/

Route::get('/user/index', array(
    'as' => 'user.index',
    'before' => 'basicAuth2|hasPermissions2:users-index',
    'uses' => 'UsersController@index')
);
Route::post('/user/contentListIndex', array(
        'as' => 'user.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:users-contentListIndex',
        'uses' => 'UsersController@contentListIndex')
    );
Route::get('/user/create', array(
        'as' => 'user.create',
        'before' => 'basicAuth2|hasPermissions2:users-create',
        'uses' => 'UsersController@create')
    );
Route::post('/user/store', array(
        'as' => 'user.store',
        'before' => 'basicAuth2|hasPermissions2:users-store',
        'uses' => 'UsersController@store')
    );
Route::get('/user/show/{id}', array(
        'as' => 'user.show',
        'before' => 'basicAuth2|hasPermissions2:users-show',
        'uses' => 'UsersController@show')
    );
Route::get('/user/edit/{id}', array(
        'as' => 'user.edit',
        'before' => 'basicAuth2|hasPermissions2:users-edit',
        'uses' => 'UsersController@edit')
    );
Route::put('/user/update/{id}', array(
        'as' => 'user.update',
        'before' => 'basicAuth2|hasPermissions2:users-update',
        'uses' => 'UsersController@update')
    );
Route::post('/user/destroy/{id}', array(
        'as' => 'user.destroy',
        'before' => 'basicAuth2|hasPermissions2:users-destroy',
        'uses' => 'UsersController@destroy')
    );
Route::get('/user/getPerfil', array(
        'as' => 'user.getPerfil',
        'before' => 'basicAuth2|hasPermissions2:users-getPerfil',
        'uses' => 'UsersController@getPerfil')
    );
Route::put('/user/postPerfil', array(
        'as' => 'user.postPerfil',
        'before' => 'basicAuth2|hasPermissions2:users-postPerfil',
        'uses' => 'UsersController@postPerfil')
    );
Route::post('/user/bannedReg/{id}', array(
        'as' => 'user.bannedReg',
        'before' => 'basicAuth2|hasPermissions2:users-bannedReg',
        'uses' => 'UsersController@bannedReg')
    );
Route::post('/user/unblock/{id}', array(
        'as' => 'user.unblock',
        'before' => 'basicAuth2|hasPermissions2:users-unblock',
        'uses' => 'UsersController@unblock')
    );
Route::get('user/activation/{activationCode}', array(
        'as' => 'getActivate',
        'uses' => 'UsersController@getActivate')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Factores-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/factor/index', array(
    'as' => 'factor.index',
    'before' => 'basicAuth2|hasPermissions2:factors-index',
    'uses' => 'FactorsController@index')
);
Route::post('/factor/contentListIndex', array(
        'as' => 'factor.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:factors-contentListIndex',
        'uses' => 'FactorsController@contentListIndex')
    );
Route::get('/factor/create', array(
        'as' => 'factor.create',
        'before' => 'basicAuth2|hasPermissions2:factors-create',
        'uses' => 'FactorsController@create')
    );
Route::post('/factors/store', array(
        'as' => 'factor.store',
        'before' => 'basicAuth2|hasPermissions2:factors-store',
        'uses' => 'FactorsController@store')
    );
Route::get('/factor/show/{id}', array(
        'as' => 'factor.show',
        'before' => 'basicAuth2|hasPermissions2:factors-show',
        'uses' => 'FactorsController@show')
    );
Route::get('/factor/edit/{id}', array(
        'as' => 'factor.edit',
        'before' => 'basicAuth2|hasPermissions2:factors-edit',
        'uses' => 'FactorsController@edit')
    );
Route::put('/factor/update/{id}', array(
        'as' => 'factor.update',
        'before' => 'basicAuth2|hasPermissions2:factors-update',
        'uses' => 'FactorsController@update')
    );
Route::post('/factor/destroy/{id}', array(
        'as' => 'factor.destroy',
        'before' => 'basicAuth2|hasPermissions2:factors-destroy',
        'uses' => 'FactorsController@destroy')
    );
Route::post('/factor/recover/{id}', array(
        'as' => 'factor.recover',
        'before' => 'basicAuth2|hasPermissions2:factors-recover',
        'uses' => 'FactorsController@recover')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Rubros-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/rubro/index', array(
    'as' => 'rubro.index',
    'before' => 'basicAuth2|hasPermissions2:rubros-index',
    'uses' => 'RubrosController@index')
);
Route::post('/rubro/contentListIndex', array(
        'as' => 'rubro.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:rubros-contentListIndex',
        'uses' => 'RubrosController@contentListIndex')
    );
Route::get('/rubro/create', array(
        'as' => 'rubro.create',
        'before' => 'basicAuth2|hasPermissions2:rubros-create',
        'uses' => 'RubrosController@create')
    );
Route::post('/rubros/store', array(
        'as' => 'rubro.store',
        'before' => 'basicAuth2|hasPermissions2:rubros-store',
        'uses' => 'RubrosController@store')
    );
Route::get('/rubro/show/{id}', array(
        'as' => 'rubro.show',
        'before' => 'basicAuth2|hasPermissions2:rubros-show',
        'uses' => 'RubrosController@show')
    );
Route::get('/rubro/edit/{id}', array(
        'as' => 'rubro.edit',
        'before' => 'basicAuth2|hasPermissions2:rubros-edit',
        'uses' => 'RubrosController@edit')
    );
Route::put('/rubro/update/{id}', array(
        'as' => 'rubro.update',
        'before' => 'basicAuth2|hasPermissions2:rubros-update',
        'uses' => 'RubrosController@update')
    );
Route::post('/rubro/destroy/{id}', array(
        'as' => 'rubro.destroy',
        'before' => 'basicAuth2|hasPermissions2:rubros-destroy',
        'uses' => 'RubrosController@destroy')
    );
Route::post('/rubro/recover/{id}', array(
        'as' => 'rubro.recover',
        'before' => 'basicAuth2|hasPermissions2:rubros-recover',
        'uses' => 'RubrosController@recover')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Rubros-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/especifico/index', array(
    'as' => 'especifico.index',
    'before' => 'basicAuth2|hasPermissions2:especificos-index',
    'uses' => 'EspecificosController@index')
);
Route::post('/especifico/contentListIndex', array(
        'as' => 'especifico.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:especificos-contentListIndex',
        'uses' => 'EspecificosController@contentListIndex')
    );
Route::get('/especifico/create', array(
        'as' => 'especifico.create',
        'before' => 'basicAuth2|hasPermissions2:especificos-create',
        'uses' => 'EspecificosController@create')
    );
Route::post('/especificos/store', array(
        'as' => 'especifico.store',
        'before' => 'basicAuth2|hasPermissions2:especificos-store',
        'uses' => 'EspecificosController@store')
    );
Route::get('/especifico/show/{id}', array(
        'as' => 'especifico.show',
        'before' => 'basicAuth2|hasPermissions2:especificos-show',
        'uses' => 'EspecificosController@show')
    );
Route::get('/especifico/edit/{id}', array(
        'as' => 'especifico.edit',
        'before' => 'basicAuth2|hasPermissions2:especificos-edit',
        'uses' => 'EspecificosController@edit')
    );
Route::put('/especifico/update/{id}', array(
        'as' => 'especifico.update',
        'before' => 'basicAuth2|hasPermissions2:especificos-update',
        'uses' => 'EspecificosController@update')
    );
Route::post('/especifico/destroy/{id}', array(
        'as' => 'especifico.destroy',
        'before' => 'basicAuth2|hasPermissions2:especificos-destroy',
        'uses' => 'EspecificosController@destroy')
    );
Route::post('/especifico/recover/{id}', array(
        'as' => 'especifico.recover',
        'before' => 'basicAuth2|hasPermissions2:especificos-recover',
        'uses' => 'EspecificosController@recover')
    );
/*---------------------------------------------------------------------*/
/*------------------------------MAtriz-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/matriz/index', array(
    'as' => 'matriz.index',
    'before' => 'basicAuth2|hasPermissions2:matrizs-index',
    'uses' => 'MatrizsController@index')
);
Route::post('/matriz/contentListIndex', array(
        'as' => 'matriz.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:matrizs-contentListIndex',
        'uses' => 'MatrizsController@contentListIndex')
    );
Route::get('/matriz/create', array(
        'as' => 'matriz.create',
        'before' => 'basicAuth2|hasPermissions2:matrizs-create',
        'uses' => 'MatrizsController@create')
    );
Route::post('/matrizs/store', array(
        'as' => 'matriz.store',
        'before' => 'basicAuth2|hasPermissions2:matrizs-store',
        'uses' => 'MatrizsController@store')
    );
Route::get('/matriz/show/{id}', array(
        'as' => 'matriz.show',
        'before' => 'basicAuth2|hasPermissions2:matrizs-show',
        'uses' => 'MatrizsController@show')
    );
Route::get('/matriz/edit/{id}', array(
        'as' => 'matriz.edit',
        'before' => 'basicAuth2|hasPermissions2:matrizs-edit',
        'uses' => 'MatrizsController@edit')
    );
Route::put('/matriz/update/{id}', array(
        'as' => 'matriz.update',
        'before' => 'basicAuth2|hasPermissions2:matrizs-update',
        'uses' => 'MatrizsController@update')
    );
Route::post('/matriz/destroy/{id}', array(
        'as' => 'matriz.destroy',
        'before' => 'basicAuth2|hasPermissions2:matrizs-destroy',
        'uses' => 'MatrizsController@destroy')
    );
Route::post('/matriz/recover/{id}', array(
        'as' => 'matriz.recover',
        'before' => 'basicAuth2|hasPermissions2:matrizs-recover',
        'uses' => 'MatrizsController@recover')
    );
/*---------------------------------------------------------------------*/
/*----------------------------Caracteristicas-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/caracteristica/index', array(
    'as' => 'caracteristica.index',
    'before' => 'basicAuth2|hasPermissions2:caracteristicas-index',
    'uses' => 'CaracteristicasController@index')
);
Route::post('/caracteristica/contentListIndex', array(
        'as' => 'caracteristica.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-contentListIndex',
        'uses' => 'CaracteristicasController@contentListIndex')
    );
Route::get('/caracteristica/create', array(
        'as' => 'caracteristica.create',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-create',
        'uses' => 'CaracteristicasController@create')
    );
Route::post('/caracteristicas/store', array(
        'as' => 'caracteristica.store',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-store',
        'uses' => 'CaracteristicasController@store')
    );
Route::get('/caracteristica/show/{id}', array(
        'as' => 'caracteristica.show',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-show',
        'uses' => 'CaracteristicasController@show')
    );
Route::get('/caracteristica/edit/{id}', array(
        'as' => 'caracteristica.edit',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-edit',
        'uses' => 'CaracteristicasController@edit')
    );
Route::put('/caracteristica/update/{id}', array(
        'as' => 'caracteristica.update',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-update',
        'uses' => 'CaracteristicasController@update')
    );
Route::post('/caracteristica/destroy/{id}', array(
        'as' => 'caracteristica.destroy',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-destroy',
        'uses' => 'CaracteristicasController@destroy')
    );
Route::post('/caracteristica/recover/{id}', array(
        'as' => 'caracteristica.recover',
        'before' => 'basicAuth2|hasPermissions2:caracteristicas-recover',
        'uses' => 'CaracteristicasController@recover')
    );
/*---------------------------------------------------------------------*/
/*----------------------------Clientes-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cliente/index', array(
    'as' => 'cliente.index',
    'before' => 'basicAuth2|hasPermissions2:clientes-index',
    'uses' => 'ClientesController@index')
);
Route::post('/cliente/contentListIndex', array(
        'as' => 'cliente.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:clientes-contentListIndex',
        'uses' => 'ClientesController@contentListIndex')
    );
Route::get('/cliente/create', array(
        'as' => 'cliente.create',
        'before' => 'basicAuth2|hasPermissions2:clientes-create',
        'uses' => 'ClientesController@create')
    );
Route::post('/clientes/store', array(
        'as' => 'cliente.store',
        'before' => 'basicAuth2|hasPermissions2:clientes-store',
        'uses' => 'ClientesController@store')
    );
Route::get('/cliente/show/{id}', array(
        'as' => 'cliente.show',
        'before' => 'basicAuth2|hasPermissions2:clientes-show',
        'uses' => 'ClientesController@show')
    );
Route::get('/cliente/edit/{id}', array(
        'as' => 'cliente.edit',
        'before' => 'basicAuth2|hasPermissions2:clientes-edit',
        'uses' => 'ClientesController@edit')
    );
Route::put('/cliente/update/{id}', array(
        'as' => 'cliente.update',
        'before' => 'basicAuth2|hasPermissions2:clientes-update',
        'uses' => 'ClientesController@update')
    );
Route::post('/cliente/destroy/{id}', array(
        'as' => 'cliente.destroy',
        'before' => 'basicAuth2|hasPermissions2:clientes-destroy',
        'uses' => 'ClientesController@destroy')
    );
Route::post('/cliente/recover/{id}', array(
        'as' => 'cliente.recover',
        'before' => 'basicAuth2|hasPermissions2:clientes-recover',
        'uses' => 'ClientesController@recover')
    );
/*---------------------------------------------------------------------*/
/*----------------------------Clientes-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/efecto/index', array(
    'as' => 'efecto.index',
    'before' => 'basicAuth2|hasPermissions2:efectos-index',
    'uses' => 'EfectosController@index')
);
Route::post('/efecto/contentListIndex', array(
        'as' => 'efecto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:efectos-contentListIndex',
        'uses' => 'EfectosController@contentListIndex')
    );
Route::get('/efecto/create', array(
        'as' => 'efecto.create',
        'before' => 'basicAuth2|hasPermissions2:efectos-create',
        'uses' => 'EfectosController@create')
    );
Route::post('/efectos/store', array(
        'as' => 'efecto.store',
        'before' => 'basicAuth2|hasPermissions2:efectos-store',
        'uses' => 'EfectosController@store')
    );
Route::get('/efecto/show/{id}', array(
        'as' => 'efecto.show',
        'before' => 'basicAuth2|hasPermissions2:efectos-show',
        'uses' => 'EfectosController@show')
    );
Route::get('/efecto/edit/{id}', array(
        'as' => 'efecto.edit',
        'before' => 'basicAuth2|hasPermissions2:efectos-edit',
        'uses' => 'EfectosController@edit')
    );
Route::put('/efecto/update/{id}', array(
        'as' => 'efecto.update',
        'before' => 'basicAuth2|hasPermissions2:efectos-update',
        'uses' => 'EfectosController@update')
    );
Route::post('/efecto/destroy/{id}', array(
        'as' => 'efecto.destroy',
        'before' => 'basicAuth2|hasPermissions2:efectos-destroy',
        'uses' => 'EfectosController@destroy')
    );
Route::post('/efecto/recover/{id}', array(
        'as' => 'efecto.recover',
        'before' => 'basicAuth2|hasPermissions2:efectos-recover',
        'uses' => 'EfectosController@recover')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Reg. Impacto-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/reg_impacto/index', array(
    'as' => 'reg_impacto.index',
    'before' => 'basicAuth2|hasPermissions2:reg_impactos-index',
    'uses' => 'Reg_impactosController@index')
);

Route::post('/reg_impacto/contentListIndex', array(
        'as' => 'reg_impacto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-contentListIndex',
        'uses' => 'Reg_impactosController@contentListIndex')
    );
Route::post('/reg_impacto/contentListLn', array(
        'as' => 'reg_impacto.contentListLn',
        'before' => 'basicAuth2',
        'uses' => 'Reg_impactosController@contentListLn')
    );
Route::get('/reg_impacto/create', array(
        'as' => 'reg_impacto.create',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-create',
        'uses' => 'Reg_impactosController@create')
    );
Route::post('/reg_impactos/store', array(
        'as' => 'reg_impacto.store',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-store',
        'uses' => 'Reg_impactosController@store')
    );
Route::get('/reg_impacto/show/{id}', array(
        'as' => 'reg_impacto.show',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-show',
        'uses' => 'Reg_impactosController@show')
    );
Route::get('/reg_impacto/edit/{id}', array(
        'as' => 'reg_impacto.edit',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-edit',
        'uses' => 'Reg_impactosController@edit')
    );
Route::put('/reg_impacto/update/{id}', array(
        'as' => 'reg_impacto.update',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-update',
        'uses' => 'Reg_impactosController@update')
    );
Route::post('/reg_impacto/updateLn', array(
        'as' => 'reg_impacto.updateLn',
        'before' => 'basicAuth2',
        'uses' => 'Reg_impactosController@updateLn')
    );
Route::post('/reg_impacto/destroy/{id}', array(
        'as' => 'reg_impacto.destroy',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-destroy',
        'uses' => 'Reg_impactosController@destroy')
    );
Route::post('/reg_impacto/recover/{id}', array(
        'as' => 'reg_impacto.recover',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-recover',
        'uses' => 'Reg_impactosController@recover')
    );
Route::post('/reg_impacto/cmbRubro/{id}', array(
        'as' => 'reg_impacto.cmbRubro',
        'before' => 'basicAuth2',
        'uses' => 'Reg_impactosController@cmbRubro')
    );
Route::post('/reg_impacto/cmbEspecifico/{id}', array(
        'as' => 'reg_impacto.cmbEspecifico',
        'before' => 'basicAuth2',
        'uses' => 'Reg_impactosController@cmbEspecifico')
    );
Route::post('/reg_impacto/edit/descEfecto/{id}', array(
        'as' => 'reg_impacto.descEfecto',
        'before' => 'basicAuth2',
        'uses' => 'Reg_impactosController@descEfecto')
    );
/*---------------------------------------------------------------------*/
/*---------------------------Tipo Impacto-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/tipo_impacto/index', array(
    'as' => 'tipo_impacto.index',
    'before' => 'basicAuth2|hasPermissions2:tipo_impactos-index',
    'uses' => 'Tipo_impactosController@index')
);
Route::post('/tipo_impacto/contentListIndex', array(
        'as' => 'tipo_impacto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-contentListIndex',
        'uses' => 'Tipo_impactosController@contentListIndex')
    );
Route::get('/tipo_impacto/create', array(
        'as' => 'tipo_impacto.create',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-create',
        'uses' => 'Tipo_impactosController@create')
    );
Route::post('/tipo_impacto/store', array(
        'as' => 'tipo_impacto.store',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-store',
        'uses' => 'Tipo_impactosController@store')
    );
Route::get('/tipo_impacto/show/{id}', array(
        'as' => 'tipo_impacto.show',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-show',
        'uses' => 'Tipo_impactosController@show')
    );
Route::get('/tipo_impacto/edit/{id}', array(
        'as' => 'tipo_impacto.edit',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-edit',
        'uses' => 'Tipo_impactosController@edit')
    );
Route::put('/tipo_impacto/update/{id}', array(
        'as' => 'tipo_impacto.update',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-update',
        'uses' => 'Tipo_impactosController@update')
    );
Route::post('/tipo_impacto/destroy/{id}', array(
        'as' => 'tipo_impacto.destroy',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-destroy',
        'uses' => 'Tipo_impactosController@destroy')
    );
Route::post('/tipo_impacto/recover/{id}', array(
        'as' => 'tipo_impacto.recover',
        'before' => 'basicAuth2|hasPermissions2:tipo_impactos-recover',
        'uses' => 'Tipo_impactosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------------Encabezado de impactos------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/enc_impacto/index', array(
    'as' => 'enc_impacto.index',
    'before' => 'basicAuth2|hasPermissions2:enc_impactos-index',
    'uses' => 'Enc_impactosController@index')
);
Route::post('/enc_impacto/contentListIndex', array(
        'as' => 'enc_impacto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-contentListIndex',
        'uses' => 'Enc_impactosController@contentListIndex')
    );
Route::get('/enc_impacto/create', array(
        'as' => 'enc_impacto.create',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-create',
        'uses' => 'Enc_impactosController@create')
    );
Route::post('/enc_impacto/store', array(
        'as' => 'enc_impacto.store',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-store',
        'uses' => 'Enc_impactosController@store')
    );
Route::get('/enc_impacto/show/{id}', array(
        'as' => 'enc_impacto.show',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-show',
        'uses' => 'Enc_impactosController@show')
    );
Route::get('/enc_impacto/imprimir/{id}', array(
        'as' => 'enc_impacto.imprimir',
        'before' => 'basicAuth2|hasPermissions2:enc_impacto-imprimir',
        'uses' => 'Enc_impactosController@imprimir')
    );

Route::get('/enc_impacto/imprimir2/{id}', array(
        'as' => 'enc_impacto.imprimir2',
        'before' => 'basicAuth2|hasPermissions2:enc_impacto-imprimir2',
        'uses' => 'Enc_impactosController@imprimir2')
    );
Route::get('/enc_impacto/grfPie/{id}', array(
        'as' => 'enc_impacto.grfPie',
        'before' => 'basicAuth2|hasPermissions2:enc_impacto-grfPie',
        'uses' => 'Enc_impactosController@grfPie')
    );
Route::get('/enc_impacto/grfBarras/{id}', array(
        'as' => 'enc_impacto.grfBarras',
        'before' => 'basicAuth2|hasPermissions2:enc_impacto-grfBarras',
        'uses' => 'Enc_impactosController@grfBarras')
    );
Route::get('/enc_impacto/edit/{id}', array(
        'as' => 'enc_impacto.edit',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-edit',
        'uses' => 'Enc_impactosController@edit')
    );
Route::put('/enc_impacto/update/{id}', array(
        'as' => 'enc_impacto.update',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-update',
        'uses' => 'Enc_impactosController@update')
    );
Route::post('/enc_impacto/destroy/{id}', array(
        'as' => 'enc_impacto.destroy',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-destroy',
        'uses' => 'Enc_impactosController@destroy')
    );
Route::post('/enc_impacto/recover/{id}', array(
        'as' => 'enc_impacto.recover',
        'before' => 'basicAuth2|hasPermissions2:enc_impactos-recover',
        'uses' => 'Enc_impactosController@recover')
    );
Route::get('/enc_impacto/lineas/{id}', array(
    'as' => 'enc_impacto.lineas',
    'before' => 'basicAuth2|hasPermissions2:enc_impactos-lineas',
    'uses' => 'Enc_impactosController@lineas')
);
Route::get('/enc_impacto/documentos/{id}', array(
    'as' => 'enc_impacto.documentos',
    'before' => 'basicAuth2|hasPermissions2:enc_impactos-documentos',
    'uses' => 'Enc_impactosController@documentos')
);

/*---------------------------------------------------------------------*/
/*----------------------------Reportes-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/reg_impacto/reporte1', array(
        'as' => 'reg_impacto.reporte1',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-reporte1',
        'uses' => 'Reg_impactosController@getReporte1')
    );
Route::post('/reg_impactos/reporte1', array(
        'as' => 'reg_impacto.reporte1',
        'before' => 'basicAuth2|hasPermissions2:reg_impactos-reporte1',
        'uses' => 'Reg_impactosController@postReporte1')
    );

/*---------------------------------------------------------------------*/
/*---------------------------Documentos-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/documento/index', array(
    'as' => 'documento.index',
    'before' => 'basicAuth2|hasPermissions2:documentos-index',
    'uses' => 'DocumentosController@index')
);
Route::post('/documento/contentListIndex', array(
        'as' => 'documento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:documentos-contentListIndex',
        'uses' => 'DocumentosController@contentListIndex')
    );
Route::get('/documento/create', array(
        'as' => 'documento.create',
        'before' => 'basicAuth2|hasPermissions2:documentos-create',
        'uses' => 'DocumentosController@create')
    );
Route::post('/documento/store', array(
        'as' => 'documento.store',
        'before' => 'basicAuth2|hasPermissions2:documentos-store',
        'uses' => 'DocumentosController@store')
    );
Route::get('/documento/show/{id}', array(
        'as' => 'documento.show',
        'before' => 'basicAuth2|hasPermissions2:documentos-show',
        'uses' => 'DocumentosController@show')
    );
Route::get('/documento/edit/{id}', array(
        'as' => 'documento.edit',
        'before' => 'basicAuth2|hasPermissions2:documentos-edit',
        'uses' => 'DocumentosController@edit')
    );
Route::put('/documento/update/{id}', array(
        'as' => 'documento.update',
        'before' => 'basicAuth2|hasPermissions2:documentos-update',
        'uses' => 'DocumentosController@update')
    );
Route::post('/documento/destroy/{id}', array(
        'as' => 'documento.destroy',
        'before' => 'basicAuth2|hasPermissions2:documentos-destroy',
        'uses' => 'DocumentosController@destroy')
    );
Route::post('/documento/recover/{id}', array(
        'as' => 'documento.recover',
        'before' => 'basicAuth2|hasPermissions2:documentos-recover',
        'uses' => 'DocumentosController@recover')
    );

/*---------------------------------------------------------------------*/
/*---------------------------Salario minimo-----------------------------*/
/*---------------------------------------------------------------------*/

Route::get('/sm/index', array(
    'as' => 'sm.index',
    'before' => 'basicAuth2|hasPermissions2:sms-index',
    'uses' => 'SmsController@index')
);
Route::post('/sm/contentListIndex', array(
        'as' => 'sm.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:sms-contentListIndex',
        'uses' => 'SmsController@contentListIndex')
    );
Route::get('/sm/show/{id}', array(
        'as' => 'sm.show',
        'before' => 'basicAuth2|hasPermissions2:sms-show',
        'uses' => 'SmsController@show')
    );
Route::get('/sm/edit/{id}', array(
        'as' => 'sm.edit',
        'before' => 'basicAuth2|hasPermissions2:sms-edit',
        'uses' => 'SmsController@edit')
    );
Route::put('/sm/update/{id}', array(
        'as' => 'sm.update',
        'before' => 'basicAuth2|hasPermissions2:sms-update',
        'uses' => 'SmsController@update')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Areas de chequeo-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/acheck/index', array(
    'as' => 'acheck.index',
    'before' => 'basicAuth2|hasPermissions2:achecks-index',
    'uses' => 'AchecksController@index')
);
Route::post('/acheck/contentListIndex', array(
        'as' => 'acheck.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:achecks-contentListIndex',
        'uses' => 'AchecksController@contentListIndex')
    );
Route::get('/acheck/create', array(
        'as' => 'acheck.create',
        'before' => 'basicAuth2|hasPermissions2:achecks-create',
        'uses' => 'AchecksController@create')
    );
Route::post('/achecks/store', array(
        'as' => 'acheck.store',
        'before' => 'basicAuth2|hasPermissions2:achecks-store',
        'uses' => 'AchecksController@store')
    );
Route::get('/acheck/show/{id}', array(
        'as' => 'acheck.show',
        'before' => 'basicAuth2|hasPermissions2:achecks-show',
        'uses' => 'AchecksController@show')
    );
Route::get('/acheck/edit/{id}', array(
        'as' => 'acheck.edit',
        'before' => 'basicAuth2|hasPermissions2:achecks-edit',
        'uses' => 'AchecksController@edit')
    );
Route::put('/acheck/update/{id}', array(
        'as' => 'acheck.update',
        'before' => 'basicAuth2|hasPermissions2:achecks-update',
        'uses' => 'AchecksController@update')
    );
Route::post('/acheck/destroy/{id}', array(
        'as' => 'acheck.destroy',
        'before' => 'basicAuth2|hasPermissions2:achecks-destroy',
        'uses' => 'AchecksController@destroy')
    );
Route::post('/acheck/recover/{id}', array(
        'as' => 'acheck.recover',
        'before' => 'basicAuth2|hasPermissions2:achecks-recover',
        'uses' => 'AchecksController@recover')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Cumplimiento-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cumplimiento/index', array(
    'as' => 'cumplimiento.index',
    'before' => 'basicAuth2|hasPermissions2:cumplimientos-index',
    'uses' => 'CumplimientosController@index')
);
Route::post('/cumplimiento/contentListIndex', array(
        'as' => 'cumplimiento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-contentListIndex',
        'uses' => 'CumplimientosController@contentListIndex')
    );
Route::get('/cumplimiento/create', array(
        'as' => 'cumplimiento.create',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-create',
        'uses' => 'CumplimientosController@create')
    );
Route::post('/cumplimientos/store', array(
        'as' => 'cumplimiento.store',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-store',
        'uses' => 'CumplimientosController@store')
    );
Route::get('/cumplimiento/show/{id}', array(
        'as' => 'cumplimiento.show',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-show',
        'uses' => 'CumplimientosController@show')
    );
Route::get('/cumplimiento/edit/{id}', array(
        'as' => 'cumplimiento.edit',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-edit',
        'uses' => 'CumplimientosController@edit')
    );
Route::put('/cumplimiento/update/{id}', array(
        'as' => 'cumplimiento.update',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-update',
        'uses' => 'CumplimientosController@update')
    );
Route::post('/cumplimiento/destroy/{id}', array(
        'as' => 'cumplimiento.destroy',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-destroy',
        'uses' => 'CumplimientosController@destroy')
    );
Route::post('/cumplimiento/recover/{id}', array(
        'as' => 'cumplimiento.recover',
        'before' => 'basicAuth2|hasPermissions2:cumplimientos-recover',
        'uses' => 'CumplimientosController@recover')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Matriz de chequep-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/mcheck/index', array(
    'as' => 'mcheck.index',
    'before' => 'basicAuth2|hasPermissions2:mchecks-index',
    'uses' => 'MchecksController@index')
);
Route::post('/mcheck/contentListIndex', array(
        'as' => 'mcheck.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:mchecks-contentListIndex',
        'uses' => 'MchecksController@contentListIndex')
    );
Route::get('/mcheck/create', array(
        'as' => 'mcheck.create',
        'before' => 'basicAuth2|hasPermissions2:mchecks-create',
        'uses' => 'MchecksController@create')
    );
Route::post('/mchecks/store', array(
        'as' => 'mcheck.store',
        'before' => 'basicAuth2|hasPermissions2:mchecks-store',
        'uses' => 'MchecksController@store')
    );
Route::get('/mcheck/show/{id}', array(
        'as' => 'mcheck.show',
        'before' => 'basicAuth2|hasPermissions2:mchecks-show',
        'uses' => 'MchecksController@show')
    );
Route::get('/mcheck/edit/{id}', array(
        'as' => 'mcheck.edit',
        'before' => 'basicAuth2|hasPermissions2:mchecks-edit',
        'uses' => 'MchecksController@edit')
    );
Route::put('/mcheck/update/{id}', array(
        'as' => 'mcheck.update',
        'before' => 'basicAuth2|hasPermissions2:mchecks-update',
        'uses' => 'MchecksController@update')
    );
Route::post('/mcheck/destroy/{id}', array(
        'as' => 'mcheck.destroy',
        'before' => 'basicAuth2|hasPermissions2:mchecks-destroy',
        'uses' => 'MchecksController@destroy')
    );
Route::post('/mcheck/recover/{id}', array(
        'as' => 'mcheck.recover',
        'before' => 'basicAuth2|hasPermissions2:mchecks-recover',
        'uses' => 'MchecksController@recover')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Chequeo-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/check/index', array(
    'as' => 'check.index',
    'before' => 'basicAuth2|hasPermissions2:checks-index',
    'uses' => 'ChecksController@index')
);
Route::post('/check/contentListIndex', array(
        'as' => 'check.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:checks-contentListIndex',
        'uses' => 'ChecksController@contentListIndex')
    );
Route::get('/check/create', array(
        'as' => 'check.create',
        'before' => 'basicAuth2|hasPermissions2:checks-create',
        'uses' => 'ChecksController@create')
    );
Route::post('/checks/store', array(
        'as' => 'check.store',
        'before' => 'basicAuth2|hasPermissions2:checks-store',
        'uses' => 'ChecksController@store')
    );
Route::get('/check/show/{id}', array(
        'as' => 'check.show',
        'before' => 'basicAuth2|hasPermissions2:checks-show',
        'uses' => 'ChecksController@show')
    );
Route::get('/check/edit/{id}', array(
        'as' => 'check.edit',
        'before' => 'basicAuth2|hasPermissions2:checks-edit',
        'uses' => 'ChecksController@edit')
    );
Route::post('/check/update/{id}', array(
        'as' => 'check.update',
        'before' => 'basicAuth2|hasPermissions2:checks-update',
        'uses' => 'ChecksController@update')
    );
Route::post('/check/destroy/{id}', array(
        'as' => 'check.destroy',
        'before' => 'basicAuth2|hasPermissions2:checks-destroy',
        'uses' => 'ChecksController@destroy')
    );
Route::post('/check/recover/{id}', array(
        'as' => 'check.recover',
        'before' => 'basicAuth2|hasPermissions2:checks-recover',
        'uses' => 'ChecksController@recover')
    );
Route::get('/check/lineas/{id}', array(
    'as' => 'check.lineas',
    'before' => 'basicAuth2|hasPermissions2:check-lineas',
    'uses' => 'ChecksController@lineas')
);
Route::get('/check/rptGeneral/{id}', array(
        'as' => 'check.rptGeneral',
        'before' => 'basicAuth2|hasPermissions2:check-imprimir',
        'uses' => 'ChecksController@imprimirGeneral')
    );
Route::get('/check/dictamenGeneral/{id}', array(
        'as' => 'check.dictamenGeneral',
        'before' => 'basicAuth2|hasPermissions2:check-imprimir',
        'uses' => 'ChecksController@dictamenGeneral')
    );
Route::get('/check/programa/{id}', array(
        'as' => 'check.programa',
        'before' => 'basicAuth2|hasPermissions2:check-imprimir',
        'uses' => 'ChecksController@programa')
    );
Route::get('/check/costos/{id}', array(
        'as' => 'check.costos',
        'before' => 'basicAuth2|hasPermissions2:check-imprimir',
        'uses' => 'ChecksController@costos')
    );
Route::post('/check/cmbNormas', array(
        'as' => 'check.cmbNormas',
        'before' => 'basicAuth2',
        'uses' => 'ChecksController@cmbNormas')
    );
/*---------------------------------------------------------------------*/
/*----------------------------Lineas de chequeo-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/checkl/index', array(
    'as' => 'checkl.index',
    'before' => 'basicAuth2|hasPermissions2:checkls-index',
    'uses' => 'ChecklsController@index')
);
Route::post('/checkl/contentListIndex', array(
        'as' => 'checkl.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:checkls-contentListIndex',
        'uses' => 'ChecklsController@contentListIndex')
    );
Route::get('/checkl/create/{id}', array(
        'as' => 'checkl.create',
        'before' => 'basicAuth2|hasPermissions2:checkls-create',
        'uses' => 'ChecklsController@create')
    );
Route::post('/checkl/store', array(
        'as' => 'checkl.store',
        'before' => 'basicAuth2|hasPermissions2:checkls-store',
        'uses' => 'ChecklsController@store')
    );
Route::get('/checkl/show/{id}', array(
        'as' => 'checkl.show',
        'before' => 'basicAuth2|hasPermissions2:checkls-show',
        'uses' => 'ChecklsController@show')
    );
Route::get('/checkl/edit/{id}', array(
        'as' => 'checkl.edit',
        'before' => 'basicAuth2|hasPermissions2:checkls-edit',
        'uses' => 'ChecklsController@edit')
    );
Route::put('/checkl/update/{id}', array(
        'as' => 'checkl.update',
        'before' => 'basicAuth2|hasPermissions2:checkls-update',
        'uses' => 'ChecklsController@update')
    );
Route::post('/checkl/destroy/{id}', array(
        'as' => 'checkl.destroy',
        'before' => 'basicAuth2|hasPermissions2:checkls-destroy',
        'uses' => 'ChecklsController@destroy')
    );
Route::post('/checkl/recover/{id}', array(
        'as' => 'checkl.recover',
        'before' => 'basicAuth2|hasPermissions2:checkls-recover',
        'uses' => 'ChecklsController@recover')
    );
Route::post('/checkl/cmbNormas/{id}', array(
        'as' => 'checkl.cmbNormas',
        'before' => 'basicAuth2',
        'uses' => 'ChecklsController@cmbNormas')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Normas-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/norma/index', array(
    'as' => 'norma.index',
    'before' => 'basicAuth2|hasPermissions2:normas-index',
    'uses' => 'NormasController@index')
);
Route::post('/norma/contentListIndex', array(
        'as' => 'norma.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:normas-contentListIndex',
        'uses' => 'NormasController@contentListIndex')
    );
Route::get('/norma/create', array(
        'as' => 'norma.create',
        'before' => 'basicAuth2|hasPermissions2:normas-create',
        'uses' => 'NormasController@create')
    );
Route::post('/normas/store', array(
        'as' => 'norma.store',
        'before' => 'basicAuth2|hasPermissions2:normas-store',
        'uses' => 'NormasController@store')
    );
Route::get('/norma/show/{id}', array(
        'as' => 'norma.show',
        'before' => 'basicAuth2|hasPermissions2:normas-show',
        'uses' => 'NormasController@show')
    );
Route::get('/norma/edit/{id}', array(
        'as' => 'norma.edit',
        'before' => 'basicAuth2|hasPermissions2:normas-edit',
        'uses' => 'NormasController@edit')
    );
Route::put('/norma/update/{id}', array(
        'as' => 'norma.update',
        'before' => 'basicAuth2|hasPermissions2:normas-update',
        'uses' => 'NormasController@update')
    );
Route::post('/norma/destroy/{id}', array(
        'as' => 'norma.destroy',
        'before' => 'basicAuth2|hasPermissions2:normas-destroy',
        'uses' => 'NormasController@destroy')
    );
Route::post('/norma/recover/{id}', array(
        'as' => 'norma.recover',
        'before' => 'basicAuth2|hasPermissions2:normas-recover',
        'uses' => 'NormasController@recover')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Areas-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/area/index', array(
    'as' => 'area.index',
    'before' => 'basicAuth2|hasPermissions2:areas-index',
    'uses' => 'AreasController@index')
);
Route::post('/area/contentListIndex', array(
        'as' => 'area.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:areas-contentListIndex',
        'uses' => 'AreasController@contentListIndex')
    );
Route::get('/area/create', array(
        'as' => 'area.create',
        'before' => 'basicAuth2|hasPermissions2:areas-create',
        'uses' => 'AreasController@create')
    );
Route::post('/areas/store', array(
        'as' => 'area.store',
        'before' => 'basicAuth2|hasPermissions2:areas-store',
        'uses' => 'AreasController@store')
    );
Route::get('/area/show/{id}', array(
        'as' => 'area.show',
        'before' => 'basicAuth2|hasPermissions2:areas-show',
        'uses' => 'AreasController@show')
    );
Route::get('/area/edit/{id}', array(
        'as' => 'area.edit',
        'before' => 'basicAuth2|hasPermissions2:areas-edit',
        'uses' => 'AreasController@edit')
    );
Route::put('/area/update/{id}', array(
        'as' => 'area.update',
        'before' => 'basicAuth2|hasPermissions2:areas-update',
        'uses' => 'AreasController@update')
    );
Route::post('/area/destroy/{id}', array(
        'as' => 'area.destroy',
        'before' => 'basicAuth2|hasPermissions2:areas-destroy',
        'uses' => 'AreasController@destroy')
    );
Route::post('/area/recover/{id}', array(
        'as' => 'area.recover',
        'before' => 'basicAuth2|hasPermissions2:areas-recover',
        'uses' => 'AreasController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Documentos de calidad ambiental-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_ca_doc/index', array(
    'as' => 'ca_ca_doc.index',
    'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-index',
    'uses' => 'Ca_ca_docsController@index')
);
Route::post('/ca_ca_doc/contentListIndex', array(
        'as' => 'ca_ca_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-contentListIndex',
        'uses' => 'Ca_ca_docsController@contentListIndex')
    );
Route::get('/ca_ca_doc/create', array(
        'as' => 'ca_ca_doc.create',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-create',
        'uses' => 'Ca_ca_docsController@create')
    );
Route::post('/ca_ca_docs/store', array(
        'as' => 'ca_ca_doc.store',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-store',
        'uses' => 'Ca_ca_docsController@store')
    );
Route::get('/ca_ca_doc/show/{id}', array(
        'as' => 'ca_ca_doc.show',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-show',
        'uses' => 'Ca_ca_docsController@show')
    );
Route::get('/ca_ca_doc/edit/{id}', array(
        'as' => 'ca_ca_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-edit',
        'uses' => 'Ca_ca_docsController@edit')
    );
Route::put('/ca_ca_doc/update/{id}', array(
        'as' => 'ca_ca_doc.update',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-update',
        'uses' => 'Ca_ca_docsController@update')
    );
Route::post('/ca_ca_doc/destroy/{id}', array(
        'as' => 'ca_ca_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-destroy',
        'uses' => 'Ca_ca_docsController@destroy')
    );
Route::post('/ca_ca_doc/recover/{id}', array(
        'as' => 'ca_ca_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_ca_docs-recover',
        'uses' => 'Ca_ca_docsController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Procedimientos-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_procedimiento/index', array(
    'as' => 'ca_procedimiento.index',
    'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-index',
    'uses' => 'Ca_procedimientosController@index')
);
Route::post('/ca_procedimiento/contentListIndex', array(
        'as' => 'ca_procedimiento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-contentListIndex',
        'uses' => 'Ca_procedimientosController@contentListIndex')
    );
Route::get('/ca_procedimiento/create', array(
        'as' => 'ca_procedimiento.create',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-create',
        'uses' => 'Ca_procedimientosController@create')
    );
Route::post('/ca_procedimientos/store', array(
        'as' => 'ca_procedimiento.store',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-store',
        'uses' => 'Ca_procedimientosController@store')
    );
Route::get('/ca_procedimiento/show/{id}', array(
        'as' => 'ca_procedimiento.show',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-show',
        'uses' => 'Ca_procedimientosController@show')
    );
Route::get('/ca_procedimiento/edit/{id}', array(
        'as' => 'ca_procedimiento.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-edit',
        'uses' => 'Ca_procedimientosController@edit')
    );
Route::put('/ca_procedimiento/update/{id}', array(
        'as' => 'ca_procedimiento.update',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-update',
        'uses' => 'Ca_procedimientosController@update')
    );
Route::post('/ca_procedimiento/destroy/{id}', array(
        'as' => 'ca_procedimiento.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-destroy',
        'uses' => 'Ca_procedimientosController@destroy')
    );
Route::post('/ca_procedimiento/recover/{id}', array(
        'as' => 'ca_procedimiento.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_procedimientos-recover',
        'uses' => 'Ca_procedimientosController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Materiales-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_material/index', array(
    'as' => 'ca_material.index',
    'before' => 'basicAuth2|hasPermissions2:ca_materials-index',
    'uses' => 'Ca_materialesController@index')
);
Route::post('/ca_material/contentListIndex', array(
        'as' => 'ca_material.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-contentListIndex',
        'uses' => 'Ca_materialesController@contentListIndex')
    );
Route::get('/ca_material/create', array(
        'as' => 'ca_material.create',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-create',
        'uses' => 'Ca_materialesController@create')
    );
Route::post('/ca_materials/store', array(
        'as' => 'ca_material.store',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-store',
        'uses' => 'Ca_materialesController@store')
    );
Route::get('/ca_material/show/{id}', array(
        'as' => 'ca_material.show',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-show',
        'uses' => 'Ca_materialesController@show')
    );
Route::get('/ca_material/edit/{id}', array(
        'as' => 'ca_material.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-edit',
        'uses' => 'Ca_materialesController@edit')
    );
Route::put('/ca_material/update/{id}', array(
        'as' => 'ca_material.update',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-update',
        'uses' => 'Ca_materialesController@update')
    );
Route::post('/ca_material/destroy/{id}', array(
        'as' => 'ca_material.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-destroy',
        'uses' => 'Ca_materialesController@destroy')
    );
Route::post('/ca_material/recover/{id}', array(
        'as' => 'ca_material.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_materials-recover',
        'uses' => 'Ca_materialesController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Categorias-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_categoria/index', array(
    'as' => 'ca_categoria.index',
    'before' => 'basicAuth2|hasPermissions2:ca_categorias-index',
    'uses' => 'Ca_categoriaController@index')
);
Route::post('/ca_categoria/contentListIndex', array(
        'as' => 'ca_categoria.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-contentListIndex',
        'uses' => 'Ca_categoriaController@contentListIndex')
    );
Route::get('/ca_categoria/create', array(
        'as' => 'ca_categoria.create',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-create',
        'uses' => 'Ca_categoriaController@create')
    );
Route::post('/ca_categorias/store', array(
        'as' => 'ca_categoria.store',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-store',
        'uses' => 'Ca_categoriaController@store')
    );
Route::get('/ca_categoria/show/{id}', array(
        'as' => 'ca_categoria.show',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-show',
        'uses' => 'Ca_categoriaController@show')
    );
Route::get('/ca_categoria/edit/{id}', array(
        'as' => 'ca_categoria.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-edit',
        'uses' => 'Ca_categoriaController@edit')
    );
Route::put('/ca_categoria/update/{id}', array(
        'as' => 'ca_categoria.update',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-update',
        'uses' => 'Ca_categoriaController@update')
    );
Route::post('/ca_categoria/destroy/{id}', array(
        'as' => 'ca_categoria.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-destroy',
        'uses' => 'Ca_categoriaController@destroy')
    );
Route::post('/ca_categoria/recover/{id}', array(
        'as' => 'ca_categoria.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_categorias-recover',
        'uses' => 'Ca_categoriaController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Categorias-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_aa_doc/index', array(
    'as' => 'ca_aa_doc.index',
    'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-index',
    'uses' => 'Ca_aa_docsController@index')
);
Route::post('/ca_aa_doc/contentListIndex', array(
        'as' => 'ca_aa_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-contentListIndex',
        'uses' => 'Ca_aa_docsController@contentListIndex')
    );
Route::get('/ca_aa_doc/create', array(
        'as' => 'ca_aa_doc.create',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-create',
        'uses' => 'Ca_aa_docsController@create')
    );
Route::post('/ca_aa_docs/store', array(
        'as' => 'ca_aa_doc.store',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-store',
        'uses' => 'Ca_aa_docsController@store')
    );
Route::get('/ca_aa_doc/show/{id}', array(
        'as' => 'ca_aa_doc.show',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-show',
        'uses' => 'Ca_aa_docsController@show')
    );
Route::get('/ca_aa_doc/edit/{id}', array(
        'as' => 'ca_aa_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-edit',
        'uses' => 'Ca_aa_docsController@edit')
    );
Route::put('/ca_aa_doc/update/{id}', array(
        'as' => 'ca_aa_doc.update',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-update',
        'uses' => 'Ca_aa_docsController@update')
    );
Route::post('/ca_aa_doc/destroy/{id}', array(
        'as' => 'ca_aa_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-destroy',
        'uses' => 'Ca_aa_docsController@destroy')
    );
Route::post('/ca_aa_doc/recover/{id}', array(
        'as' => 'ca_aa_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_aa_docs-recover',
        'uses' => 'Ca_aa_docsController@recover')
    );
Route::post('/ca_aa_doc/cmbCategorias', array(
        'as' => 'ca_aa_doc.cmbCategorias',
        'before' => 'basicAuth2',
        'uses' => 'Ca_aa_docsController@cmbCategorias')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Plantas de tratamiento-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_planta/index', array(
    'as' => 'ca_planta.index',
    'before' => 'basicAuth2|hasPermissions2:ca_plantas-index',
    'uses' => 'Ca_plantasController@index')
);
Route::post('/ca_planta/contentListIndex', array(
        'as' => 'ca_planta.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-contentListIndex',
        'uses' => 'Ca_plantasController@contentListIndex')
    );
Route::get('/ca_planta/create', array(
        'as' => 'ca_planta.create',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-create',
        'uses' => 'Ca_plantasController@create')
    );
Route::post('/ca_plantas/store', array(
        'as' => 'ca_planta.store',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-store',
        'uses' => 'Ca_plantasController@store')
    );
Route::get('/ca_planta/show/{id}', array(
        'as' => 'ca_planta.show',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-show',
        'uses' => 'Ca_plantasController@show')
    );
Route::get('/ca_planta/edit/{id}', array(
        'as' => 'ca_planta.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-edit',
        'uses' => 'Ca_plantasController@edit')
    );
Route::put('/ca_planta/update/{id}', array(
        'as' => 'ca_planta.update',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-update',
        'uses' => 'Ca_plantasController@update')
    );
Route::post('/ca_planta/destroy/{id}', array(
        'as' => 'ca_planta.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-destroy',
        'uses' => 'Ca_plantasController@destroy')
    );
Route::post('/ca_planta/recover/{id}', array(
        'as' => 'ca_planta.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_plantas-recover',
        'uses' => 'Ca_plantasController@recover')
    );
/*---------------------------------------------------------------------*/
/*------------------------------Fuentes fijas-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_fuentes_fija/index', array(
    'as' => 'ca_fuentes_fija.index',
    'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-index',
    'uses' => 'Ca_fuentes_fijasController@index')
);
Route::post('/ca_fuentes_fija/contentListIndex', array(
        'as' => 'ca_fuentes_fija.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-contentListIndex',
        'uses' => 'Ca_fuentes_fijasController@contentListIndex')
    );
Route::get('/ca_fuentes_fija/create', array(
        'as' => 'ca_fuentes_fija.create',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-create',
        'uses' => 'Ca_fuentes_fijasController@create')
    );
Route::post('/ca_fuentes_fijas/store', array(
        'as' => 'ca_fuentes_fija.store',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-store',
        'uses' => 'Ca_fuentes_fijasController@store')
    );
Route::get('/ca_fuentes_fija/show/{id}', array(
        'as' => 'ca_fuentes_fija.show',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-show',
        'uses' => 'Ca_fuentes_fijasController@show')
    );
Route::get('/ca_fuentes_fija/edit/{id}', array(
        'as' => 'ca_fuentes_fija.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-edit',
        'uses' => 'Ca_fuentes_fijasController@edit')
    );
Route::put('/ca_fuentes_fija/update/{id}', array(
        'as' => 'ca_fuentes_fija.update',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-update',
        'uses' => 'Ca_fuentes_fijasController@update')
    );
Route::post('/ca_fuentes_fija/destroy/{id}', array(
        'as' => 'ca_fuentes_fija.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-destroy',
        'uses' => 'Ca_fuentes_fijasController@destroy')
    );
Route::post('/ca_fuentes_fija/recover/{id}', array(
        'as' => 'ca_fuentes_fija.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_fuentes_fijas-recover',
        'uses' => 'Ca_fuentes_fijasController@recover')
    );

/*---------------------------------------------------------------------*/
/*------------------------------Residuos-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_residuo/index', array(
    'as' => 'ca_residuo.index',
    'before' => 'basicAuth2|hasPermissions2:ca_residuos-index',
    'uses' => 'Ca_residuosController@index')
);
Route::post('/ca_residuo/contentListIndex', array(
        'as' => 'ca_residuo.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-contentListIndex',
        'uses' => 'Ca_residuosController@contentListIndex')
    );
Route::get('/ca_residuo/create', array(
        'as' => 'ca_residuo.create',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-create',
        'uses' => 'Ca_residuosController@create')
    );
Route::post('/ca_residuos/store', array(
        'as' => 'ca_residuo.store',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-store',
        'uses' => 'Ca_residuosController@store')
    );
Route::get('/ca_residuo/show/{id}', array(
        'as' => 'ca_residuo.show',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-show',
        'uses' => 'Ca_residuosController@show')
    );
Route::get('/ca_residuo/edit/{id}', array(
        'as' => 'ca_residuo.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-edit',
        'uses' => 'Ca_residuosController@edit')
    );
Route::put('/ca_residuo/update/{id}', array(
        'as' => 'ca_residuo.update',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-update',
        'uses' => 'Ca_residuosController@update')
    );
Route::post('/ca_residuo/destroy/{id}', array(
        'as' => 'ca_residuo.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-destroy',
        'uses' => 'Ca_residuosController@destroy')
    );
Route::post('/ca_residuo/recover/{id}', array(
        'as' => 'ca_residuo.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_residuos-recover',
        'uses' => 'Ca_residuosController@recover')
    );

/*---------------------------------------------------------------------*/
/*-----------------------------Consumibles-----------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_consumible/index', array(
    'as' => 'ca_consumible.index',
    'before' => 'basicAuth2|hasPermissions2:ca_consumibles-index',
    'uses' => 'Ca_consumiblesController@index')
);
Route::post('/ca_consumible/contentListIndex', array(
        'as' => 'ca_consumible.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-contentListIndex',
        'uses' => 'Ca_consumiblesController@contentListIndex')
    );
Route::get('/ca_consumible/create', array(
        'as' => 'ca_consumible.create',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-create',
        'uses' => 'Ca_consumiblesController@create')
    );
Route::post('/ca_consumibles/store', array(
        'as' => 'ca_consumible.store',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-store',
        'uses' => 'Ca_consumiblesController@store')
    );
Route::get('/ca_consumible/show/{id}', array(
        'as' => 'ca_consumible.show',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-show',
        'uses' => 'Ca_consumiblesController@show')
    );
Route::get('/ca_consumible/edit/{id}', array(
        'as' => 'ca_consumible.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-edit',
        'uses' => 'Ca_consumiblesController@edit')
    );
Route::put('/ca_consumible/update/{id}', array(
        'as' => 'ca_consumible.update',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-update',
        'uses' => 'Ca_consumiblesController@update')
    );
Route::post('/ca_consumible/destroy/{id}', array(
        'as' => 'ca_consumible.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-destroy',
        'uses' => 'Ca_consumiblesController@destroy')
    );
Route::post('/ca_consumible/recover/{id}', array(
        'as' => 'ca_consumible.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_consumibles-recover',
        'uses' => 'Ca_consumiblesController@recover')
    );

/*---------------------------------------------------------------------*/
/*----------------------------Tipos de inconformidades-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_tpo_inconformidad/index', array(
    'as' => 'ca_tpo_inconformidad.index',
    'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-index',
    'uses' => 'Ca_tpo_inconformidadesController@index')
);
Route::post('/ca_tpo_inconformidad/contentListIndex', array(
        'as' => 'ca_tpo_inconformidad.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-contentListIndex',
        'uses' => 'Ca_tpo_inconformidadesController@contentListIndex')
    );
Route::get('/ca_tpo_inconformidad/create', array(
        'as' => 'ca_tpo_inconformidad.create',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-create',
        'uses' => 'Ca_tpo_inconformidadesController@create')
    );
Route::post('/ca_tpo_inconformidads/store', array(
        'as' => 'ca_tpo_inconformidad.store',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-store',
        'uses' => 'Ca_tpo_inconformidadesController@store')
    );
Route::get('/ca_tpo_inconformidad/show/{id}', array(
        'as' => 'ca_tpo_inconformidad.show',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-show',
        'uses' => 'Ca_tpo_inconformidadesController@show')
    );
Route::get('/ca_tpo_inconformidad/edit/{id}', array(
        'as' => 'ca_tpo_inconformidad.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-edit',
        'uses' => 'Ca_tpo_inconformidadesController@edit')
    );
Route::put('/ca_tpo_inconformidad/update/{id}', array(
        'as' => 'ca_tpo_inconformidad.update',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-update',
        'uses' => 'Ca_tpo_inconformidadesController@update')
    );
Route::post('/ca_tpo_inconformidad/destroy/{id}', array(
        'as' => 'ca_tpo_inconformidad.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-destroy',
        'uses' => 'Ca_tpo_inconformidadesController@destroy')
    );
Route::post('/ca_tpo_inconformidad/recover/{id}', array(
        'as' => 'ca_tpo_inconformidad.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_inconformidads-recover',
        'uses' => 'Ca_tpo_inconformidadesController@recover')
    );

/*----------------------------Seguridad--------------------------------*/
/*----------------------------Tipos de procedimientos-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_tpo_procedimiento/index', array(
    'as' => 'cs_tpo_procedimiento.index',
    'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-index',
    'uses' => 'Cs_tpo_procedimientosController@index')
);
Route::post('/cs_tpo_procedimiento/contentListIndex', array(
        'as' => 'cs_tpo_procedimiento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-contentListIndex',
        'uses' => 'Cs_tpo_procedimientosController@contentListIndex')
    );
Route::get('/cs_tpo_procedimiento/create', array(
        'as' => 'cs_tpo_procedimiento.create',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-create',
        'uses' => 'Cs_tpo_procedimientosController@create')
    );
Route::post('/cs_tpo_procedimientos/store', array(
        'as' => 'cs_tpo_procedimiento.store',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-store',
        'uses' => 'Cs_tpo_procedimientosController@store')
    );
Route::get('/cs_tpo_procedimiento/show/{id}', array(
        'as' => 'cs_tpo_procedimiento.show',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-show',
        'uses' => 'Cs_tpo_procedimientosController@show')
    );
Route::get('/cs_tpo_procedimiento/edit/{id}', array(
        'as' => 'cs_tpo_procedimiento.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-edit',
        'uses' => 'Cs_tpo_procedimientosController@edit')
    );
Route::put('/cs_tpo_procedimiento/update/{id}', array(
        'as' => 'cs_tpo_procedimiento.update',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-update',
        'uses' => 'Cs_tpo_procedimientosController@update')
    );
Route::post('/cs_tpo_procedimiento/destroy/{id}', array(
        'as' => 'cs_tpo_procedimiento.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-destroy',
        'uses' => 'Cs_tpo_procedimientosController@destroy')
    );
Route::post('/cs_tpo_procedimiento/recover/{id}', array(
        'as' => 'cs_tpo_procedimiento.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_procedimientos-recover',
        'uses' => 'Cs_tpo_procedimientosController@recover')
    );
/*----------------------------Seguridad--------------------------------*/
/*----------------------------Tipos de documentos-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_tpo_doc/index', array(
    'as' => 'cs_tpo_doc.index',
    'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-index',
    'uses' => 'Cs_tpo_docsController@index')
);
Route::post('/cs_tpo_doc/contentListIndex', array(
        'as' => 'cs_tpo_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-contentListIndex',
        'uses' => 'Cs_tpo_docsController@contentListIndex')
    );
Route::get('/cs_tpo_doc/create', array(
        'as' => 'cs_tpo_doc.create',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-create',
        'uses' => 'Cs_tpo_docsController@create')
    );
Route::post('/cs_tpo_docs/store', array(
        'as' => 'cs_tpo_doc.store',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-store',
        'uses' => 'Cs_tpo_docsController@store')
    );
Route::get('/cs_tpo_doc/show/{id}', array(
        'as' => 'cs_tpo_doc.show',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-show',
        'uses' => 'Cs_tpo_docsController@show')
    );
Route::get('/cs_tpo_doc/edit/{id}', array(
        'as' => 'cs_tpo_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-edit',
        'uses' => 'Cs_tpo_docsController@edit')
    );
Route::put('/cs_tpo_doc/update/{id}', array(
        'as' => 'cs_tpo_doc.update',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-update',
        'uses' => 'Cs_tpo_docsController@update')
    );
Route::post('/cs_tpo_doc/destroy/{id}', array(
        'as' => 'cs_tpo_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-destroy',
        'uses' => 'Cs_tpo_docsController@destroy')
    );
Route::post('/cs_tpo_doc/recover/{id}', array(
        'as' => 'cs_tpo_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_docs-recover',
        'uses' => 'Cs_tpo_docsController@recover')
    );

/*----------------------------Seguridad--------------------------------*/
/*----------------------------Grupos de normas-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_grupo_norma/index', array(
    'as' => 'cs_grupo_norma.index',
    'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-index',
    'uses' => 'Cs_grupo_normasController@index')
);
Route::post('/cs_grupo_norma/contentListIndex', array(
        'as' => 'cs_grupo_norma.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-contentListIndex',
        'uses' => 'Cs_grupo_normasController@contentListIndex')
    );
Route::get('/cs_grupo_norma/create', array(
        'as' => 'cs_grupo_norma.create',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-create',
        'uses' => 'Cs_grupo_normasController@create')
    );
Route::post('/cs_grupo_normas/store', array(
        'as' => 'cs_grupo_norma.store',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-store',
        'uses' => 'Cs_grupo_normasController@store')
    );
Route::get('/cs_grupo_norma/show/{id}', array(
        'as' => 'cs_grupo_norma.show',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-show',
        'uses' => 'Cs_grupo_normasController@show')
    );
Route::get('/cs_grupo_norma/edit/{id}', array(
        'as' => 'cs_grupo_norma.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-edit',
        'uses' => 'Cs_grupo_normasController@edit')
    );
Route::put('/cs_grupo_norma/update/{id}', array(
        'as' => 'cs_grupo_norma.update',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-update',
        'uses' => 'Cs_grupo_normasController@update')
    );
Route::post('/cs_grupo_norma/destroy/{id}', array(
        'as' => 'cs_grupo_norma.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-destroy',
        'uses' => 'cs_grupo_normasController@destroy')
    );
Route::post('/cs_grupo_norma/recover/{id}', array(
        'as' => 'cs_grupo_norma.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_grupo_normas-recover',
        'uses' => 'Cs_grupo_normasController@recover')
    );
/*----------------------------Seguridad--------------------------------*/
/*----------------------------Normas-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_norma/index', array(
    'as' => 'cs_norma.index',
    'before' => 'basicAuth2|hasPermissions2:cs_normas-index',
    'uses' => 'Cs_normasController@index')
);
Route::post('/cs_norma/contentListIndex', array(
        'as' => 'cs_norma.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-contentListIndex',
        'uses' => 'Cs_normasController@contentListIndex')
    );
Route::get('/cs_norma/create', array(
        'as' => 'cs_norma.create',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-create',
        'uses' => 'Cs_normasController@create')
    );
Route::post('/cs_normas/store', array(
        'as' => 'cs_norma.store',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-store',
        'uses' => 'Cs_normasController@store')
    );
Route::get('/cs_norma/show/{id}', array(
        'as' => 'cs_norma.show',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-show',
        'uses' => 'Cs_normasController@show')
    );
Route::get('/cs_norma/edit/{id}', array(
        'as' => 'cs_norma.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-edit',
        'uses' => 'Cs_normasController@edit')
    );
Route::put('/cs_norma/update/{id}', array(
        'as' => 'cs_norma.update',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-update',
        'uses' => 'Cs_normasController@update')
    );
Route::post('/cs_norma/destroy/{id}', array(
        'as' => 'cs_norma.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-destroy',
        'uses' => 'Cs_normasController@destroy')
    );
Route::post('/cs_norma/recover/{id}', array(
        'as' => 'cs_norma.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_normas-recover',
        'uses' => 'Cs_normasController@recover')
    );
/*----------------------------Seguridad--------------------------------*/
/*----------------------------Normas-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_elementos_inspeccion/index', array(
    'as' => 'cs_elementos_inspeccion.index',
    'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-index',
    'uses' => 'Cs_elementos_inspeccionsController@index')
);
Route::post('/cs_elementos_inspeccion/contentListIndex', array(
        'as' => 'cs_elementos_inspeccion.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-contentListIndex',
        'uses' => 'Cs_elementos_inspeccionsController@contentListIndex')
    );
Route::get('/cs_elementos_inspeccion/create', array(
        'as' => 'cs_elementos_inspeccion.create',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-create',
        'uses' => 'Cs_elementos_inspeccionsController@create')
    );
Route::post('/cs_elementos_inspeccions/store', array(
        'as' => 'cs_elementos_inspeccion.store',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-store',
        'uses' => 'Cs_elementos_inspeccionsController@store')
    );
Route::get('/cs_elementos_inspeccion/show/{id}', array(
        'as' => 'cs_elementos_inspeccion.show',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-show',
        'uses' => 'Cs_elementos_inspeccionsController@show')
    );
Route::get('/cs_elementos_inspeccion/edit/{id}', array(
        'as' => 'cs_elementos_inspeccion.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-edit',
        'uses' => 'Cs_elementos_inspeccionsController@edit')
    );
Route::post('/cs_elementos_inspeccion/update/{id}', array(
        'as' => 'cs_elementos_inspeccion.update',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-update',
        'uses' => 'Cs_elementos_inspeccionsController@update')
    );
Route::post('/cs_elementos_inspeccion/destroy/{id}', array(
        'as' => 'cs_elementos_inspeccion.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-destroy',
        'uses' => 'Cs_elementos_inspeccionsController@destroy')
    );
Route::post('/cs_elementos_inspeccion/recover/{id}', array(
        'as' => 'cs_elementos_inspeccion.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_elementos_inspeccions-recover',
        'uses' => 'Cs_elementos_inspeccionsController@recover')
    );
Route::post('/cs_elementos_inspeccion/cmbNormas', array(
        'as' => 'cs_elementos_inspeccion.cmbNormas',
        'before' => 'basicAuth2',
        'uses' => 'Cs_elementos_inspeccionsController@cmbNormas')
    );

/*----------------------------Seguridad--------------------------------*/
/*----------------------------Documentos de Seguridad-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_cat_doc/index', array(
    'as' => 'cs_cat_doc.index',
    'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-index',
    'uses' => 'Cs_cat_docsController@index')
);
Route::post('/cs_cat_doc/contentListIndex', array(
        'as' => 'cs_cat_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-contentListIndex',
        'uses' => 'Cs_cat_docsController@contentListIndex')
    );
Route::get('/cs_cat_doc/create', array(
        'as' => 'cs_cat_doc.create',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-create',
        'uses' => 'Cs_cat_docsController@create')
    );
Route::post('/cs_cat_docs/store', array(
        'as' => 'cs_cat_doc.store',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-store',
        'uses' => 'Cs_cat_docsController@store')
    );
Route::get('/cs_cat_doc/show/{id}', array(
        'as' => 'cs_cat_doc.show',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-show',
        'uses' => 'Cs_cat_docsController@show')
    );
Route::get('/cs_cat_doc/edit/{id}', array(
        'as' => 'cs_cat_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-edit',
        'uses' => 'Cs_cat_docsController@edit')
    );
Route::put('/cs_cat_doc/update/{id}', array(
        'as' => 'cs_cat_doc.update',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-update',
        'uses' => 'Cs_cat_docsController@update')
    );
Route::post('/cs_cat_doc/destroy/{id}', array(
        'as' => 'cs_cat_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-destroy',
        'uses' => 'Cs_cat_docsController@destroy')
    );
Route::post('/cs_cat_doc/recover/{id}', array(
        'as' => 'cs_cat_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_cat_docs-recover',
        'uses' => 'Cs_cat_docsController@recover')
    );

/*----------------------------Seguridad--------------------------------*/
/*----------------------------Accidentes-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_accidente/index', array(
    'as' => 'cs_accidente.index',
    'before' => 'basicAuth2|hasPermissions2:cs_accidentes-index',
    'uses' => 'Cs_accidentesController@index')
);
Route::post('/cs_accidente/contentListIndex', array(
        'as' => 'cs_accidente.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-contentListIndex',
        'uses' => 'Cs_accidentesController@contentListIndex')
    );
Route::get('/cs_accidente/create', array(
        'as' => 'cs_accidente.create',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-create',
        'uses' => 'Cs_accidentesController@create')
    );
Route::post('/cs_accidentes/store', array(
        'as' => 'cs_accidente.store',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-store',
        'uses' => 'Cs_accidentesController@store')
    );
Route::get('/cs_accidente/show/{id}', array(
        'as' => 'cs_accidente.show',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-show',
        'uses' => 'Cs_accidentesController@show')
    );
Route::get('/cs_accidente/edit/{id}', array(
        'as' => 'cs_accidente.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-edit',
        'uses' => 'Cs_accidentesController@edit')
    );
Route::put('/cs_accidente/update/{id}', array(
        'as' => 'cs_accidente.update',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-update',
        'uses' => 'Cs_accidentesController@update')
    );
Route::post('/cs_accidente/destroy/{id}', array(
        'as' => 'cs_accidente.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-destroy',
        'uses' => 'Cs_accidentesController@destroy')
    );
Route::post('/cs_accidente/recover/{id}', array(
        'as' => 'cs_accidente.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_accidentes-recover',
        'uses' => 'Cs_accidentesController@recover')
    );

/*----------------------------Seguridad--------------------------------*/
/*----------------------------Acciones por Accidente-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_accione/index', array(
    'as' => 'cs_accione.index',
    'before' => 'basicAuth2|hasPermissions2:cs_acciones-index',
    'uses' => 'Cs_accionesController@index')
);
Route::post('/cs_accione/contentListIndex', array(
        'as' => 'cs_accione.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-contentListIndex',
        'uses' => 'Cs_accionesController@contentListIndex')
    );
Route::get('/cs_accione/create', array(
        'as' => 'cs_accione.create',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-create',
        'uses' => 'Cs_accionesController@create')
    );
Route::post('/cs_acciones/store', array(
        'as' => 'cs_accione.store',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-store',
        'uses' => 'Cs_accionesController@store')
    );
Route::get('/cs_accione/show/{id}', array(
        'as' => 'cs_accione.show',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-show',
        'uses' => 'Cs_accionesController@show')
    );
Route::get('/cs_accione/edit/{id}', array(
        'as' => 'cs_accione.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-edit',
        'uses' => 'Cs_accionesController@edit')
    );
Route::put('/cs_accione/update/{id}', array(
        'as' => 'cs_accione.update',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-update',
        'uses' => 'Cs_accionesController@update')
    );
Route::post('/cs_accione/destroy/{id}', array(
        'as' => 'cs_accione.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-destroy',
        'uses' => 'Cs_accionesController@destroy')
    );
Route::post('/cs_accione/recover/{id}', array(
        'as' => 'cs_accione.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_acciones-recover',
        'uses' => 'Cs_accionesController@recover')
    );

/*----------------------------Seguridad--------------------------------*/
/*----------------------------Acciones por Accidente-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_enfermedade/index', array(
    'as' => 'cs_enfermedade.index',
    'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-index',
    'uses' => 'Cs_enfermedadesController@index')
);
Route::post('/cs_enfermedade/contentListIndex', array(
        'as' => 'cs_enfermedade.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-contentListIndex',
        'uses' => 'Cs_enfermedadesController@contentListIndex')
    );
Route::get('/cs_enfermedade/create', array(
        'as' => 'cs_enfermedade.create',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-create',
        'uses' => 'Cs_enfermedadesController@create')
    );
Route::post('/cs_enfermedades/store', array(
        'as' => 'cs_enfermedade.store',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-store',
        'uses' => 'Cs_enfermedadesController@store')
    );
Route::get('/cs_enfermedade/show/{id}', array(
        'as' => 'cs_enfermedade.show',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-show',
        'uses' => 'Cs_enfermedadesController@show')
    );
Route::get('/cs_enfermedade/edit/{id}', array(
        'as' => 'cs_enfermedade.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-edit',
        'uses' => 'Cs_enfermedadesController@edit')
    );
Route::put('/cs_enfermedade/update/{id}', array(
        'as' => 'cs_enfermedade.update',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-update',
        'uses' => 'Cs_enfermedadesController@update')
    );
Route::post('/cs_enfermedade/destroy/{id}', array(
        'as' => 'cs_enfermedade.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-destroy',
        'uses' => 'Cs_enfermedadesController@destroy')
    );
Route::post('/cs_enfermedade/recover/{id}', array(
        'as' => 'cs_enfermedade.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_enfermedades-recover',
        'uses' => 'Cs_enfermedadesController@recover')
    );

/******************************************************************/
/**********************Tipo de bitacora Seguridad*/
/******************************************************************/
Route::resource('Cs_tpo_bitacoras', 'Cs_tpo_bitacorasController');

Route::get('/cs_tpo_bitacora/index', array(
    'as' => 'cs_tpo_bitacora.index',
    'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-index',
    'uses' => 'Cs_tpo_bitacorasController@index')
);
Route::post('/cs_tpo_bitacora/contentListIndex', array(
        'as' => 'cs_tpo_bitacora.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-contentListIndex',
        'uses' => 'Cs_tpo_bitacorasController@contentListIndex')
    );
Route::get('/cs_tpo_bitacora/create', array(
        'as' => 'cs_tpo_bitacora.create',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-create',
        'uses' => 'Cs_tpo_bitacorasController@create')
    );
Route::post('/cs_tpo_bitacoras/store', array(
        'as' => 'cs_tpo_bitacora.store',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-store',
        'uses' => 'Cs_tpo_bitacorasController@store')
    );
Route::get('/cs_tpo_bitacora/show/{id}', array(
        'as' => 'cs_tpo_bitacora.show',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-show',
        'uses' => 'Cs_tpo_bitacorasController@show')
    );
Route::get('/cs_tpo_bitacora/edit/{id}', array(
        'as' => 'cs_tpo_bitacora.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-edit',
        'uses' => 'Cs_tpo_bitacorasController@edit')
    );
Route::post('/cs_tpo_bitacora/update/{id}', array(
        'as' => 'cs_tpo_bitacora.update',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-update',
        'uses' => 'Cs_tpo_bitacorasController@update')
    );
Route::post('/cs_tpo_bitacora/destroy/{id}', array(
        'as' => 'cs_tpo_bitacora.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-destroy',
        'uses' => 'Cs_tpo_bitacorasController@destroy')
    );
Route::post('/cs_tpo_bitacora/recover/{id}', array(
        'as' => 'cs_tpo_bitacora.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_bitacoras-recover',
        'uses' => 'Cs_tpo_bitacorasController@recover')
    );


/*----------------------------Seguridad--------------------------------*/
/*----------------------------Acciones por Accidente-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/cs_tpo_inconformidade/index', array(
    'as' => 'cs_tpo_inconformidade.index',
    'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-index',
    'uses' => 'Cs_tpo_inconformidadesController@index')
);
Route::post('/cs_tpo_inconformidade/contentListIndex', array(
        'as' => 'cs_tpo_inconformidade.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-contentListIndex',
        'uses' => 'Cs_tpo_inconformidadesController@contentListIndex')
    );
Route::get('/cs_tpo_inconformidade/create', array(
        'as' => 'cs_tpo_inconformidade.create',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-create',
        'uses' => 'Cs_tpo_inconformidadesController@create')
    );
Route::post('/cs_tpo_inconformidades/store', array(
        'as' => 'cs_tpo_inconformidade.store',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-store',
        'uses' => 'Cs_tpo_inconformidadesController@store')
    );
Route::get('/cs_tpo_inconformidade/show/{id}', array(
        'as' => 'cs_tpo_inconformidade.show',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-show',
        'uses' => 'Cs_tpo_inconformidadesController@show')
    );
Route::get('/cs_tpo_inconformidade/edit/{id}', array(
        'as' => 'cs_tpo_inconformidade.edit',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-edit',
        'uses' => 'Cs_tpo_inconformidadesController@edit')
    );
Route::put('/cs_tpo_inconformidade/update/{id}', array(
        'as' => 'cs_tpo_inconformidade.update',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-update',
        'uses' => 'Cs_tpo_inconformidadesController@update')
    );
Route::post('/cs_tpo_inconformidade/destroy/{id}', array(
        'as' => 'cs_tpo_inconformidade.destroy',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-destroy',
        'uses' => 'Cs_tpo_inconformidadesController@destroy')
    );
Route::post('/cs_tpo_inconformidade/recover/{id}', array(
        'as' => 'cs_tpo_inconformidade.recover',
        'before' => 'basicAuth2|hasPermissions2:cs_tpo_inconformidades-recover',
        'uses' => 'Cs_tpo_inconformidadesController@recover')
    );
/*--------------------------------------------------------------------*/
/*----------------------------Puestos-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/puesto/index', array(
    'as' => 'puesto.index',
    'before' => 'basicAuth2|hasPermissions2:puestos-index',
    'uses' => 'PuestosController@index')
);
Route::post('/puesto/contentListIndex', array(
        'as' => 'puesto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:puestos-contentListIndex',
        'uses' => 'PuestosController@contentListIndex')
    );
Route::get('/puesto/create', array(
        'as' => 'puesto.create',
        'before' => 'basicAuth2|hasPermissions2:puestos-create',
        'uses' => 'PuestosController@create')
    );
Route::post('/puestos/store', array(
        'as' => 'puesto.store',
        'before' => 'basicAuth2|hasPermissions2:puestos-store',
        'uses' => 'PuestosController@store')
    );
Route::get('/puesto/show/{id}', array(
        'as' => 'puesto.show',
        'before' => 'basicAuth2|hasPermissions2:puestos-show',
        'uses' => 'PuestosController@show')
    );
Route::get('/puesto/edit/{id}', array(
        'as' => 'puesto.edit',
        'before' => 'basicAuth2|hasPermissions2:puestos-edit',
        'uses' => 'PuestosController@edit')
    );
Route::put('/puesto/update/{id}', array(
        'as' => 'puesto.update',
        'before' => 'basicAuth2|hasPermissions2:puestos-update',
        'uses' => 'PuestosController@update')
    );
Route::post('/puesto/destroy/{id}', array(
        'as' => 'puesto.destroy',
        'before' => 'basicAuth2|hasPermissions2:puestos-destroy',
        'uses' => 'PuestosController@destroy')
    );
Route::post('/puesto/recover/{id}', array(
        'as' => 'puesto.recover',
        'before' => 'basicAuth2|hasPermissions2:puestos-recover',
        'uses' => 'PuestosController@recover')
    );

/*-------------------------------------------------------------------*/
/*----------------------------Empleados-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/empleado/index', array(
    'as' => 'empleado.index',
    'before' => 'basicAuth2|hasPermissions2:empleados-index',
    'uses' => 'EmpleadosController@index')
);
Route::post('/empleado/contentListIndex', array(
        'as' => 'empleado.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:empleados-contentListIndex',
        'uses' => 'EmpleadosController@contentListIndex')
    );
Route::get('/empleado/create', array(
        'as' => 'empleado.create',
        'before' => 'basicAuth2|hasPermissions2:empleados-create',
        'uses' => 'EmpleadosController@create')
    );
Route::post('/empleados/store', array(
        'as' => 'empleado.store',
        'before' => 'basicAuth2|hasPermissions2:empleados-store',
        'uses' => 'EmpleadosController@store')
    );
Route::get('/empleado/show/{id}', array(
        'as' => 'empleado.show',
        'before' => 'basicAuth2|hasPermissions2:empleados-show',
        'uses' => 'EmpleadosController@show')
    );
Route::get('/empleado/edit/{id}', array(
        'as' => 'empleado.edit',
        'before' => 'basicAuth2|hasPermissions2:empleados-edit',
        'uses' => 'EmpleadosController@edit')
    );
Route::put('/empleado/update/{id}', array(
        'as' => 'empleado.update',
        'before' => 'basicAuth2|hasPermissions2:empleados-update',
        'uses' => 'EmpleadosController@update')
    );
Route::post('/empleado/destroy/{id}', array(
        'as' => 'empleado.destroy',
        'before' => 'basicAuth2|hasPermissions2:empleados-destroy',
        'uses' => 'EmpleadosController@destroy')
    );
Route::post('/empleado/recover/{id}', array(
        'as' => 'empty(var)leado.recover',
        'before' => 'basicAuth2|hasPermissions2:empleados-recover',
        'uses' => 'EmpleadosController@recover')
    );
/*-------------------------------------------------------------------*/
/*-------------------------Docs. Manual Ambiental----------------------*/
/*---------------------------------------------------------------------*/
Route::get('/a_archivo/index', array(
    'as' => 'a_archivo.index',
    'before' => 'basicAuth2|hasPermissions2:a_archivos-index',
    'uses' => 'A_archivosController@index')
);
Route::post('/a_archivo/contentListIndex', array(
        'as' => 'a_archivo.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-contentListIndex',
        'uses' => 'A_archivosController@contentListIndex')
    );
Route::get('/a_archivo/create', array(
        'as' => 'a_archivo.create',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-create',
        'uses' => 'A_archivosController@create')
    );
Route::post('/a_archivos/store', array(
        'as' => 'a_archivo.store',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-store',
        'uses' => 'A_archivosController@store')
    );
Route::get('/a_archivo/show/{id}', array(
        'as' => 'a_archivo.show',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-show',
        'uses' => 'A_archivosController@show')
    );
Route::get('/a_archivo/edit/{id}', array(
        'as' => 'a_archivo.edit',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-edit',
        'uses' => 'A_archivosController@edit')
    );
Route::put('/a_archivo/update/{id}', array(
        'as' => 'a_archivo.update',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-update',
        'uses' => 'A_archivosController@update')
    );
Route::post('/a_archivo/destroy/{id}', array(
        'as' => 'a_archivo.destroy',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-destroy',
        'uses' => 'A_archivosController@destroy')
    );
Route::post('/a_archivo/recover/{id}', array(
        'as' => 'a_archivo.recover',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-recover',
        'uses' => 'A_archivosController@recover')
    );
Route::post('/a_archivo/comentarioEstatus', array(
        'as' => 'a_archivo.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:a_archivos-comentarioEstatus',
        'uses' => 'A_archivosController@comentarioEstatus')
    );

/***********Tabla de estatus de archivos de control de calidad**********/
/***********Tabla de estatus de procedimientos ambientales**********/
/*************************No tiene administrador************************/
Route::resource('a_st_archivos', 'A_st_archivosController');

/***********Tabla de comentraios de archivos de control de calidad**********/
/*************************Se visualiza en el a_archivo.show************************/
Route::post('/a_comentarios_archivo/contentListIndex', array(
        'as' => 'a_comentarios_archivo.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'A_comentarios_archivosController@contentListIndex')
    );

/*-------------------------------------------------------------------*/
/*-------------------------Docs. Manual Ambiental----------------------*/
/*---------------------------------------------------------------------*/
Route::get('/a_procedimiento/index', array(
    'as' => 'a_procedimiento.index',
    'before' => 'basicAuth2|hasPermissions2:a_procedimientos-index',
    'uses' => 'A_procedimientosController@index')
);
Route::post('/a_procedimiento/contentListIndex', array(
        'as' => 'a_procedimiento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-contentListIndex',
        'uses' => 'A_procedimientosController@contentListIndex')
    );
Route::get('/a_procedimiento/create', array(
        'as' => 'a_procedimiento.create',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-create',
        'uses' => 'A_procedimientosController@create')
    );
Route::post('/a_procedimientos/store', array(
        'as' => 'a_procedimiento.store',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-store',
        'uses' => 'A_procedimientosController@store')
    );
Route::get('/a_procedimiento/show/{id}', array(
        'as' => 'a_procedimiento.show',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-show',
        'uses' => 'A_procedimientosController@show')
    );
Route::get('/a_procedimiento/edit/{id}', array(
        'as' => 'a_procedimiento.edit',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-edit',
        'uses' => 'A_procedimientosController@edit')
    );
Route::put('/a_procedimiento/update/{id}', array(
        'as' => 'a_procedimiento.update',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-update',
        'uses' => 'A_procedimientosController@update')
    );
Route::post('/a_procedimiento/destroy/{id}', array(
        'as' => 'a_procedimiento.destroy',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-destroy',
        'uses' => 'A_procedimientosController@destroy')
    );
Route::post('/a_procedimiento/recover/{id}', array(
        'as' => 'a_procedimiento.recover',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-recover',
        'uses' => 'A_procedimientosController@recover')
    );
Route::post('/a_procedimiento/comentarioEstatus', array(
        'as' => 'a_procedimiento.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:a_procedimientos-comentarioEstatus',
        'uses' => 'A_procedimientosController@comentarioEstatus')
    );

/***********Tabla de comentarios de procedimientos ambientales******************/
/****************Se visualiza en el a_procedimeinto.show************************/
Route::resource('a_comentarios_procedimientos', 'A_comentarios_procedimientosController');
Route::post('/a_comentarios_procedimiento/contentListIndex', array(
        'as' => 'a_comentarios_procedimiento.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'A_comentarios_procedimientosController@contentListIndex')
    );

/*-------------------------------------------------------------------*/
/*-------------------------Docs. Manual Ambiental----------------------*/
/*---------------------------------------------------------------------*/
Route::get('/a_rr_ambientale/index', array(
    'as' => 'a_rr_ambientale.index',
    'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-index',
    'uses' => 'A_rr_ambientalesController@index')
);
Route::post('/a_rr_ambientale/contentListIndex', array(
        'as' => 'a_rr_ambientale.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-contentListIndex',
        'uses' => 'A_rr_ambientalesController@contentListIndex')
    );
Route::get('/a_rr_ambientale/create', array(
        'as' => 'a_rr_ambientale.create',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-create',
        'uses' => 'A_rr_ambientalesController@create')
    );
Route::post('/a_rr_ambientales/store', array(
        'as' => 'a_rr_ambientale.store',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-store',
        'uses' => 'A_rr_ambientalesController@store')
    );
Route::get('/a_rr_ambientale/show/{id}', array(
        'as' => 'a_rr_ambientale.show',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-show',
        'uses' => 'A_rr_ambientalesController@show')
    );
Route::get('/a_rr_ambientale/edit/{id}', array(
        'as' => 'a_rr_ambientale.edit',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-edit',
        'uses' => 'A_rr_ambientalesController@edit')
    );
Route::post('/a_rr_ambientale/update/{id}', array(
        'as' => 'a_rr_ambientale.update',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-update',
        'uses' => 'A_rr_ambientalesController@update')
    );
Route::post('/a_rr_ambientale/destroy/{id}', array(
        'as' => 'a_rr_ambientale.destroy',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-destroy',
        'uses' => 'A_rr_ambientalesController@destroy')
    );
Route::post('/a_rr_ambientale/recover/{id}', array(
        'as' => 'a_rr_ambientale.recover',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-recover',
        'uses' => 'A_rr_ambientalesController@recover')
    );
Route::post('/a_rr_ambientale/comentarioEstatus', array(
        'as' => 'a_rr_ambientale.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:a_rr_ambientales-comentarioEstatus',
        'uses' => 'A_rr_ambientalesController@comentarioEstatus')
    );
Route::post('/a_rr_ambientale/cmbCategorias', array(
        'as' => 'a_rr_ambientale.cmbCategorias',
        'before' => 'basicAuth2',
        'uses' => 'A_rr_ambientalesController@cmbCategorias')
    );
Route::post('/a_rr_ambientale/cmbDocumentos', array(
        'as' => 'a_rr_ambientale.cmbDocumentos',
        'before' => 'basicAuth2',
        'uses' => 'A_rr_ambientalesController@cmbDocumentos')
    );
/***********Tabla de comentarios de procedimientos ambientales******************/
/****************Se visualiza en el a_procedimeinto.show************************/
Route::resource('a_comentarios_rrs', 'A_comentarios_rrsController');
Route::post('/a_comentarios_rr/contentListIndex', array(
        'as' => 'a_comentarios_rr.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'A_comentarios_rrsController@contentListIndex')
    );

/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Fuentes Fijas-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_ff/index', array(
    'as' => 'bitacora_ff.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-index',
    'uses' => 'Bitacora_ffsController@index')
);
Route::post('/bitacora_ff/contentListIndex', array(
        'as' => 'bitacora_ff.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-contentListIndex',
        'uses' => 'Bitacora_ffsController@contentListIndex')
    );
Route::get('/bitacora_ff/create', array(
        'as' => 'bitacora_ff.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-create',
        'uses' => 'Bitacora_ffsController@create')
    );
Route::post('/bitacora_ffs/store', array(
        'as' => 'bitacora_ff.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-store',
        'uses' => 'Bitacora_ffsController@store')
    );
Route::get('/bitacora_ff/show/{id}', array(
        'as' => 'bitacora_ff.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-show',
        'uses' => 'Bitacora_ffsController@show')
    );
Route::get('/bitacora_ff/edit/{id}', array(
        'as' => 'bitacora_ff.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-edit',
        'uses' => 'Bitacora_ffsController@edit')
    );
Route::put('/bitacora_ff/update/{id}', array(
        'as' => 'bitacora_ff.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-update',
        'uses' => 'Bitacora_ffsController@update')
    );
Route::post('/bitacora_ff/destroy/{id}', array(
        'as' => 'bitacora_ff.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-destroy',
        'uses' => 'Bitacora_ffsController@destroy')
    );
Route::post('/bitacora_ff/recover/{id}', array(
        'as' => 'empty(var)leado.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_ffs-recover',
        'uses' => 'Bitacora_ffsController@recover')
    );

/************Turnos, no tienes administardor************/
Route::resource('turnos', 'TurnosController');

/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Plantas-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_planta/index', array(
    'as' => 'bitacora_planta.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-index',
    'uses' => 'Bitacora_plantasController@index')
);
Route::post('/bitacora_planta/contentListIndex', array(
        'as' => 'bitacora_planta.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-contentListIndex',
        'uses' => 'Bitacora_plantasController@contentListIndex')
    );
Route::get('/bitacora_planta/create', array(
        'as' => 'bitacora_planta.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-create',
        'uses' => 'Bitacora_plantasController@create')
    );
Route::post('/bitacora_plantas/store', array(
        'as' => 'bitacora_planta.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-store',
        'uses' => 'Bitacora_plantasController@store')
    );
Route::get('/bitacora_planta/show/{id}', array(
        'as' => 'bitacora_planta.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-show',
        'uses' => 'Bitacora_plantasController@show')
    );
Route::get('/bitacora_planta/edit/{id}', array(
        'as' => 'bitacora_planta.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-edit',
        'uses' => 'Bitacora_plantasController@edit')
    );
Route::put('/bitacora_planta/update/{id}', array(
        'as' => 'bitacora_planta.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-update',
        'uses' => 'Bitacora_plantasController@update')
    );
Route::post('/bitacora_planta/destroy/{id}', array(
        'as' => 'bitacora_planta.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-destroy',
        'uses' => 'Bitacora_plantasController@destroy')
    );
Route::post('/bitacora_planta/recover/{id}', array(
        'as' => 'empty(var)leado.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_plantas-recover',
        'uses' => 'Bitacora_plantasController@recover')
    );
/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Residuos-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_residuo/index', array(
    'as' => 'bitacora_residuo.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-index',
    'uses' => 'Bitacora_residuosController@index')
);
Route::post('/bitacora_residuo/contentListIndex', array(
        'as' => 'bitacora_residuo.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-contentListIndex',
        'uses' => 'Bitacora_residuosController@contentListIndex')
    );
Route::get('/bitacora_residuo/create', array(
        'as' => 'bitacora_residuo.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-create',
        'uses' => 'Bitacora_residuosController@create')
    );
Route::post('/bitacora_residuos/store', array(
        'as' => 'bitacora_residuo.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-store',
        'uses' => 'Bitacora_residuosController@store')
    );
Route::get('/bitacora_residuo/show/{id}', array(
        'as' => 'bitacora_residuo.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-show',
        'uses' => 'Bitacora_residuosController@show')
    );
Route::get('/bitacora_residuo/edit/{id}', array(
        'as' => 'bitacora_residuo.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-edit',
        'uses' => 'Bitacora_residuosController@edit')
    );
Route::put('/bitacora_residuo/update/{id}', array(
        'as' => 'bitacora_residuo.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-update',
        'uses' => 'Bitacora_residuosController@update')
    );
Route::post('/bitacora_residuo/destroy/{id}', array(
        'as' => 'bitacora_residuo.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-destroy',
        'uses' => 'Bitacora_residuosController@destroy')
    );
Route::post('/bitacora_residuo/recover/{id}', array(
        'as' => 'bitacora_residuo.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_residuos-recover',
        'uses' => 'Bitacora_residuosController@recover')
    );

/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Consumibles-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_consumible/index', array(
    'as' => 'bitacora_consumible.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-index',
    'uses' => 'Bitacora_consumiblesController@index')
);
Route::post('/bitacora_consumible/contentListIndex', array(
        'as' => 'bitacora_consumible.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-contentListIndex',
        'uses' => 'Bitacora_consumiblesController@contentListIndex')
    );
Route::get('/bitacora_consumible/create', array(
        'as' => 'bitacora_consumible.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-create',
        'uses' => 'Bitacora_consumiblesController@create')
    );
Route::post('/bitacora_consumibles/store', array(
        'as' => 'bitacora_consumible.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-store',
        'uses' => 'Bitacora_consumiblesController@store')
    );
Route::get('/bitacora_consumible/show/{id}', array(
        'as' => 'bitacora_consumible.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-show',
        'uses' => 'Bitacora_consumiblesController@show')
    );
Route::get('/bitacora_consumible/edit/{id}', array(
        'as' => 'bitacora_consumible.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-edit',
        'uses' => 'Bitacora_consumiblesController@edit')
    );
Route::put('/bitacora_consumible/update/{id}', array(
        'as' => 'bitacora_consumible.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-update',
        'uses' => 'Bitacora_consumiblesController@update')
    );
Route::post('/bitacora_consumible/destroy/{id}', array(
        'as' => 'bitacora_consumible.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-destroy',
        'uses' => 'Bitacora_consumiblesController@destroy')
    );
Route::post('/bitacora_consumible/recover/{id}', array(
        'as' => 'bitacora_consumible.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_consumibles-recover',
        'uses' => 'Bitacora_consumiblesController@recover')
    );

/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Pendientes-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_pendiente/index', array(
    'as' => 'bitacora_pendiente.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-index',
    'uses' => 'Bitacora_pendientesController@index')
);
Route::post('/bitacora_pendiente/contentListIndex', array(
        'as' => 'bitacora_pendiente.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-contentListIndex',
        'uses' => 'Bitacora_pendientesController@contentListIndex')
    );
Route::get('/bitacora_pendiente/create', array(
        'as' => 'bitacora_pendiente.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-create',
        'uses' => 'Bitacora_pendientesController@create')
    );
Route::post('/bitacora_pendientes/store', array(
        'as' => 'bitacora_pendiente.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-store',
        'uses' => 'Bitacora_pendientesController@store')
    );
Route::get('/bitacora_pendiente/show/{id}', array(
        'as' => 'bitacora_pendiente.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-show',
        'uses' => 'Bitacora_pendientesController@show')
    );
Route::get('/bitacora_pendiente/edit/{id}', array(
        'as' => 'bitacora_pendiente.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-edit',
        'uses' => 'Bitacora_pendientesController@edit')
    );
Route::put('/bitacora_pendiente/update/{id}', array(
        'as' => 'bitacora_pendiente.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-update',
        'uses' => 'Bitacora_pendientesController@update')
    );
Route::post('/bitacora_pendiente/destroy/{id}', array(
        'as' => 'bitacora_pendiente.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-destroy',
        'uses' => 'Bitacora_pendientesController@destroy')
    );
Route::post('/bitacora_pendiente/recover/{id}', array(
        'as' => 'bitacora_pendiente.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendientes-recover',
        'uses' => 'Bitacora_pendientesController@recover')
    );
Route::post('/bitacora_pendiente/comentarioEstatus', array(
        'as' => 'bitacora_pendiente.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:bitacora_pendiente-comentarioEstatus',
        'uses' => 'Bitacora_pendientesController@comentarioEstatus')
    );


/*****************ESTATUS DE BITACORA DE PENDIENTES-SIN ADMIN******************/
Route::resource('bit_sts', 'Bit_stsController');
/***********Tabla de comentarios de procedimientos ambientales******************/
/****************Se visualiza en el a_procedimeinto.show************************/
Route::resource('a_comentarios_pendientes', 'A_comentarios_pendientesController');
Route::post('/a_comentarios_pendiente/contentListIndex', array(
        'as' => 'a_comentarios_pendiente.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'A_comentarios_pendientesController@contentListIndex')
    );
/*****************ESTATUS DE NO CONFORMIDADES******************/
Route::resource('a_st_ncs', 'A_st_ncsController');

/*-------------------------------------------------------------------*/
/*----------------------------No conformidades-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/a_no_conformidade/index', array(
    'as' => 'a_no_conformidade.index',
    'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-index',
    'uses' => 'A_no_conformidadesController@index')
);
Route::post('/a_no_conformidade/contentListIndex', array(
        'as' => 'a_no_conformidade.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-contentListIndex',
        'uses' => 'A_no_conformidadesController@contentListIndex')
    );
Route::get('/a_no_conformidade/create', array(
        'as' => 'a_no_conformidade.create',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-create',
        'uses' => 'A_no_conformidadesController@create')
    );
Route::post('/a_no_conformidades/store', array(
        'as' => 'a_no_conformidade.store',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-store',
        'uses' => 'A_no_conformidadesController@store')
    );
Route::get('/a_no_conformidade/show/{id}', array(
        'as' => 'a_no_conformidade.show',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-show',
        'uses' => 'A_no_conformidadesController@show')
    );
Route::get('/a_no_conformidade/edit/{id}', array(
        'as' => 'a_no_conformidade.edit',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-edit',
        'uses' => 'A_no_conformidadesController@edit')
    );
Route::post('/a_no_conformidade/update/{id}', array(
        'as' => 'a_no_conformidade.update',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-update',
        'uses' => 'A_no_conformidadesController@update')
    );
Route::post('/a_no_conformidade/destroy/{id}', array(
        'as' => 'a_no_conformidade.destroy',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-destroy',
        'uses' => 'A_no_conformidadesController@destroy')
    );
Route::post('/a_no_conformidade/recover/{id}', array(
        'as' => 'a_no_conformidade.recover',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidades-recover',
        'uses' => 'A_no_conformidadesController@recover')
    );
Route::post('/a_no_conformidade/comentarioEstatus', array(
        'as' => 'a_no_conformidade.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:a_no_conformidade-comentarioEstatus',
        'uses' => 'A_no_conformidadesController@comentarioEstatus')
    );
Route::post('/a_no_conformidade/cmbInconformidades/{id}', array(
        'as' => 'a_no_conformidade.cmbInconformidades',
        'before' => 'basicAuth2',
        'uses' => 'A_no_conformidadesController@cmbInconformidades')
    );
/***********Tabla de comentarios de procedimientos ambientales******************/
/****************Se visualiza en el a_procedimeinto.show************************/
Route::resource('a_comentarios_ncs', 'A_comentarios_ncsController');
Route::post('/a_comentarios_nc/contentListIndex', array(
        'as' => 'a_comentarios_nc.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'A_comentarios_ncsController@contentListIndex')
    );

/*****************Tipo de detecciones sin administrador******************/
Route::resource('cs_tpo_deteccions', 'Cs_tpo_deteccionsController');

/*-------------------------------------------------------------------*/
/*----------------------------Procedimientos de seguridad-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/s_procedimiento/index', array(
    'as' => 's_procedimiento.index',
    'before' => 'basicAuth2|hasPermissions2:s_procedimientos-index',
    'uses' => 'S_procedimientosController@index')
);
Route::post('/s_procedimiento/contentListIndex', array(
        'as' => 's_procedimiento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-contentListIndex',
        'uses' => 'S_procedimientosController@contentListIndex')
    );
Route::get('/s_procedimiento/create', array(
        'as' => 's_procedimiento.create',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-create',
        'uses' => 'S_procedimientosController@create')
    );
Route::post('/s_procedimientos/store', array(
        'as' => 's_procedimiento.store',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-store',
        'uses' => 'S_procedimientosController@store')
    );
Route::get('/s_procedimiento/show/{id}', array(
        'as' => 's_procedimiento.show',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-show',
        'uses' => 'S_procedimientosController@show')
    );
Route::get('/s_procedimiento/edit/{id}', array(
        'as' => 's_procedimiento.edit',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-edit',
        'uses' => 'S_procedimientosController@edit')
    );
Route::post('/s_procedimiento/update/{id}', array(
        'as' => 's_procedimiento.update',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-update',
        'uses' => 'S_procedimientosController@update')
    );
Route::post('/s_procedimiento/destroy/{id}', array(
        'as' => 's_procedimiento.destroy',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-destroy',
        'uses' => 'S_procedimientosController@destroy')
    );
Route::post('/s_procedimiento/recover/{id}', array(
        'as' => 's_procedimiento.recover',
        'before' => 'basicAuth2|hasPermissions2:s_procedimientos-recover',
        'uses' => 'S_procedimientosController@recover')
    );
Route::post('/s_procedimiento/comentarioEstatus', array(
        'as' => 's_procedimiento.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:s_procedimiento-comentarioEstatus',
        'uses' => 'S_procedimientosController@comentarioEstatus')
    );
Route::post('/s_procedimiento/cmbDocumentos/{id}', array(
        'as' => 's_procedimiento.cmbDocumentos',
        'before' => 'basicAuth2',
        'uses' => 'S_procedimientosController@cmbDocumentos')
    );

/***********Tabla de comentarios de procedimientos ambientales******************/
/****************Se visualiza en el a_procedimeinto.show************************/
Route::resource('s_comentarios_procedimientos', 'S_comentarios_procedimientosController');
Route::post('/s_comentarios_procedimiento/contentListIndex', array(
        'as' => 's_comentarios_procedimiento.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'S_comentarios_procedimientosController@contentListIndex')
    );
/*****************Estatus de procedimientos sin administrador******************/
Route::resource('s_estatus_procedimientos', 'S_estatus_procedimientosController');

/*-------------------------------------------------------------------*/
/*----------------------------Procedimientos de seguridad-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/s_registro/index', array(
    'as' => 's_registro.index',
    'before' => 'basicAuth2|hasPermissions2:s_registros-index',
    'uses' => 'S_registrosController@index')
);
Route::post('/s_registro/contentListIndex', array(
        'as' => 's_registro.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:s_registros-contentListIndex',
        'uses' => 'S_registrosController@contentListIndex')
    );
Route::get('/s_registro/create', array(
        'as' => 's_registro.create',
        'before' => 'basicAuth2|hasPermissions2:s_registros-create',
        'uses' => 'S_registrosController@create')
    );
Route::post('/s_registros/store', array(
        'as' => 's_registro.store',
        'before' => 'basicAuth2|hasPermissions2:s_registros-store',
        'uses' => 'S_registrosController@store')
    );
Route::get('/s_registro/show/{id}', array(
        'as' => 's_registro.show',
        'before' => 'basicAuth2|hasPermissions2:s_registros-show',
        'uses' => 'S_registrosController@show')
    );
Route::get('/s_registro/edit/{id}', array(
        'as' => 's_registro.edit',
        'before' => 'basicAuth2|hasPermissions2:s_registros-edit',
        'uses' => 'S_registrosController@edit')
    );
Route::post('/s_registro/update/{id}', array(
        'as' => 's_registro.update',
        'before' => 'basicAuth2|hasPermissions2:s_registros-update',
        'uses' => 'S_registrosController@update')
    );
Route::post('/s_registro/destroy/{id}', array(
        'as' => 's_registro.destroy',
        'before' => 'basicAuth2|hasPermissions2:s_registros-destroy',
        'uses' => 'S_registrosController@destroy')
    );
Route::post('/s_registro/recover/{id}', array(
        'as' => 's_registro.recover',
        'before' => 'basicAuth2|hasPermissions2:s_registros-recover',
        'uses' => 'S_registrosController@recover')
    );
Route::post('/s_registro/comentarioEstatus', array(
        'as' => 's_registro.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:s_registros-comentarioEstatus',
        'uses' => 'S_registrosController@comentarioEstatus')
    );
Route::post('/s_registro/cmbNormas/{id}', array(
        'as' => 's_registro.cmbNormas',
        'before' => 'basicAuth2',
        'uses' => 'S_registrosController@cmbNormas')
    );
Route::post('/s_registro/cmbElemento/{id}', array(
        'as' => 's_registro.cmbElementos',
        'before' => 'basicAuth2',
        'uses' => 'S_registrosController@cmbElementos')
    );
/***********Tabla de comentarios de procedimientos ambientales******************/
/****************Se visualiza en el a_procedimeinto.show************************/
Route::resource('s_comentarios_registros', 'S_comentarios_registrosController');
Route::post('/s_comentarios_registro/contentListIndex', array(
        'as' => 's_comentarios_registro.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'S_comentarios_registrosController@contentListIndex')
    );
/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de seguridad-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_seguridad/index', array(
    'as' => 'bitacora_seguridad.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-index',
    'uses' => 'Bitacora_seguridadsController@index')
);
Route::post('/bitacora_seguridad/contentListIndex', array(
        'as' => 'bitacora_seguridad.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-contentListIndex',
        'uses' => 'Bitacora_seguridadsController@contentListIndex')
    );
Route::get('/bitacora_seguridad/create', array(
        'as' => 'bitacora_seguridad.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-create',
        'uses' => 'Bitacora_seguridadsController@create')
    );
Route::post('/bitacora_seguridads/store', array(
        'as' => 'bitacora_seguridad.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-store',
        'uses' => 'Bitacora_seguridadsController@store')
    );
Route::get('/bitacora_seguridad/show/{id}', array(
        'as' => 'bitacora_seguridad.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-show',
        'uses' => 'Bitacora_seguridadsController@show')
    );
Route::get('/bitacora_seguridad/edit/{id}', array(
        'as' => 'bitacora_seguridad.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-edit',
        'uses' => 'Bitacora_seguridadsController@edit')
    );
Route::post('/bitacora_seguridad/update/{id}', array(
        'as' => 'bitacora_seguridad.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-update',
        'uses' => 'Bitacora_seguridadsController@update')
    );
Route::post('/bitacora_seguridad/destroy/{id}', array(
        'as' => 'bitacora_seguridad.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-destroy',
        'uses' => 'Bitacora_seguridadsController@destroy')
    );
Route::post('/bitacora_seguridad/recover/{id}', array(
        'as' => 'bitacora_seguridad.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-recover',
        'uses' => 'Bitacora_seguridadsController@recover')
    );
Route::post('/bitacora_seguridad/comentarioEstatus', array(
        'as' => 'bitacora_seguridad.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:bitacora_seguridads-comentarioEstatus',
        'uses' => 'Bitacora_seguridadsController@comentarioEstatus')
    );
Route::post('/bitacora_seguridad/cmbNormas/{id}', array(
        'as' => 'bitacora_seguridad.cmbNormas',
        'before' => 'basicAuth2',
        'uses' => 'Bitacora_seguridadsController@cmbNormas')
    );
Route::post('/bitacora_seguridad/cmbTpoInconformidades/{id}', array(
        'as' => 'bitacora_seguridad.cmbTpoInconformidades',
        'before' => 'basicAuth2',
        'uses' => 'Bitacora_seguridadsController@cmbTpoInconformidades')
    );
/***********Tabla de comentarios de bitacora de seguridad******************/
Route::resource('comentarios_bs', 'Comentarios_bsController');
Route::post('/comentarios_bs/contentListIndex', array(
        'as' => 'comentarios_bs.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'Comentarios_bsController@contentListIndex')
    );

/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de seguridad-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/s_documento/index', array(
    'as' => 's_documento.index',
    'before' => 'basicAuth2|hasPermissions2:s_documentos-index',
    'uses' => 'S_documentosController@index')
);
Route::post('/s_documento/contentListIndex', array(
        'as' => 's_documento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-contentListIndex',
        'uses' => 'S_documentosController@contentListIndex')
    );
Route::get('/s_documento/create', array(
        'as' => 's_documento.create',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-create',
        'uses' => 'S_documentosController@create')
    );
Route::post('/s_documentos/store', array(
        'as' => 's_documento.store',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-store',
        'uses' => 'S_documentosController@store')
    );
Route::get('/s_documento/show/{id}', array(
        'as' => 's_documento.show',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-show',
        'uses' => 'S_documentosController@show')
    );
Route::get('/s_documento/edit/{id}', array(
        'as' => 's_documento.edit',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-edit',
        'uses' => 'S_documentosController@edit')
    );
Route::put('/s_documento/update/{id}', array(
        'as' => 's_documento.update',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-update',
        'uses' => 'S_documentosController@update')
    );
Route::post('/s_documento/destroy/{id}', array(
        'as' => 's_documento.destroy',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-destroy',
        'uses' => 'S_documentosController@destroy')
    );
Route::post('/s_documento/recover/{id}', array(
        'as' => 's_documento.recover',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-recover',
        'uses' => 'S_documentosController@recover')
    );
Route::post('/s_documento/comentarioEstatus', array(
        'as' => 's_documento.comentarioEstatus',
        'before' => 'basicAuth2|hasPermissions2:s_documentos-comentarioEstatus',
        'uses' => 'S_documentosController@comentarioEstatus')
    );

/***********Tabla de comentarios de documentos de seguridad******************/
Route::resource('s_comentarios_documentos', 'S_comentarios_documentosController');
Route::post('/s_comentarios_documento/contentListIndex', array(
        'as' => 's_comentarios_documento.contentListIndex',
        'before' => 'basicAuth2',
        'uses' => 'S_comentarios_documentosController@contentListIndex')
    );
/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Accidentes-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_accidente/index', array(
    'as' => 'bitacora_accidente.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-index',
    'uses' => 'Bitacora_accidentesController@index')
);
Route::post('/bitacora_accidente/contentListIndex', array(
        'as' => 'bitacora_accidente.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-contentListIndex',
        'uses' => 'Bitacora_accidentesController@contentListIndex')
    );
Route::get('/bitacora_accidente/create', array(
        'as' => 'bitacora_accidente.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-create',
        'uses' => 'Bitacora_accidentesController@create')
    );
Route::post('/bitacora_accidentes/store', array(
        'as' => 'bitacora_accidente.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-store',
        'uses' => 'Bitacora_accidentesController@store')
    );
Route::get('/bitacora_accidente/show/{id}', array(
        'as' => 'bitacora_accidente.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-show',
        'uses' => 'Bitacora_accidentesController@show')
    );
Route::get('/bitacora_accidente/edit/{id}', array(
        'as' => 'bitacora_accidente.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-edit',
        'uses' => 'Bitacora_accidentesController@edit')
    );
Route::put('/bitacora_accidente/update/{id}', array(
        'as' => 'bitacora_accidente.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-update',
        'uses' => 'Bitacora_accidentesController@update')
    );
Route::post('/bitacora_accidente/destroy/{id}', array(
        'as' => 'bitacora_accidente.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-destroy',
        'uses' => 'Bitacora_accidentesController@destroy')
    );
Route::post('/bitacora_accidente/recover/{id}', array(
        'as' => 'empty(var)leado.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_accidentes-recover',
        'uses' => 'Bitacora_accidentesController@recover')
    );
/*-------------------------------------------------------------------*/
/*----------------------------Bitacora de Enfermedades-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bitacora_enfermedade/index', array(
    'as' => 'bitacora_enfermedade.index',
    'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-index',
    'uses' => 'Bitacora_enfermedadesController@index')
);
Route::post('/bitacora_enfermedade/contentListIndex', array(
        'as' => 'bitacora_enfermedade.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-contentListIndex',
        'uses' => 'Bitacora_enfermedadesController@contentListIndex')
    );
Route::get('/bitacora_enfermedade/create', array(
        'as' => 'bitacora_enfermedade.create',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-create',
        'uses' => 'Bitacora_enfermedadesController@create')
    );
Route::post('/bitacora_enfermedades/store', array(
        'as' => 'bitacora_enfermedade.store',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-store',
        'uses' => 'Bitacora_enfermedadesController@store')
    );
Route::get('/bitacora_enfermedade/show/{id}', array(
        'as' => 'bitacora_enfermedade.show',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-show',
        'uses' => 'Bitacora_enfermedadesController@show')
    );
Route::get('/bitacora_enfermedade/edit/{id}', array(
        'as' => 'bitacora_enfermedade.edit',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-edit',
        'uses' => 'Bitacora_enfermedadesController@edit')
    );
Route::put('/bitacora_enfermedade/update/{id}', array(
        'as' => 'bitacora_enfermedade.update',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-update',
        'uses' => 'Bitacora_enfermedadesController@update')
    );
Route::post('/bitacora_enfermedade/destroy/{id}', array(
        'as' => 'bitacora_enfermedade.destroy',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-destroy',
        'uses' => 'Bitacora_enfermedadesController@destroy')
    );
Route::post('/bitacora_enfermedade/recover/{id}', array(
        'as' => 'empty(var)leado.recover',
        'before' => 'basicAuth2|hasPermissions2:bitacora_enfermedades-recover',
        'uses' => 'Bitacora_enfermedadesController@recover')
    );

/************************************Cubos de Analisis************************/
Route::get('/cubo/fuenteFija', array(
    'as' => 'cubo.fuenteFija',
    'before' => 'basicAuth2|hasPermissions2:cubos-fuenteFija',
    'uses' => 'CubosController@getFuentefija')
);
Route::get('/cubo/planta', array(
    'as' => 'cubo.planta',
    'before' => 'basicAuth2|hasPermissions2:cubos-planta',
    'uses' => 'CubosController@getPlanta')
);
Route::get('/cubo/residuo', array(
    'as' => 'cubo.residuo',
    'before' => 'basicAuth2|hasPermissions2:cubos-residuo',
    'uses' => 'CubosController@getResiduo')
);
Route::get('/cubo/consumible', array(
    'as' => 'cubo.consumible',
    'before' => 'basicAuth2|hasPermissions2:cubos-consumible',
    'uses' => 'CubosController@getConsumible')
);
Route::get('/cubo/noConformidades', array(
    'as' => 'cubo.noConformidades',
    'before' => 'basicAuth2|hasPermissions2:cubos-noConformidades',
    'uses' => 'CubosController@getNoConformidades')
);
Route::get('/cubo/accidentes', array(
    'as' => 'cubo.accidentes',
    'before' => 'basicAuth2|hasPermissions2:cubos-accidentes',
    'uses' => 'CubosController@getAccidentes')
);
Route::get('/cubo/enfermedades', array(
    'as' => 'cubo.enfermedades',
    'before' => 'basicAuth2|hasPermissions2:cubos-enfermedades',
    'uses' => 'CubosController@getEnfermedades')
);
/***********************************Consultas************************/
Route::get('/consulta/fuenteFija', array(
    'as' => 'consulta.fuenteFija',
    'before' => 'basicAuth2|hasPermissions2:consultas-fuenteFija',
    'uses' => 'ConsultasController@getFuenteFija')
);
Route::post('/consulta/fuenteFija', array(
    'as' => 'consulta.fuenteFija',
    'before' => 'basicAuth2|hasPermissions2:consultas-fuenteFija',
    'uses' => 'ConsultasController@postFuenteFija')
);
Route::get('/consulta/planta', array(
    'as' => 'consulta.planta',
    'before' => 'basicAuth2|hasPermissions2:consultas-planta',
    'uses' => 'ConsultasController@getPlanta')
);
Route::post('/consulta/planta', array(
    'as' => 'consulta.planta',
    'before' => 'basicAuth2|hasPermissions2:consultas-planta',
    'uses' => 'ConsultasController@postPlanta')
);
Route::get('/consulta/residuo', array(
    'as' => 'consulta.residuo',
    'before' => 'basicAuth2|hasPermissions2:consultas-residuo',
    'uses' => 'ConsultasController@getResiduo')
);
Route::post('/consulta/residuo', array(
    'as' => 'consulta.residuo',
    'before' => 'basicAuth2|hasPermissions2:consultas-residuo',
    'uses' => 'ConsultasController@postResiduo')
);
Route::get('/consulta/consumible', array(
    'as' => 'consulta.consumible',
    'before' => 'basicAuth2|hasPermissions2:consultas-consumible',
    'uses' => 'ConsultasController@getConsumible')
);
Route::post('/consulta/consumible', array(
    'as' => 'consulta.consumible',
    'before' => 'basicAuth2|hasPermissions2:consultas-consumible',
    'uses' => 'ConsultasController@postConsumible')
);
Route::get('/consulta/noConformidad', array(
    'as' => 'consulta.noConformidad',
    'before' => 'basicAuth2|hasPermissions2:consultas-noConformidad',
    'uses' => 'ConsultasController@getNoConformidad')
);
Route::post('/consulta/noConformidad', array(
    'as' => 'consulta.noConformidad',
    'before' => 'basicAuth2|hasPermissions2:consultas-noConformidad',
    'uses' => 'ConsultasController@postNoConformidad')
);
Route::get('/consulta/accidente', array(
    'as' => 'consulta.accidente',
    'before' => 'basicAuth2|hasPermissions2:consultas-accidente',
    'uses' => 'ConsultasController@getAccidente')
);
Route::post('/consulta/accidente', array(
    'as' => 'consulta.accidente',
    'before' => 'basicAuth2|hasPermissions2:consultas-accidente',
    'uses' => 'ConsultasController@postAccidente')
);
Route::get('/consulta/enfermedad', array(
    'as' => 'consulta.enfermedad',
    'before' => 'basicAuth2|hasPermissions2:consultas-enfermedad',
    'uses' => 'ConsultasController@getEnfermedad')
);
Route::post('/consulta/enfermedad', array(
    'as' => 'consulta.enfermedad',
    'before' => 'basicAuth2|hasPermissions2:consultas-enfermedad',
    'uses' => 'ConsultasController@postEnfermedad')
);
Route::get('/consulta/aspectosAmbientale', array(
    'as' => 'consulta.aspectosAmbientale',
    'before' => 'basicAuth2|hasPermissions2:consultas-aspectosAmbientale',
    'uses' => 'ConsultasController@getAspectosAmbientales')
);
Route::post('/consulta/aspectosAmbientale', array(
    'as' => 'consulta.aspectosAmbientale',
    'before' => 'basicAuth2|hasPermissions2:consultas-aspectosAmbientale',
    'uses' => 'ConsultasController@postAspectosAmbientales')
);
Route::get('/consulta/manto', array(
    'as' => 'consulta.manto',
    'before' => 'basicAuth2|hasPermissions2:consultas-manto',
    'uses' => 'ConsultasController@getManto')
);
Route::post('/consulta/manto', array(
    'as' => 'consulta.manto',
    'before' => 'basicAuth2|hasPermissions2:consultas-manto',
    'uses' => 'ConsultasController@postManto')
);

/*Sin administrador*/
Route::resource('p_ambiental_correos', 'P_ambiental_correosController');

Route::resource('p_correo_bitacoras', 'P_correo_bitacorasController');
/*-------------------------------------------------------------------*/
/*------------------------Parametros para correos de bitacoras-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/p_correo_bitacora/index', array(
    'as' => 'p_correo_bitacora.index',
    'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-index',
    'uses' => 'P_correo_bitacorasController@index')
);
Route::post('/p_correo_bitacora/contentListIndex', array(
        'as' => 'p_correo_bitacora.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-contentListIndex',
        'uses' => 'P_correo_bitacorasController@contentListIndex')
    );
Route::get('/p_correo_bitacora/create', array(
        'as' => 'p_correo_bitacora.create',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-create',
        'uses' => 'P_correo_bitacorasController@create')
    );
Route::post('/p_correo_bitacoras/store', array(
        'as' => 'p_correo_bitacora.store',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-store',
        'uses' => 'P_correo_bitacorasController@store')
    );
Route::get('/p_correo_bitacora/show/{id}', array(
        'as' => 'p_correo_bitacora.show',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-show',
        'uses' => 'P_correo_bitacorasController@show')
    );
Route::get('/p_correo_bitacora/edit/{id}', array(
        'as' => 'p_correo_bitacora.edit',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-edit',
        'uses' => 'P_correo_bitacorasController@edit')
    );
Route::post('/p_correo_bitacora/update/{id}', array(
        'as' => 'p_correo_bitacora.update',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-update',
        'uses' => 'P_correo_bitacorasController@update')
    );
Route::post('/p_correo_bitacora/destroy/{id}', array(
        'as' => 'p_correo_bitacora.destroy',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-destroy',
        'uses' => 'P_correo_bitacorasController@destroy')
    );
Route::post('/p_correo_bitacora/recover/{id}', array(
        'as' => 'p_correo_bitacora.recover',
        'before' => 'basicAuth2|hasPermissions2:p_correo_bitacoras-recover',
        'uses' => 'P_correo_bitacorasController@recover')
    );
/*Sin administrador*/
Route::resource('bitacoras', 'BitacorasController');
/*-------------------------------------------------------------------*/
/*------------------------Tipo de bitacora de Ambiental-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_tpo_bitacora/index', array(
    'as' => 'ca_tpo_bitacora.index',
    'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-index',
    'uses' => 'Ca_tpo_bitacorasController@index')
);
Route::post('/ca_tpo_bitacora/contentListIndex', array(
        'as' => 'ca_tpo_bitacora.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-contentListIndex',
        'uses' => 'Ca_tpo_bitacorasController@contentListIndex')
    );
Route::get('/ca_tpo_bitacora/create', array(
        'as' => 'ca_tpo_bitacora.create',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-create',
        'uses' => 'Ca_tpo_bitacorasController@create')
    );
Route::post('/ca_tpo_bitacoras/store', array(
        'as' => 'ca_tpo_bitacora.store',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-store',
        'uses' => 'Ca_tpo_bitacorasController@store')
    );
Route::get('/ca_tpo_bitacora/show/{id}', array(
        'as' => 'ca_tpo_bitacora.show',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-show',
        'uses' => 'Ca_tpo_bitacorasController@show')
    );
Route::get('/ca_tpo_bitacora/edit/{id}', array(
        'as' => 'ca_tpo_bitacora.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-edit',
        'uses' => 'Ca_tpo_bitacorasController@edit')
    );
Route::post('/ca_tpo_bitacora/update/{id}', array(
        'as' => 'ca_tpo_bitacora.update',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-update',
        'uses' => 'Ca_tpo_bitacorasController@update')
    );
Route::post('/ca_tpo_bitacora/destroy/{id}', array(
        'as' => 'ca_tpo_bitacora.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-destroy',
        'uses' => 'Ca_tpo_bitacorasController@destroy')
    );
Route::post('/ca_tpo_bitacora/recover/{id}', array(
        'as' => 'ca_tpo_bitacora.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_bitacoras-recover',
        'uses' => 'Ca_tpo_bitacorasController@recover')
    );
/*----------------------------Seguridad--------------------------------*/
/*----------------------------Acciones por Accidente-------------------*/
/*---------------------------------------------------------------------*/
Route::get('/ca_tpo_noconformidade/index', array(
    'as' => 'ca_tpo_noconformidade.index',
    'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-index',
    'uses' => 'Ca_tpo_noconformidadesController@index')
);
Route::post('/ca_tpo_noconformidade/contentListIndex', array(
        'as' => 'ca_tpo_noconformidade.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-contentListIndex',
        'uses' => 'Ca_tpo_noconformidadesController@contentListIndex')
    );
Route::get('/ca_tpo_noconformidade/create', array(
        'as' => 'ca_tpo_noconformidade.create',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-create',
        'uses' => 'Ca_tpo_noconformidadesController@create')
    );
Route::post('/ca_tpo_noconformidades/store', array(
        'as' => 'ca_tpo_noconformidade.store',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-store',
        'uses' => 'Ca_tpo_noconformidadesController@store')
    );
Route::get('/ca_tpo_noconformidade/show/{id}', array(
        'as' => 'ca_tpo_noconformidade.show',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-show',
        'uses' => 'Ca_tpo_noconformidadesController@show')
    );
Route::get('/ca_tpo_noconformidade/edit/{id}', array(
        'as' => 'ca_tpo_noconformidade.edit',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-edit',
        'uses' => 'Ca_tpo_noconformidadesController@edit')
    );
Route::put('/ca_tpo_noconformidade/update/{id}', array(
        'as' => 'ca_tpo_noconformidade.update',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-update',
        'uses' => 'Ca_tpo_noconformidadesController@update')
    );
Route::post('/ca_tpo_noconformidade/destroy/{id}', array(
        'as' => 'ca_tpo_noconformidade.destroy',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-destroy',
        'uses' => 'Ca_tpo_noconformidadesController@destroy')
    );
Route::post('/ca_tpo_noconformidade/recover/{id}', array(
        'as' => 'ca_tpo_noconformidade.recover',
        'before' => 'basicAuth2|hasPermissions2:ca_tpo_noconformidades-recover',
        'uses' => 'Ca_tpo_noconformidadesController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Procesos de Aspectos Ambientales-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/aa_proceso/index', array(
    'as' => 'aa_proceso.index',
    'before' => 'basicAuth2|hasPermissions2:aa_procesos-index',
    'uses' => 'Aa_procesosController@index')
);
Route::post('/aa_proceso/contentListIndex', array(
        'as' => 'aa_proceso.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-contentListIndex',
        'uses' => 'Aa_procesosController@contentListIndex')
    );
Route::get('/aa_proceso/create', array(
        'as' => 'aa_proceso.create',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-create',
        'uses' => 'Aa_procesosController@create')
    );
Route::post('/aa_procesos/store', array(
        'as' => 'aa_proceso.store',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-store',
        'uses' => 'Aa_procesosController@store')
    );
Route::get('/aa_proceso/show/{id}', array(
        'as' => 'aa_proceso.show',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-show',
        'uses' => 'Aa_procesosController@show')
    );
Route::get('/aa_proceso/edit/{id}', array(
        'as' => 'aa_proceso.edit',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-edit',
        'uses' => 'Aa_procesosController@edit')
    );
Route::put('/aa_proceso/update/{id}', array(
        'as' => 'aa_proceso.update',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-update',
        'uses' => 'Aa_procesosController@update')
    );
Route::post('/aa_proceso/destroy/{id}', array(
        'as' => 'aa_proceso.destroy',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-destroy',
        'uses' => 'Aa_procesosController@destroy')
    );
Route::post('/aa_proceso/recover/{id}', array(
        'as' => 'aa_proceso.recover',
        'before' => 'basicAuth2|hasPermissions2:aa_procesos-recover',
        'uses' => 'Aa_procesosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Aspectos de Aspectos Ambientales-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/aa_aspecto/index', array(
    'as' => 'aa_aspecto.index',
    'before' => 'basicAuth2|hasPermissions2:aa_aspectos-index',
    'uses' => 'Aa_aspectosController@index')
);
Route::post('/aa_aspecto/contentListIndex', array(
        'as' => 'aa_aspecto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-contentListIndex',
        'uses' => 'Aa_aspectosController@contentListIndex')
    );
Route::get('/aa_aspecto/create', array(
        'as' => 'aa_aspecto.create',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-create',
        'uses' => 'Aa_aspectosController@create')
    );
Route::post('/aa_aspectos/store', array(
        'as' => 'aa_aspecto.store',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-store',
        'uses' => 'Aa_aspectosController@store')
    );
Route::get('/aa_aspecto/show/{id}', array(
        'as' => 'aa_aspecto.show',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-show',
        'uses' => 'Aa_aspectosController@show')
    );
Route::get('/aa_aspecto/edit/{id}', array(
        'as' => 'aa_aspecto.edit',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-edit',
        'uses' => 'Aa_aspectosController@edit')
    );
Route::put('/aa_aspecto/update/{id}', array(
        'as' => 'aa_aspecto.update',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-update',
        'uses' => 'Aa_aspectosController@update')
    );
Route::post('/aa_aspecto/destroy/{id}', array(
        'as' => 'aa_aspecto.destroy',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-destroy',
        'uses' => 'Aa_aspectosController@destroy')
    );
Route::post('/aa_aspecto/recover/{id}', array(
        'as' => 'aa_aspecto.recover',
        'before' => 'basicAuth2|hasPermissions2:aa_aspectos-recover',
        'uses' => 'Aa_aspectosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Impactos de Aspectos Ambientales-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/aa_impacto/index', array(
    'as' => 'aa_impacto.index',
    'before' => 'basicAuth2|hasPermissions2:aa_impactos-index',
    'uses' => 'Aa_impactosController@index')
);
Route::post('/aa_impacto/contentListIndex', array(
        'as' => 'aa_impacto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-contentListIndex',
        'uses' => 'Aa_impactosController@contentListIndex')
    );
Route::get('/aa_impacto/create', array(
        'as' => 'aa_impacto.create',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-create',
        'uses' => 'Aa_impactosController@create')
    );
Route::post('/aa_impactos/store', array(
        'as' => 'aa_impacto.store',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-store',
        'uses' => 'Aa_impactosController@store')
    );
Route::get('/aa_impacto/show/{id}', array(
        'as' => 'aa_impacto.show',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-show',
        'uses' => 'Aa_impactosController@show')
    );
Route::get('/aa_impacto/edit/{id}', array(
        'as' => 'aa_impacto.edit',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-edit',
        'uses' => 'Aa_impactosController@edit')
    );
Route::put('/aa_impacto/update/{id}', array(
        'as' => 'aa_impacto.update',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-update',
        'uses' => 'Aa_impactosController@update')
    );
Route::post('/aa_impacto/destroy/{id}', array(
        'as' => 'aa_impacto.destroy',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-destroy',
        'uses' => 'Aa_impactosController@destroy')
    );
Route::post('/aa_impacto/recover/{id}', array(
        'as' => 'aa_impacto.recover',
        'before' => 'basicAuth2|hasPermissions2:aa_impactos-recover',
        'uses' => 'Aa_impactosController@recover')
    );

/*---------------------------------------------------------------------*/
/*-------------------Aspectos Ambientales-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/aspectos_ambientale/index', array(
    'as' => 'aspectos_ambientale.index',
    'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-index',
    'uses' => 'Aspectos_ambientalesController@index')
);
Route::post('/aspectos_ambientale/contentListIndex', array(
        'as' => 'aspectos_ambientale.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-contentListIndex',
        'uses' => 'Aspectos_ambientalesController@contentListIndex')
    );
Route::get('/aspectos_ambientale/create', array(
        'as' => 'aspectos_ambientale.create',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-create',
        'uses' => 'Aspectos_ambientalesController@create')
    );
Route::post('/aspectos_ambientales/store', array(
        'as' => 'aspectos_ambientale.store',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-store',
        'uses' => 'Aspectos_ambientalesController@store')
    );
Route::get('/aspectos_ambientale/show/{id}', array(
        'as' => 'aspectos_ambientale.show',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-show',
        'uses' => 'Aspectos_ambientalesController@show')
    );
Route::get('/aspectos_ambientale/edit/{id}', array(
        'as' => 'aspectos_ambientale.edit',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-edit',
        'uses' => 'Aspectos_ambientalesController@edit')
    );
Route::put('/aspectos_ambientale/update/{id}', array(
        'as' => 'aspectos_ambientale.update',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-update',
        'uses' => 'Aspectos_ambientalesController@update')
    );
Route::post('/aspectos_ambientale/destroy/{id}', array(
        'as' => 'aspectos_ambientale.destroy',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-destroy',
        'uses' => 'Aspectos_ambientalesController@destroy')
    );
Route::post('/aspectos_ambientale/recover/{id}', array(
        'as' => 'aspectos_ambientale.recover',
        'before' => 'basicAuth2|hasPermissions2:aspectos_ambientales-recover',
        'uses' => 'Aspectos_ambientalesController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Tipo de documenntos de la revision-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/tpo_doc/index', array(
    'as' => 'tpo_doc.index',
    'before' => 'basicAuth2|hasPermissions2:tpo_docs-index',
    'uses' => 'Tpo_docsController@index')
);
Route::post('/tpo_doc/contentListIndex', array(
        'as' => 'tpo_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-contentListIndex',
        'uses' => 'Tpo_docsController@contentListIndex')
    );
Route::get('/tpo_doc/create', array(
        'as' => 'tpo_doc.create',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-create',
        'uses' => 'Tpo_docsController@create')
    );
Route::post('/tpo_docs/store', array(
        'as' => 'tpo_doc.store',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-store',
        'uses' => 'Tpo_docsController@store')
    );
Route::get('/tpo_doc/show/{id}', array(
        'as' => 'tpo_doc.show',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-show',
        'uses' => 'Tpo_docsController@show')
    );
Route::get('/tpo_doc/edit/{id}', array(
        'as' => 'tpo_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-edit',
        'uses' => 'Tpo_docsController@edit')
    );
Route::put('/tpo_doc/update/{id}', array(
        'as' => 'tpo_doc.update',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-update',
        'uses' => 'Tpo_docsController@update')
    );
Route::post('/tpo_doc/destroy/{id}', array(
        'as' => 'tpo_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-destroy',
        'uses' => 'Tpo_docsController@destroy')
    );
Route::post('/tpo_doc/recover/{id}', array(
        'as' => 'tpo_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:tpo_docs-recover',
        'uses' => 'Tpo_docsController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Revision de condiciones fiscas-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/rev_requisito/index', array(
    'as' => 'rev_requisito.index',
    'before' => 'basicAuth2|hasPermissions2:rev_requisitos-index',
    'uses' => 'Rev_requisitosController@index')
);
Route::post('/rev_requisito/contentListIndex', array(
        'as' => 'rev_requisito.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-contentListIndex',
        'uses' => 'Rev_requisitosController@contentListIndex')
    );
Route::get('/rev_requisito/create', array(
        'as' => 'rev_requisito.create',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-create',
        'uses' => 'Rev_requisitosController@create')
    );
Route::post('/rev_requisitos/store', array(
        'as' => 'rev_requisito.store',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-store',
        'uses' => 'Rev_requisitosController@store')
    );
Route::get('/rev_requisito/show/{id}', array(
        'as' => 'rev_requisito.show',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-show',
        'uses' => 'Rev_requisitosController@show')
    );
Route::get('/rev_requisito/edit/{id}', array(
        'as' => 'rev_requisito.edit',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-edit',
        'uses' => 'Rev_requisitosController@edit')
    );
Route::put('/rev_requisito/update/{id}', array(
        'as' => 'rev_requisito.update',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-update',
        'uses' => 'Rev_requisitosController@update')
    );
Route::post('/rev_requisito/destroy/{id}', array(
        'as' => 'rev_requisito.destroy',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-destroy',
        'uses' => 'Rev_requisitosController@destroy')
    );
Route::post('/rev_requisito/recover/{id}', array(
        'as' => 'rev_requisito.recover',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-recover',
        'uses' => 'Rev_requisitosController@recover')
    );
Route::get('/rev_requisito/lineas/{id}', array(
    'as' => 'rev_requisito.lineas',
    'before' => 'basicAuth2|hasPermissions2:rev_requisitos-lineas',
    'uses' => 'Rev_requisitosController@lineas')
);
Route::get('/rev_requisito/rptLista/{id}', array(
        'as' => 'check.rptLista',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos-imprimir',
        'uses' => 'Rev_requisitosController@imprimirLista')
    );
/*---------------------------------------------------------------------*/
/*-------------------Lineas de revison de condiciones-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/rev_requisitos_ln/index', array(
    'as' => 'rev_requisitos_ln.index',
    'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-index',
    'uses' => 'Rev_requisitos_lnsController@index')
);
Route::post('/rev_requisitos_ln/contentListIndex', array(
        'as' => 'rev_requisitos_ln.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-contentListIndex',
        'uses' => 'Rev_requisitos_lnsController@contentListIndex')
    );
Route::get('/rev_requisitos_ln/create/{id}', array(
        'as' => 'rev_requisitos_ln.create',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-create',
        'uses' => 'Rev_requisitos_lnsController@create')
    );
Route::post('/rev_requisitos_ln/store/{rev}', array(
        'as' => 'rev_requisitos_ln.store',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-store',
        'uses' => 'Rev_requisitos_lnsController@store')
    );
Route::get('/rev_requisitos_ln/show/{id}', array(
        'as' => 'rev_requisitos_ln.show',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-show',
        'uses' => 'Rev_requisitos_lnsController@show')
    );
Route::get('/rev_requisitos_ln/edit/{id}', array(
        'as' => 'rev_requisitos_ln.edit',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-edit',
        'uses' => 'Rev_requisitos_lnsController@edit')
    );
Route::post('/rev_requisitos_ln/update/{id}', array(
        'as' => 'rev_requisitos_ln.update',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-update',
        'uses' => 'Rev_requisitos_lnsController@update')
    );
Route::post('/rev_requisitos_ln/destroy/{id}', array(
        'as' => 'rev_requisitos_ln.destroy',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-destroy',
        'uses' => 'Rev_requisitos_lnsController@destroy')
    );
Route::post('/rev_requisitos_ln/recover/{id}', array(
        'as' => 'rev_requisitos_ln.recover',
        'before' => 'basicAuth2|hasPermissions2:rev_requisitos_lns-recover',
        'uses' => 'Rev_requisitos_lnsController@recover')
    );
Route::post('/rev_requisitos_ln/cmbDoc', array(
        'as' => 'rev_requisitos_ln.cmbDoc',
        'before' => 'basicAuth2',
        'uses' => 'Rev_requisitos_lnsController@cmbDoc')
    );
/*---------------------------------------------------------------------*/
/*-------------------Revision Documental-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/rev_documental/index', array(
    'as' => 'rev_documental.index',
    'before' => 'basicAuth2|hasPermissions2:rev_documentals-index',
    'uses' => 'Rev_documentalsController@index')
);
Route::post('/rev_documental/contentListIndex', array(
        'as' => 'rev_documental.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-contentListIndex',
        'uses' => 'Rev_documentalsController@contentListIndex')
    );
Route::get('/rev_documental/create', array(
        'as' => 'rev_documental.create',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-create',
        'uses' => 'Rev_documentalsController@create')
    );
Route::post('/rev_documentals/store', array(
        'as' => 'rev_documental.store',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-store',
        'uses' => 'Rev_documentalsController@store')
    );
Route::get('/rev_documental/show/{id}', array(
        'as' => 'rev_documental.show',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-show',
        'uses' => 'Rev_documentalsController@show')
    );
Route::get('/rev_documental/edit/{id}', array(
        'as' => 'rev_documental.edit',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-edit',
        'uses' => 'Rev_documentalsController@edit')
    );
Route::put('/rev_documental/update/{id}', array(
        'as' => 'rev_documental.update',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-update',
        'uses' => 'Rev_documentalsController@update')
    );
Route::post('/rev_documental/destroy/{id}', array(
        'as' => 'rev_documental.destroy',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-destroy',
        'uses' => 'Rev_documentalsController@destroy')
    );
Route::post('/rev_documental/recover/{id}', array(
        'as' => 'rev_documental.recover',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-recover',
        'uses' => 'Rev_documentalsController@recover')
    );
Route::get('/rev_documental/lineas/{id}', array(
    'as' => 'rev_documental.lineas',
    'before' => 'basicAuth2|hasPermissions2:rev_documentals-lineas',
    'uses' => 'Rev_documentalsController@lineas')
);
Route::get('/rev_documental/rptLista/{id}', array(
        'as' => 'rev_documental.rptLista',
        'before' => 'basicAuth2|hasPermissions2:rev_documentals-imprimir',
        'uses' => 'Rev_documentalsController@imprimirLista')
    );
/*---------------------------------------------------------------------*/
/*-------------------Lineas de revison documental-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/rev_documentoal_ln/index', array(
    'as' => 'rev_documentoal_ln.index',
    'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-index',
    'uses' => 'Rev_documentoal_lnsController@index')
);
Route::post('/rev_documentoal_ln/contentListIndex', array(
        'as' => 'rev_documentoal_ln.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-contentListIndex',
        'uses' => 'Rev_documentoal_lnsController@contentListIndex')
    );
Route::get('/rev_documentoal_ln/create/{id}', array(
        'as' => 'rev_documentoal_ln.create',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-create',
        'uses' => 'Rev_documentoal_lnsController@create')
    );
Route::post('/rev_documentoal_ln/store/{rev}', array(
        'as' => 'rev_documentoal_ln.store',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-store',
        'uses' => 'Rev_documentoal_lnsController@store')
    );
Route::get('/rev_documentoal_ln/show/{id}', array(
        'as' => 'rev_documentoal_ln.show',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-show',
        'uses' => 'Rev_documentoal_lnsController@show')
    );
Route::get('/rev_documentoal_ln/edit/{id}', array(
        'as' => 'rev_documentoal_ln.edit',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-edit',
        'uses' => 'Rev_documentoal_lnsController@edit')
    );
Route::post('/rev_documentoal_ln/update/{id}', array(
        'as' => 'rev_documentoal_ln.update',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-update',
        'uses' => 'Rev_documentoal_lnsController@update')
    );
Route::post('/rev_documentoal_ln/destroy/{id}', array(
        'as' => 'rev_documentoal_ln.destroy',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-destroy',
        'uses' => 'Rev_documentoal_lnsController@destroy')
    );
Route::post('/rev_documentoal_ln/recover/{id}', array(
        'as' => 'rev_documentoal_ln.recover',
        'before' => 'basicAuth2|hasPermissions2:rev_documentoal_lns-recover',
        'uses' => 'Rev_documentoal_lnsController@recover')
    );
Route::post('/rev_documentoal_ln/cmbDoc', array(
        'as' => 'rev_documentoal_ln.cmbDoc',
        'before' => 'basicAuth2',
        'uses' => 'Rev_documentoal_lnsController@cmbDoc')
    );
Route::post('/rev_documentoal_ln/cmbNormas/{id}', array(
        'as' => 'rev_documentoal_ln.cmbNormas',
        'before' => 'basicAuth2',
        'uses' => 'Rev_documentoal_lnsController@cmbNormas')
    );
/*---------------------------------------------------------------------*/
/*-------------------Lineas de revison documental-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/condicione/index', array(
    'as' => 'condicione.index',
    'before' => 'basicAuth2|hasPermissions2:condiciones-index',
    'uses' => 'CondicionesController@index')
);
Route::post('/condicione/contentListIndex', array(
        'as' => 'condicione.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:condiciones-contentListIndex',
        'uses' => 'CondicionesController@contentListIndex')
    );
Route::get('/condicione/create/{id}', array(
        'as' => 'condicione.create',
        'before' => 'basicAuth2|hasPermissions2:condiciones-create',
        'uses' => 'CondicionesController@create')
    );
Route::post('/condicione/store/{rev}', array(
        'as' => 'condicione.store',
        'before' => 'basicAuth2|hasPermissions2:condiciones-store',
        'uses' => 'CondicionesController@store')
    );
Route::get('/condicione/show/{id}', array(
        'as' => 'condicione.show',
        'before' => 'basicAuth2|hasPermissions2:condiciones-show',
        'uses' => 'CondicionesController@show')
    );
Route::get('/condicione/edit/{id}', array(
        'as' => 'condicione.edit',
        'before' => 'basicAuth2|hasPermissions2:condiciones-edit',
        'uses' => 'CondicionesController@edit')
    );
Route::put('/condicione/update/{id}', array(
        'as' => 'condicione.update',
        'before' => 'basicAuth2|hasPermissions2:condiciones-update',
        'uses' => 'CondicionesController@update')
    );
Route::post('/condicione/destroy/{id}', array(
        'as' => 'condicione.destroy',
        'before' => 'basicAuth2|hasPermissions2:condiciones-destroy',
        'uses' => 'CondicionesController@destroy')
    );
Route::post('/condicione/recover/{id}', array(
        'as' => 'condicione.recover',
        'before' => 'basicAuth2|hasPermissions2:condiciones-recover',
        'uses' => 'CondicionesController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Lineas de revison documental-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/r_documento/index', array(
    'as' => 'r_documento.index',
    'before' => 'basicAuth2|hasPermissions2:r_documentos-index',
    'uses' => 'R_documentosController@index')
);
Route::post('/r_documento/contentListIndex', array(
        'as' => 'r_documento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-contentListIndex',
        'uses' => 'R_documentosController@contentListIndex')
    );
Route::get('/r_documento/create/{id}', array(
        'as' => 'r_documento.create',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-create',
        'uses' => 'R_documentosController@create')
    );
Route::post('/r_documento/store/{rev}', array(
        'as' => 'r_documento.store',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-store',
        'uses' => 'R_documentosController@store')
    );
Route::get('/r_documento/show/{id}', array(
        'as' => 'r_documento.show',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-show',
        'uses' => 'R_documentosController@show')
    );
Route::get('/r_documento/edit/{id}', array(
        'as' => 'r_documento.edit',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-edit',
        'uses' => 'R_documentosController@edit')
    );
Route::put('/r_documento/update/{id}', array(
        'as' => 'r_documento.update',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-update',
        'uses' => 'R_documentosController@update')
    );
Route::post('/r_documento/destroy/{id}', array(
        'as' => 'r_documento.destroy',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-destroy',
        'uses' => 'R_documentosController@destroy')
    );
Route::post('/r_documento/recover/{id}', array(
        'as' => 'r_documento.recover',
        'before' => 'basicAuth2|hasPermissions2:r_documentos-recover',
        'uses' => 'R_documentosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Objetivos de Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/m_objetivo/index', array(
    'as' => 'm_objetivo.index',
    'before' => 'basicAuth2|hasPermissions2:m_objetivos-index',
    'uses' => 'M_objetivosController@index')
);
Route::post('/m_objetivo/contentListIndex', array(
        'as' => 'm_objetivo.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-contentListIndex',
        'uses' => 'M_objetivosController@contentListIndex')
    );
Route::get('/m_objetivo/create/{id}', array(
        'as' => 'm_objetivo.create',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-create',
        'uses' => 'M_objetivosController@create')
    );
Route::post('/m_objetivo/store/{rev}', array(
        'as' => 'm_objetivo.store',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-store',
        'uses' => 'M_objetivosController@store')
    );
Route::get('/m_objetivo/show/{id}', array(
        'as' => 'm_objetivo.show',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-show',
        'uses' => 'M_objetivosController@show')
    );
Route::get('/m_objetivo/edit/{id}', array(
        'as' => 'm_objetivo.edit',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-edit',
        'uses' => 'M_objetivosController@edit')
    );
Route::put('/m_objetivo/update/{id}', array(
        'as' => 'm_objetivo.update',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-update',
        'uses' => 'M_objetivosController@update')
    );
Route::post('/m_objetivo/destroy/{id}', array(
        'as' => 'm_objetivo.destroy',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-destroy',
        'uses' => 'M_objetivosController@destroy')
    );
Route::post('/m_objetivo/recover/{id}', array(
        'as' => 'm_objetivo.recover',
        'before' => 'basicAuth2|hasPermissions2:m_objetivos-recover',
        'uses' => 'M_objetivosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Clases de Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/m_clase_manto/index', array(
    'as' => 'm_clase_manto.index',
    'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-index',
    'uses' => 'M_clase_mantosController@index')
);
Route::post('/m_clase_manto/contentListIndex', array(
        'as' => 'm_clase_manto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-contentListIndex',
        'uses' => 'M_clase_mantosController@contentListIndex')
    );
Route::get('/m_clase_manto/create/{id}', array(
        'as' => 'm_clase_manto.create',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-create',
        'uses' => 'M_clase_mantosController@create')
    );
Route::post('/m_clase_manto/store/{rev}', array(
        'as' => 'm_clase_manto.store',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-store',
        'uses' => 'M_clase_mantosController@store')
    );
Route::get('/m_clase_manto/show/{id}', array(
        'as' => 'm_clase_manto.show',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-show',
        'uses' => 'M_clase_mantosController@show')
    );
Route::get('/m_clase_manto/edit/{id}', array(
        'as' => 'm_clase_manto.edit',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-edit',
        'uses' => 'M_clase_mantosController@edit')
    );
Route::put('/m_clase_manto/update/{id}', array(
        'as' => 'm_clase_manto.update',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-update',
        'uses' => 'M_clase_mantosController@update')
    );
Route::post('/m_clase_manto/destroy/{id}', array(
        'as' => 'm_clase_manto.destroy',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-destroy',
        'uses' => 'M_clase_mantosController@destroy')
    );
Route::post('/m_clase_manto/recover/{id}', array(
        'as' => 'm_clase_manto.recover',
        'before' => 'basicAuth2|hasPermissions2:m_clase_mantos-recover',
        'uses' => 'M_clase_mantosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Tipos de Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/m_tpo_manto/index', array(
    'as' => 'm_tpo_manto.index',
    'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-index',
    'uses' => 'M_tpo_mantosController@index')
);
Route::post('/m_tpo_manto/contentListIndex', array(
        'as' => 'm_tpo_manto.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-contentListIndex',
        'uses' => 'M_tpo_mantosController@contentListIndex')
    );
Route::get('/m_tpo_manto/create/{id}', array(
        'as' => 'm_tpo_manto.create',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-create',
        'uses' => 'M_tpo_mantosController@create')
    );
Route::post('/m_tpo_manto/store/{rev}', array(
        'as' => 'm_tpo_manto.store',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-store',
        'uses' => 'M_tpo_mantosController@store')
    );
Route::get('/m_tpo_manto/show/{id}', array(
        'as' => 'm_tpo_manto.show',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-show',
        'uses' => 'M_tpo_mantosController@show')
    );
Route::get('/m_tpo_manto/edit/{id}', array(
        'as' => 'm_tpo_manto.edit',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-edit',
        'uses' => 'M_tpo_mantosController@edit')
    );
Route::put('/m_tpo_manto/update/{id}', array(
        'as' => 'm_tpo_manto.update',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-update',
        'uses' => 'M_tpo_mantosController@update')
    );
Route::post('/m_tpo_manto/destroy/{id}', array(
        'as' => 'm_tpo_manto.destroy',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-destroy',
        'uses' => 'M_tpo_mantosController@destroy')
    );
Route::post('/m_tpo_manto/recover/{id}', array(
        'as' => 'm_tpo_manto.recover',
        'before' => 'basicAuth2|hasPermissions2:m_tpo_mantos-recover',
        'uses' => 'M_tpo_mantosController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/m_mantenimiento/index', array(
    'as' => 'm_mantenimiento.index',
    'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-index',
    'uses' => 'M_mantenimientosController@index')
);
Route::post('/m_mantenimiento/contentListIndex', array(
        'as' => 'm_mantenimiento.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-contentListIndex',
        'uses' => 'M_mantenimientosController@contentListIndex')
    );
Route::get('/m_mantenimiento/create/{id}', array(
        'as' => 'm_mantenimiento.create',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-create',
        'uses' => 'M_mantenimientosController@create')
    );
Route::post('/m_mantenimiento/store/{rev}', array(
        'as' => 'm_mantenimiento.store',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-store',
        'uses' => 'M_mantenimientosController@store')
    );
Route::get('/m_mantenimiento/show/{id}', array(
        'as' => 'm_mantenimiento.show',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-show',
        'uses' => 'M_mantenimientosController@show')
    );
Route::get('/m_mantenimiento/edit/{id}', array(
        'as' => 'm_mantenimiento.edit',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-edit',
        'uses' => 'M_mantenimientosController@edit')
    );
Route::put('/m_mantenimiento/update/{id}', array(
        'as' => 'm_mantenimiento.update',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-update',
        'uses' => 'M_mantenimientosController@update')
    );
Route::post('/m_mantenimiento/destroy/{id}', array(
        'as' => 'm_mantenimiento.destroy',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-destroy',
        'uses' => 'M_mantenimientosController@destroy')
    );
Route::post('/m_mantenimiento/recover/{id}', array(
        'as' => 'm_mantenimiento.recover',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimientos-recover',
        'uses' => 'M_mantenimientosController@recover')
    );
Route::get('/m_mantenimiento/conSubequipo', array(
        'as' => 'm_mantenimiento.conSubequipo',
        'before' => 'basicAuth2',
        'uses' => 'M_mantenimientosController@conSubequipo')
    );
Route::get('/m_mantenimiento/conEquipo', array(
        'as' => 'm_mantenimiento.conEquipo',
        'before' => 'basicAuth2',
        'uses' => 'M_mantenimientosController@conEquipo')
    );
Route::get('/m_mantenimiento/rptFormato/{id}', array(
        'as' => 'm_mantenimiento-formato.rptFormato',
        'before' => 'basicAuth2|hasPermissions2:m_mantenimiento-formato',
        'uses' => 'M_mantenimientosController@rptFormato')
    );
/*---------------------------------------------------------------------*/
/*-------------------Subequipos de Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/subequipo/index', array(
    'as' => 'subequipo.index',
    'before' => 'basicAuth2|hasPermissions2:subequipos-index',
    'uses' => 'SubequiposController@index')
);
Route::post('/subequipo/contentListIndex', array(
        'as' => 'subequipo.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:subequipos-contentListIndex',
        'uses' => 'SubequiposController@contentListIndex')
    );
Route::get('/subequipo/create/{id}', array(
        'as' => 'subequipo.create',
        'before' => 'basicAuth2|hasPermissions2:subequipos-create',
        'uses' => 'SubequiposController@create')
    );
Route::post('/subequipo/store/{rev}', array(
        'as' => 'subequipo.store',
        'before' => 'basicAuth2|hasPermissions2:subequipos-store',
        'uses' => 'SubequiposController@store')
    );
Route::get('/subequipo/show/{id}', array(
        'as' => 'subequipo.show',
        'before' => 'basicAuth2|hasPermissions2:subequipos-show',
        'uses' => 'SubequiposController@show')
    );
Route::get('/subequipo/edit/{id}', array(
        'as' => 'subequipo.edit',
        'before' => 'basicAuth2|hasPermissions2:subequipos-edit',
        'uses' => 'SubequiposController@edit')
    );
Route::put('/subequipo/update/{id}', array(
        'as' => 'subequipo.update',
        'before' => 'basicAuth2|hasPermissions2:subequipos-update',
        'uses' => 'SubequiposController@update')
    );
Route::post('/subequipo/destroy/{id}', array(
        'as' => 'subequipo.destroy',
        'before' => 'basicAuth2|hasPermissions2:subequipos-destroy',
        'uses' => 'SubequiposController@destroy')
    );
Route::post('/subequipo/recover/{id}', array(
        'as' => 'subequipo.recover',
        'before' => 'basicAuth2|hasPermissions2:subequipos-recover',
        'uses' => 'SubequiposController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Documentos de Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/manto_doc/index', array(
    'as' => 'manto_doc.index',
    'before' => 'basicAuth2|hasPermissions2:manto_docs-index',
    'uses' => 'Manto_docsController@index')
);
Route::post('/manto_doc/contentListIndex', array(
        'as' => 'manto_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-contentListIndex',
        'uses' => 'Manto_docsController@contentListIndex')
    );
Route::get('/manto_doc/create/{id}', array(
        'as' => 'manto_doc.create',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-create',
        'uses' => 'Manto_docsController@create')
    );
Route::post('/manto_doc/store/{rev}', array(
        'as' => 'manto_doc.store',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-store',
        'uses' => 'Manto_docsController@store')
    );
Route::get('/manto_doc/show/{id}', array(
        'as' => 'manto_doc.show',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-show',
        'uses' => 'Manto_docsController@show')
    );
Route::get('/manto_doc/edit/{id}', array(
        'as' => 'manto_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-edit',
        'uses' => 'manto_docsController@edit')
    );
Route::put('/manto_doc/update/{id}', array(
        'as' => 'manto_doc.update',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-update',
        'uses' => 'Manto_docsController@update')
    );
Route::get('/manto_doc/destroy/{id}', array(
        'as' => 'manto_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-destroy',
        'uses' => 'Manto_docsController@destroy')
    );
Route::post('/manto_doc/recover/{id}', array(
        'as' => 'manto_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:manto_docs-recover',
        'uses' => 'Manto_docsController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Documentos de Bitacora de accidentes-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/bit_doc_accidente/index', array(
    'as' => 'bit_doc_accidente.index',
    'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-index',
    'uses' => 'Bit_doc_accidentesController@index')
);
Route::post('/bit_doc_accidente/contentListIndex', array(
        'as' => 'bit_doc_accidente.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-contentListIndex',
        'uses' => 'Bit_doc_accidentesController@contentListIndex')
    );
Route::get('/bit_doc_accidente/create/{id}', array(
        'as' => 'bit_doc_accidente.create',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-create',
        'uses' => 'Bit_doc_accidentesController@create')
    );
Route::post('/bit_doc_accidente/store/{rev}', array(
        'as' => 'bit_doc_accidente.store',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-store',
        'uses' => 'Bit_doc_accidentesController@store')
    );
Route::get('/bit_doc_accidente/show/{id}', array(
        'as' => 'bit_doc_accidente.show',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-show',
        'uses' => 'Bit_doc_accidentesController@show')
    );
Route::get('/bit_doc_accidente/edit/{id}', array(
        'as' => 'bit_doc_accidente.edit',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-edit',
        'uses' => 'Bit_doc_accidentesController@edit')
    );
Route::put('/bit_doc_accidente/update/{id}', array(
        'as' => 'bit_doc_accidente.update',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-update',
        'uses' => 'Bit_doc_accidentesController@update')
    );
Route::get('/bit_doc_accidente/destroy/{id}', array(
        'as' => 'bit_doc_accidente.destroy',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-destroy',
        'uses' => 'Bit_doc_accidentesController@destroy')
    );
Route::post('/bit_doc_accidente/recover/{id}', array(
        'as' => 'bit_doc_accidente.recover',
        'before' => 'basicAuth2|hasPermissions2:bit_doc_accidentes-recover',
        'uses' => 'Bit_doc_accidentesController@recover')
    );
/*---------------------------------------------------------------------*/
/*-------------------Documentos de Mantenimiento-------------------------*/
/*---------------------------------------------------------------------*/
Route::get('/a_rr_amb_doc/index', array(
    'as' => 'a_rr_amb_doc.index',
    'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-index',
    'uses' => 'A_rr_amb_docsController@index')
);
Route::post('/a_rr_amb_doc/contentListIndex', array(
        'as' => 'a_rr_amb_doc.contentListIndex',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-contentListIndex',
        'uses' => 'A_rr_amb_docsController@contentListIndex')
    );
Route::get('/a_rr_amb_doc/create/{id}', array(
        'as' => 'a_rr_amb_doc.create',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-create',
        'uses' => 'A_rr_amb_docsController@create')
    );
Route::post('/a_rr_amb_doc/store/{rev}', array(
        'as' => 'a_rr_amb_doc.store',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-store',
        'uses' => 'A_rr_amb_docsController@store')
    );
Route::get('/a_rr_amb_doc/show/{id}', array(
        'as' => 'a_rr_amb_doc.show',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-show',
        'uses' => 'A_rr_amb_docsController@show')
    );
Route::get('/a_rr_amb_doc/edit/{id}', array(
        'as' => 'a_rr_amb_doc.edit',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-edit',
        'uses' => 'A_rr_amb_docsController@edit')
    );
Route::put('/a_rr_amb_doc/update/{id}', array(
        'as' => 'a_rr_amb_doc.update',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-update',
        'uses' => 'a_rr_amb_docsController@update')
    );
Route::get('/a_rr_amb_doc/destroy/{id}', array(
        'as' => 'a_rr_amb_doc.destroy',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-destroy',
        'uses' => 'A_rr_amb_docsController@destroy')
    );
Route::post('/a_rr_amb_doc/recover/{id}', array(
        'as' => 'a_rr_amb_doc.recover',
        'before' => 'basicAuth2|hasPermissions2:a_rr_amb_docs-recover',
        'uses' => 'A_rr_amb_docsController@recover')
    );
	
	
Route::resource('efecto_sps', 'Efecto_spsController');

Route::resource('imp_reals', 'Imp_realsController');

Route::resource('imp_potencials', 'Imp_potencialsController');

Route::resource('m_imp_potencials', 'M_imp_potencialsController');

Route::resource('m_imp_reals', 'M_imp_realsController');

Route::resource('aa_emes', 'Aa_emesController');

Route::resource('aa_condiciones', 'Aa_condicionesController');

Route::resource('meses', 'MesesController');

Route::resource('estatus_condiciones', 'Estatus_condicionesController');

Route::resource('importancia', 'ImportanciaController');

Route::resource('estatus_requisitos', 'Estatus_requisitosController');

Route::resource('m_estatuses', 'M_estatusesController');





Route::resource('subequipos', 'SubequiposController');

Route::resource('m_tpo_riesgos', 'M_tpo_riesgosController');

Route::resource('tweets', 'TweetsController');

Route::resource('manto_docs', 'Manto_docsController');

Route::resource('bit_doc_accidentes', 'Bit_doc_accidentesController');

Route::resource('a_rr_amb_docs', 'A_rr_amb_docsController');