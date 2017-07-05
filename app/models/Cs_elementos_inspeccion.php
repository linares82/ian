<?php

class Cs_elementos_inspeccion extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'grupo_norma_id' => 'required',
		'norma_id' => 'required',
		'elemento' => 'required',
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
    public function grupoNorma()
    {
        return $this->belongsTo('Cs_grupo_norma', 'grupo_norma_id');
    }
    public function normaVinculada()
    {
        return $this->belongsTo('Cs_norma', 'norma_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('cs_elementos_inspeccions.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeGrupoNorma($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('cs_elementos_inspeccions.id', 'like', '%'.$valor.'%');
    	}
    }
	public function scopeCmbElementos($query, $valor){
		$query->get();
		return $query->lists('elemento', 'id');
	}
}
