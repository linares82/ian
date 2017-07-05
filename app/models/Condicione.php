<?php

class Condicione extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'impacto_id' => 'not_in:0',
		'condicion' => 'required',
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_id' => 'El campo :attribute requiere un valor valido'
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
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('condicion.id', '=', $valor);
    	}
    }
	public function scopeCmbCondiciones($query, $valor){
		$query->get();
		return $query->lists('condicion', 'id');
	}
}
