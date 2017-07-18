<?php

class Ca_aa_doc extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'material_id' => 'required',
		'categoria_id' => 'required',
		'doc' => 'required',
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
    public function Material()
    {
        return $this->belongsTo('Ca_materiale', 'material_id');
    }
    public function Categoria()
    {
        return $this->belongsTo('Ca_categorium', 'categoria_id');
    }
	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('ca_aa_docs.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeMaterial($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('ca_aa_docs.material_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCategoria($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('ca_aa_docs.categoria_id', 'like', '%'.$valor.'%');
    	}
    }
	public function scopeCmbDocsRegistro($query, $valor){
		$query->get();
		return $query->lists('documento', 'id');
	}
	public function scopeCia($query, $valor){
		if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('ca_aa_docs.cia_id', '=', $valor);
    	}
	}
}
