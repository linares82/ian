<?php

class P_correo_bitacora extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'bnd_enviar' => 'required',
		'dias_plazo' => 'required',
		'empleado_id' => 'required',
		'bitacora_id' => 'required',
		'bnd_jefe' => 'required',
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
    public function bndEnviar()
    {
        return $this->belongsTo('Bnd', 'bnd_enviar');
    }
    public function bitacora()
    {
        return $this->belongsTo('Bitacora', 'bitacora_id');
    }
    public function empleado()
    {
        return $this->belongsTo('Empleado', 'empleado_id');
    }
    public function bndJefe()
    {
        return $this->belongsTo('Bnd', 'bnd_jefe');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('p_correo_bitacoras.id', '=', $valor);
    	}
    }

    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('p_correo_bitacoras.cia_id', '=', $valor);
    	}
    }
}
