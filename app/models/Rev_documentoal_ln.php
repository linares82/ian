<?php

class Rev_documentoal_ln extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'tpo_documento_id' => 'not_in:0',
		'documento_id' => 'not_in:0',
		'grupo_norma_id' => 'not_in:0',
        'norma_id' => 'not_in:0',
		'estatus_id' => 'not_in:0',
		'importancia_id' => 'not_in:0',
		'responsable_id' => 'not_in:0',
		'dias_advertencia1' => 'required',
		'dias_advertencia2' => 'required',
		'dias_advertencia3' => 'required',
		'fec_cumplimiento' => 'required',
		'fec_vencimiento' => 'required',
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_in'=>'El campo :attribute debe ser una opción válida.',
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
    public function tpoDocumento()
    {
        return $this->belongsTo('Tpo_doc', 'tpo_documento_id');
    }
    public function documento()
    {
        return $this->belongsTo('R_documento', 'documento_id');
    }
    public function estatus()
    {
        return $this->belongsTo('Estatus_requisito', 'estatus_id');
    }
    public function importancia()
    {
        return $this->belongsTo('Importancium', 'importancia_id');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function grupoNorma()
    {
        return $this->belongsTo('Cs_grupo_norma', 'grupo_norma_id');
    }
    public function norma()
    {
        return $this->belongsTo('Cs_norma', 'norma_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('rev_documentoal_lns.id', '=', $valor);
    	}
    }
    public function scopeRevDocumental($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('rev_documentoal_lns.rev_documental_id', '=', $valor);
    	}
    }
}
