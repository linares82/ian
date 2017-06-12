<?php

class Matriz extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'tipo_impacto_id' => 'not_in:0',
        'factor_id' => 'not_in:0',
		'rubro_id' => 'not_in:0',
		'especifico_id' => 'not_in:0',
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_in' => 'Campo requerido'
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
    public function tipoImpacto()
    {
        return $this->belongsTo('Tipo_impacto', 'tipo_impacto_id');
    }
    public function factor()
    {
        return $this->belongsTo('Factor', 'factor_id');
    }
    public function rubro()
    {
        return $this->belongsTo('Rubro', 'rubro_id');
    }
    public function especifico()
    {
        return $this->belongsTo('Especifico', 'especifico_id');
    }
    public function caracteristicas(){
        return $this->belongsToMany('Caracteristica','caracteristica_matriz','matriz_id','caracteristica_id');
    }
	
	/* Scopes */
	public function scopeId($query, $id)
    {
    	if ($id==0){
    		return $query;
    	}else{
    		return $query->where('matrizs.id', 'like', '%'.$id.'%');
    	}
    }
    public function scopeTipoImpacto($query, $value)
    {
        if ($value==0){
            return $query;
        }else{
            return $query->where('matrizs.tipo_impacto_id', 'like', '%'.$value.'%');
        }
    }
    public function scopeFactor($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('matrizs.factor_id', 'like', '%'.$value.'%');
    	}
    }
    public function scopeRubro($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('matrizs.rubro_id', 'like', '%'.$value.'%');
    	}
    }
    public function scopeEspecifico($query, $value)
    {
    	if ($value==0){
    		return $query;
    	}else{
    		return $query->where('matrizs.especifico_id', 'like', '%'.$value.'%');
    	}
    }
}
