<?php

class Subequipo extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'equipo_id' => 'required',
		'subequipo' => 'required',
		'clase' => 'required',
		'marca' => 'required',
		'modelo' => 'required',
		'no_serie' => 'required',
		'fecha_carga' => 'required',
		'area_id' => 'required',
		'ubicacion' => 'required',
		
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
	
	public function rEquipo()
    {
        return $this->belongsTo('M_objetivo', 'equipo_id');
    }
	
	public function rArea()
    {
        return $this->belongsTo('Area', 'area_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('subequipos.id', 'like', '%'.$valor.'%');
    	}
    }
	public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('subequipos.cia_id', '=', $valor);
    	}
    }
	public function scopeCmbSubequipos($query, $valor){
		$query->get();
		return $query->lists('subequipo', 'id');
	}
}
