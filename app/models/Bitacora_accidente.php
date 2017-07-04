<?php

class Bitacora_accidente extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'area_id' => 'required',
		'responsable_id' => 'required',
		'persona_id' => 'required',
		'accidente_id' => 'required',
		'descripcion' => 'required',
		'procedimiento' => 'required',
		'accion_id' => 'required',
		'investigacion' => 'required',
		'costo_directo' => 'required',
		'costo_indirecto' => 'required',
		'fecha' => 'required',
		'turno_id' => 'required'
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
    public function cia()
    {
        return $this->belongsTo('Entidad', 'cia_id', 'id');
    }
    public function area()
    {
        return $this->belongsTo('Area', 'area_id');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function persona()
    {
        return $this->belongsTo('Empleado', 'persona_id');
    }
    public function accion()
    {
        return $this->belongsTo('Cs_accione', 'accion_id');
    }
    public function accidente()
    {
        return $this->belongsTo('Cs_accidente', 'accidente_id');
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
    		return $query->where('bitacora_accidentes.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeAccidente($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_accidentes.accidente_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeTurno($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_accidentes.turno_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_accidentes.cia_id', 'like', '%'.$valor.'%');
    	}
    }
}
