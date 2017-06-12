<?php

class Bitacora_residuo extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'residuo' => 'required',
		'cantidad' => 'required',
		'fecha' => 'required',
		'lugar_generacion' => 'required',
		'ubicacion' => 'required',
		'dispocision' => 'required',
		'transportista' => 'required',
		'responsable_id' => 'required',
		'manifiesto' => 'required',
		'resp_tecnico' => 'required',
		'requiere_vobo' => 'required',
		'registro_residuos' => 'required',
		'peligrosidad' => 'required',
		'fec_ingreso' => 'required',
		'fec_salida' => 'required',
		'cedula_operacion' => 'required',
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
    public function residuos()
    {
        return $this->belongsTo('Ca_residuo', 'residuo');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function requiereVobo()
    {
        return $this->belongsTo('Bnd', 'requiere_vobo');
    }
    public function registroResiduos()
    {
        return $this->belongsTo('Bnd', 'registro_residuos');
    }
	public function cedulaOperacion()
    {
        return $this->belongsTo('Bnd', 'cedula_operacion');
    }
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bicatora_residuos.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeResiduo($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bicatora_residuos.fecha', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('bitacora_residuos.cia_id', 'like', '%'.$valor.'%');
        }
    }
}
