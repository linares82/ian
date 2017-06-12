<?php

class S_procedimiento extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'tpo_procedimiento_id' => 'required',
		'tpo_doc_id' => 'required',
		'descripcion' => 'required',
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
    public function tpoProcedimiento()
    {
        return $this->belongsTo('Cs_tpo_procedimiento', 'tpo_procedimiento_id');
    }
    public function tpoDocumento()
    {
        return $this->belongsTo('Cs_tpo_doc', 'tpo_doc_id');
    }
    public function estatus()
    {
        return $this->belongsTo('S_estatus_procedimiento', 'estatus_id');
    }
    public function comentarios()
    {
        return $this->hasMany('S_comentarios_procedimiento', 's_procedimiento_id', 'id');
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
    		return $query->where('s_procedimientos.id', '=', $valor);
    	}
    }
    public function scopeTpoProcedimiento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_procedimientos.tpo_procedimiento_id', '=', $valor);
    	}
    }
    public function scopeTpoDocumento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_procedimientos.tpo_doc_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_procedimientos.estatus_id', '=', $valor);
    	}
    }
    public function scopeResponsable($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('s_procedimientos.responsable_id', '=', $valor);
        }
    }
    public function scopeCia($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('s_procedimientos.cia_id', '=', $valor);
        }
    }
}
