<?php

class A_rr_ambientale extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'material_id' => 'required',
		'categoria_id' => 'required',
		'documento_id' => 'required',
		'descripcion' => 'required',
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
    public function material()
    {
        return $this->belongsTo('Ca_materiale', 'material_id');
    }
	public function categoria()
    {
        return $this->belongsTo('Ca_categorium', 'categoria_id');
    }

    public function doc1()
    {
        return $this->belongsTo('Ca_aa_doc', 'documento_id');
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
    		return $query->where('a_rr_ambientales.id', '=', $valor);
    	}
    }
    public function scopeMaterial($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_rr_ambientales.material_id', '=', $valor);
    	}
    }
    public function scopeCategoria($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_rr_ambientales.categoria_id', '=', $valor);
    	}
    }
    public function scopeDocumento($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_rr_ambientales.documento_id', '=', $valor);
    	}
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('a_rr_ambientales.st_archivo_id', '=', $valor);
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
            return $query->where('a_rr_ambientales.cia_id', '=', $valor);
        }
    }
}
