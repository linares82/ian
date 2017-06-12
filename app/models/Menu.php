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

	public function dependeDe()
    {
        return $this->belongsTo('Menu', 'depende_de');
    }
	
	public function uAlta()
    {
        return $this->belongsTo('User', 'usu_alta_id');
    }
	
	public function uMod()
    {
        return $this->belongsTo('User', 'usu_mod_id');
    }
	
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
