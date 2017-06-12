<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/* Reglas de validacion */
	public static $rules_store = array(
		'username' => 'required',
		'email' => 'required',
		'password' => 'required',
		'multi_entidad' =>'required',
		'entidad_id'=>'min:1',
        'empleado_id'=>'not_in:0'
		
		//'usu_alta_id' => 'required',
		//'usu_mod_id' => 'required'
	);
	public static $rules_update = array(
		'username' => 'required',
		'email' => 'required',
		'multi_entidad' =>'required',
		'entidad_id' => 'min:1',
        'empleado_id'=>'not_in:0'
		//'usu_alta_id' => 'required',
		//'usu_mod_id' => 'required'
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo es obligatorio.',
        'min' => 'El campo no puede tener menos de :min carácteres.',
        'email' => 'El campo debe ser un email válido.',
        'max' => 'El campo no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'image'=>'El campo tiene un formato invalido, use una imagen',
        'not_in'=>'El campo es obligatorio.',
	);

	/* Relaciones */
	public function multiEntidad()
    {
        return $this->belongsTo('Bnd', 'multi_entidad');
    }

	public function Entidad()
    {
        return $this->belongsTo('Entidad', 'entidad_id');
    }
	
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('permissions.id', 'like', '%'.$id.'%');
    	}
    }
	public function scopeUsername($query, $username)
    {
    	if ($username=='0'){
    		return $query;
    	}else{
    		return $query->where('users.username', 'like', '%'.$username.'%');
    	}
    }
    public function scopeEmail($query, $email)
    {
    	if ($email=='0'){
    		return $query;
    	}else{
    		return $query->where('users.email', 'like', '%'.$email.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor=='0'){
    		return $query;
    	}else{
    		return $query->where('users.cia_id', 'like', '%'.$valor.'%');
    	}
    }

    public function getCia(){
    	return $this->entidad_id;  
        /*if ($this->multi_entidad==0){
    		return $this->entidad_id;	
    	}else{
    		return 0;
    	}*/
    }
	
}
