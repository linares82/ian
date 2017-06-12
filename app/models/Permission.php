<?php

class Permission extends Eloquent {
	 protected $table = 'permissions';

	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules_store = array(
		'name' => 'required',
		'value' => 'required',
		'description' => 'required',
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
        'image'=>'El campo tiene un formato invalido, use una imagen'
	);
	
	/* Relaciones */
	
	
	/* Scopes */
	public function scopeName($query, $name)
    {
    	if ($name=='0'){
    		return $query;
    	}else{
    		return $query->where('permissions.name', 'like', '%'.$name.'%');
    	}
    }
    public function scopeValue($query, $value)
    {
    	if ($value=='0'){
    		return $query;
    	}else{
    		return $query->where('permissions.value', 'like', '%'.$value.'%');
    	}
    }
    public function scopeId($query, $id)
    {
    	if ($id=='0'){
    		return $query;
    	}else{
    		return $query->where('permissions.id', 'like', '%'.$id.'%');
    	}
    }
}
