<?php

class Rev_requisitos_ln extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'impacto_id' => 'not_in:0',
		'condicion_id' => 'not_in:0',
		'area_id' => 'not_in:0',
		'norma' => 'required',
		'estatus_id' => 'not_in:0',
		'importancia_id' => 'not_in:0',
		'responsable_id' => 'not_in:0',
		'dias_advertencia1' => 'required',
		'dias_advertencia2' => 'required',
		'dias_advertencia3' => 'required',
		'fec_cumplimiento' => 'required',
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_in'=>'El campo :attribute debe tener un valor valido.',
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
    public function impacto()
    {
        return $this->belongsTo('Aa_impacto', 'impacto_id');
    }
    public function condicion()
    {
        return $this->belongsTo('Condicione', 'condicion_id');
    }
    public function area()
    {
        return $this->belongsTo('Area', 'area_id');
    }
    public function estatus()
    {
        return $this->belongsTo('Estatus_condicione', 'usu_mod_id');
    }
    public function importancia()
    {
        return $this->belongsTo('Importancium', 'importancia_id');
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
    		return $query->where('rev_requisitos_lns.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeRevRequisito($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('rev_requisitos_lns.rev_requisitos_id', '=', $valor);
    	}
    }
}
