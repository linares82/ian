<?php

class Bitacora_planta extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'planta_id' => 'required',
		'fecha' => 'required',
		'turno_id' => 'required',
		'agua_entrada' => 'required',
		'agua_salida' => 'required',
		'q_usados' => 'required',
		'q_existentes' => 'required',
		'tiempo_operacion' => 'required',
		'motivo_paro' => 'required',
		'vol_lodos' => 'required',
		'disp_lodos' => 'required',
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
    public function planta()
    {
        return $this->belongsTo('Ca_planta', 'planta_id');
    }
    public function turno()
    {
        return $this->belongsTo('Turno', 'turno_id');
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
    		return $query->where('bitacora_plantas.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopePlanta($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_plantas.planta_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeTurno($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_plantas.turno_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('bitacora_plantas.cia_id', 'like', '%'.$valor.'%');
        }
    }
}
