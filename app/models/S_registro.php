<?php

class S_registro extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'grupo_id' => 'required',
		'norma_id' => 'required',
		'elemento_id' => 'required',
		'detalle' => 'required',
		'fec_registro' => 'required'
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
    public function grupo()
    {
        return $this->belongsTo('Cs_grupo_norma', 'grupo_id');
    }
    public function norma()
    {
        return $this->belongsTo('Cs_norma', 'norma_id');
    }
    public function elemento()
    {
        return $this->belongsTo('Cs_elementos_inspeccion', 'elemento_id');
    }
    public function comentarios()
    {
        return $this->hasMany('S_comentarios_registro', 's_registros_id', 'id');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_registros.id', '=', $valor);
    	}
    }
    public function scopeGrupo($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_registros.grupo_id', '=', $valor);
    	}
    }
    public function scopeNorma($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_registros.norma_id', '=', $valor);
    	}
    }
    public function scopeElemento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_registros.elemento_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_registros.estatus_id', '=', $valor);
    	}
    }
    public function scopeResponsable($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('s_registros.responsable_id', '=', $valor);
        }
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_registros.cia_id', '=', $valor);
    	}
    }
}
