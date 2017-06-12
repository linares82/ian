<?php

class A_procedimiento extends Eloquent {
	  protected $table = 'a_procedimientos';

	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'procedimiento_id' => 'required',
		'descripcion' => 'required',
		'fec_ini_vigencia' => 'required',
		'fec_fin_vigencia' => 'required',
		'aviso' => 'required',
		'dias_aviso' => 'required',
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

    public function procedimiento()
    {
        return $this->belongsTo('Ca_procedimiento', 'procedimiento_id');
    }
    
    public function avisoBnd()
    {
        return $this->belongsTo('Bnd', 'aviso');
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
    		return $query->where('a_procedimientos.id', '=', $valor);
    	}
    }
    public function scopeProcedimiento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_procedimientos.procedimiento_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_procedimientos.st_archivo_id', '=', $valor);
    	}
    }
    public function scopeResponsable($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('a_procedimientos.responsable_id', '=', $valor);
        }
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_procedimientos.cia_id', '=', $valor);
    	}
    }
}
