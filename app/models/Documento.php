<?php

class Documento extends Eloquent {
	//public $archivo;
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'enc_impacto_id' => 'required',
		'doc_proyecto_id' => 'required',
		
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos'
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
    		return $query->where('documentos.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeEncImpactoId($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('documentos.id', 'like', '%'.$id.'%');
    	}
    }
}
