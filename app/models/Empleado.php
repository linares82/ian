<?php

class Empleado extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'ctrl_interno' => 'required',
		'nombre' => 'required',
		'area_id' => 'required',
		'puesto_id' => 'required',
		'bnd_subordinados' => 'required',
		'jefe_id' => 'required',
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
    public function puesto()
    {
        return $this->belongsTo('Puesto', 'puesto_id');
    }
    public function bndSubordinados()
    {
        return $this->belongsTo('Bnd', 'bnd_subordinados');
    }
    public function jefe()
    {
        return $this->belongsTo('Empleado', 'jefe_id');
    }
  
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('empleados.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeArea($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('empleados.area_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopePuesto($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('empleados.puesto_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('empleados.cia_id', 'like', '%'.$valor.'%');
    	}
    }

	public function scopeCmbEmpleados($query, $valor){
		$query->get();
		return $query->lists('nombre', 'id');
	}
}
