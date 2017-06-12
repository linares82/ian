<?php

class S_documento extends Eloquent {
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
		'observaciones' => 'required',
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
        return $this->belongsTo('Cs_cat_doc', 'documento_id');
    }
	public function bnd()
    {
        return $this->belongsTo('Bnd', 'aviso');
    }
    public function comentarios()
    {
        return $this->hasMany('S_comentarios_documento', 's_documento_id', 'id');
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
    		return $query->where('s_documentos.id', '=', $valor);
    	}
    }
    public function scopeCatDoc($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_documentos.documento_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_documentos.estatus_id', '=', $valor);
    	}
    }
    public function scopeResponsable($query, $valor)
    {
        if ($valor==0){
            return $query;
        }else{
            return $query->where('s_documentos.responsable_id', '=', $valor);
        }
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('s_documentos.cia_id', '=', $valor);
    	}
    }
}
