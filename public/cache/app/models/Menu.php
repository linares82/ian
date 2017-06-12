<?php

class Menu extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	public static $rules = array(
		'item' => 'required',
		'orden' => 'required',
		'depende_de' => 'required',
		'link' => 'required',
		'permiso_id' => 'required',
		'target' => 'required'
	);

	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos'
	);

	//Scopes
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('menus.id', 'like', '%'.$id.'%');
    	}
    }
}
