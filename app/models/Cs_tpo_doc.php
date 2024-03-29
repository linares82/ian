<?php

class Cs_tpo_doc extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'tpo_procedimiento_id' => 'required',
		'tpo_doc' => 'required',
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
    public function tpoProcedimiento()
    {
        return $this->belongsTo('Cs_tpo_procedimiento', 'tpo_procedimiento_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('cs_tpo_docs.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeTpoProcedimiento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('cs_tpo_docs.tpo_procedimiento_id', 'like', '%'.$valor.'%');
    	}
    }
	public function scopeCmbTipoDocumentos($query, $valor){
		$query->get();
		return $query->lists('tpo_doc', 'id');
	}
}
