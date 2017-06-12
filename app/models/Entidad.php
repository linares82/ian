<?php

class Entidad extends Eloquent {
	 protected $table = 'entidades';

	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules_store = array(
		'rzon_social' => 'required',
		'responsable' => 'required',
		'dir1' => 'required',
		'dir2' => 'required',
		'rfc' => 'required',
		'abreviatura' => 'required',
		'tema' => 'required',
		'logo' => 'image|max:250|required'
		//'usu_alta_id' => 'required',
		//'usu_mod_id' => 'required'
	);
	public static $rules_update = array(
		'rzon_social' => 'required',
		'responsable' => 'required',
		'dir1' => 'required',
		'dir2' => 'required',
		'rfc' => 'required',
		'abreviatura' => 'required',
		'tema' => 'required',
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
	public function uAlta()
    {
        return $this->belongsTo('User', 'usu_alta_id');
    }
    
    public function uMod()
    {
        return $this->belongsTo('User', 'usu_mod_id');
    }
	
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('entidades.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeRazon($query, $razon)
    {
    	if ($razon=='0'){
    		return $query;
    	}else{
    		return $query->where('entidades.rzon_social', 'like', '%'.$razon.'%');
    	}
    }
    public function scopeResponsable($query, $responsable)
    {
    	if ($responsable=='0'){
    		return $query;
    	}else{
    		return $query->where('entidades.responsable', 'like', '%'.$responsable.'%');
    	}
    }
}
