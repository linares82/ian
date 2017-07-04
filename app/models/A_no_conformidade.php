<?php

class A_no_conformidade extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'no_conformidad' => 'required',
		'mes' => 'required',
		'area_id' => 'required',
		'tpo_deteccion_id' => 'required',
		'tpo_bitacora_id' => 'required',
		'tpo_inconformidad_id' => 'required',
		'solucion' => 'required',
		'responsable_id' => 'required',
		'fec_planeada' => 'required',
		'fec_solucion' => 'required',
		'costo' => 'required',
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
        return $this->belongsTo('Area', 'usu_mod_id');
    }
    public function tpoDeteccion()
    {
        return $this->belongsTo('Cs_tpo_deteccion', 'tpo_deteccion_id');
    }
    public function tpoBitacora()
    {
        return $this->belongsTo('Ca_tpo_bitacora', 'tpo_bitacora_id');
    }
    public function tpoInconformidad()
    {
        return $this->belongsTo('Ca_tpo_noconformidade', 'tpo_inconformidad_id');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function comentarios()
    {
        return $this->hasMany('A_comentarios_nc', 'no_conformidad_id', 'id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_no_conformidades.id', '=', $valor);
    	}
    }
    public function scopeFecha($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_no_conformidades.fecha', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeArea($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_no_conformidades.area_id', '=', $valor);
    	}
    }
    public function scopeTpoDeteccion($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_no_conformidades.tpo_deteccion_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('a_no_conformidades.estatus_id', '=', $valor);
        }
    }
    public function scopeCia($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('a_no_conformidades.cia_id', '=', $valor);
        }
    }
}
