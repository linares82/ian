<?php

class Aspectos_ambientale extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'proceso_id' => 'not_in:0',
		'area_id' => 'not_in:0',
		'actividad' => 'not_in:0',
		'descripcion' => 'required',
		'aspecto_id' => 'required',
		'eme_id' => 'not_in:0',
		'condicion_id' => 'not_in:0',
		'impacto_id' => 'not_in:0',
		'al_federal_bnd' => 'not_in:0',
		'al_estatal_bnd' => 'not_in:0',
		'obj_corporativo_bnd' => 'not_in:0',
		'quejas_bnd' => 'not_in:0',
		'severidad_id' => 'not_in:0',
        'bnd_potencial' => 'not_in:0',
		'frecuencia_id' => 'not_in:0',
        'bnd_real' => 'not_in:0',
		'probabilidad_id' => 'not_in:0',
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
    public function proceso()
    {
        return $this->belongsTo('Aa_proceso', 'proceso_id');
    }
    public function area()
    {
        return $this->belongsTo('Area', 'area_id');
    }
    public function aspecto()
    {
        return $this->belongsTo('Aa_aspecto', 'aspecto_id');
    }
    public function eme()
    {
        return $this->belongsTo('Aa_eme', 'eme_id');
    }
    public function condicion()
    {
        return $this->belongsTo('Aa_condicione', 'condicion_id');
    }
    public function impacto()
    {
        return $this->belongsTo('Aa_impacto', 'impacto_id');
    }
    public function alFederalBnd()
    {
        return $this->belongsTo('Bnd', 'al_federal_bnd');
    }
    public function alEstatalBnd()
    {
        return $this->belongsTo('Bnd', 'al_estatal_bnd');
    }
    public function objCorporativoBnd()
    {
        return $this->belongsTo('Bnd', 'obj_corporativo_bnd');
    }
    public function quejasBnd()
    {
        return $this->belongsTo('Bnd', 'quejas_bnd');
    }
    public function severidad()
    {
        return $this->belongsTo('Efecto', 'severidad_id');
    }
    public function frecuencia()
    {
        return $this->belongsTo('Duracion_accion', 'frecuencia_id');
    }
    public function probabilidad()
    {
        return $this->belongsTo('Probabilidad', 'probabilidad_id');
    }
    public function bndPotencial()
    {
        return $this->belongsTo('Bnd', 'bnd_potencial');
    }
    public function impPotencial()
    {
        return $this->belongsTo('Imp_potencial', 'imp_potencial_id');
    }
    public function bndReal()
    {
        return $this->belongsTo('Bnd', 'bnd_real');
    }
    public function impReal()
    {
        return $this->belongsTo('Imp_real', 'imp_real_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('aspectos_ambientales.id', '=', $valor);
    	}
    }
    public function scopeProceso($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('aspectos_ambientales.proceso_id', '=', $valor);
    	}
    }
    public function scopeArea($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('aspectos_ambientales.area_id', '=', $valor);
    	}
    }
    public function scopeImpReal($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('aspectos_ambientales.imp_real_id', '=', $valor);
    	}
    }
    public function scopeImpPotencial($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('aspectos_ambientales.imp_potencial_id', '=', $valor);
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('aspectos_ambientales.cia_id', '=', $valor);
    	}
    }
}
