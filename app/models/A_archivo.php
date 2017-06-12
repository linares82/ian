<?php

class A_archivo extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'documento_id' => 'required',
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
    public function documento()
    {
        return $this->belongsTo('Ca_ca_doc', 'documento_id');
    }
    public function avisoBnd()
    {
        return $this->belongsTo('Bnd', 'aviso');
    }
    public function comentarios()
    {
        return $this->hasMany('A_comentarios_archivo', 'a_archivo_id', 'id');
    }
    public function responsable()
    {
        return $this->hasMany('Empleado', 'responsable_id', 'id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_archivos.id', 'like', '=', $valor);
    	}
    }
    public function scopeDocumento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_archivos.documento_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('a_archivos.st_archivo_id', '=', $valor);
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
    		return $query->where('a_archivos.cia_id', '=', $valor);
    	}
    }
}
