<?php

class Bitacora_seguridad extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'fecha' => 'required',
		'tpo_deteccion_id' => 'required',
		'tpo_inconformidad_id' => 'required',
		'inconformidad' => 'required',
		'solucion' => 'required',
		'area_id' => 'required',
		'tpo_bitacora_id' => 'required',
		'responsable_id' => 'required',
		'fec_planeada' => 'required',
		'fec_solucion' => 'required',
		'grupo_id' => 'required',
		'norma_id' => 'required',
		'norma' => 'required',
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
    public function area()
    {
        return $this->belongsTo('Area', 'area_id');
    }
    public function grupoNorma()
    {
        return $this->belongsTo('Cs_grupo_norma', 'grupo_id');
    }
    public function normas()
    {
        return $this->belongsTo('Cs_norma', 'norma_id');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function tpoBitacora()
    {
        return $this->belongsTo('Cs_tpo_bitacora', 'tpo_bitacora_id');
    }
    public function tpoInconformidad()
    {
        return $this->belongsTo('Cs_tpo_inconformidade', 'tpo_inconformidad_id');
    }
	public function tpoDeteccion()
    {
        return $this->belongsTo('Cs_tpo_deteccion', 'tpo_deteccion_id');
    }
    public function comentarios()
    {
        return $this->hasMany('Comentarios_b', 'bitacora_seguridad_id', 'id');
    }
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_seguridads.id', '=', $valor);
    	}
    }
    public function scopeTpoInconformidad($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_seguridads.tpo_inconformidad_id', '=', $valor);
    	}
    }
    public function scopeTpoDeteccion($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('bitacora_seguridads.tpo_deteccion_id', '=', $valor);
        }
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_seguridads.estatus_id', '=', $valor);
    	}
    }
    public function scopeArea($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_seguridads.area_id', '=', $valor);
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_seguridads.cia_id', '=', $valor);
    	}
    }
}
