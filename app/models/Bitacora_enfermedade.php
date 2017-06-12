<?php

class Bitacora_enfermedade extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'area_id' => 'required',
		'persona_id' => 'required',
		'enfermedad_id' => 'required',
		'descripcion' => 'required',
		'accion_id' => 'required',
		'costo_directo' => 'required',
		'costo_indirecto' => 'required',
		'fecha' => 'required',
		'turno_id' => 'required',
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
	public function area()
    {
        return $this->belongsTo('Area', 'area_id');
    }
    public function persona()
    {
        return $this->belongsTo('Empleado', 'persona_id');
    }
    public function accion()
    {
        return $this->belongsTo('Cs_accione', 'accion_id');
    }
    public function enfermedad()
    {
        return $this->belongsTo('Cs_enfermedade', 'enfermedad_id');
    }
    public function turno()
    {
        return $this->belongsTo('Turno', 'turno_id');
    }
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeArea($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.area_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopePersona($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.persona_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeEnfermedad($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.enfermedad_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeAccion($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.accion_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeTurno($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.turno_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_enfermedades.cia_id', 'like', '%'.$valor.'%');
    	}
    }
}
