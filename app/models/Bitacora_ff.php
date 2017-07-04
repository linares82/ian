<?php

class Bitacora_ff extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'ca_fuente_fija_id' => 'required',
		'fecha' => 'required',
		'turno_id' => 'required',
		'consumo' => 'required',
		'capacidad_diseno' => 'required',
		'tp_gases' => 'required',
		'tp_chimenea' => 'required',
		'fec_ult_manto' => 'required',
		'desc_manto' => 'required',
		'responsable_id' => 'required',
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

	public function responsableFf()
    {
        return $this->belongsTo('Empleado', 'responsable_id', 'id');
    }
	public function fuenteFija()
    {
        return $this->belongsTo('Ca_fuentes_fija', 'ca_fuente_fija_id');
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
    		return $query->where('bitacora_ffs.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeFf($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_ffs.ca_fuente_fija_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeTurno($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_ffs.turno_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_ffs.cia_id', 'like', '%'.$valor.'%');
    	}
    }
}
