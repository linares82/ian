<?php

class Cs_tpo_inconformidade extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'tpo_bitacora_id' => 'required',
		'tpo_inconformidad' => 'required'
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

    public function tpoBitacora()
    {
        return $this->belongsTo('Cs_tpo_bitacora', 'tpo_bitacora_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('Cs_tpo_inconformidades.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeTpoBitacora($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('Cs_tpo_inconformidades.tpo_bitacora_id', 'like', '%'.$valor.'%');
    	}
    }
}
