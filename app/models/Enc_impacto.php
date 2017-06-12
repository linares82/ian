<?php

class Enc_impacto extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'cliente_id' => 'not_in:0',
		'tipo_impacto_id' => 'not_in:0',
		'fecha_inicio' => 'required',
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_in' => 'Campo requerido.'
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
	public function cliente()
    {
        return $this->belongsTo('Cliente', 'cliente_id');
    }
    public function tipoImpacto()
    {
        return $this->belongsTo('Tipo_impacto', 'tipo_impacto_id');
    }
    public function regImpactos()
    {
        return $this->hasMany('Reg_impacto', 'enc_impacto_id', 'id');
    }
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('enc_impactos.id', '=', $value);
    	}
    }
    public function scopeCliente($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('enc_impactos.cliente_id', '=', $value);
    	}
    }
    public function scopeTipoImpacto($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('enc_impactos.tipo_impacto_id', '=', $value);
    	}
    }
    public function scopeCia($query, $value)
    {
        if ($value==0){
            return $query;
        }else{
            return $query->where('enc_impactos.cia_id', '=', $value);
        }
    }
    public function scopeFecha($query, $value)
    {
    	if ($value==''){
    		return $query;
    	}else{
    		return $query->where('enc_impactos.fecha_inicio', 'like', '%'.$value.'%');
    	}
    }
}
