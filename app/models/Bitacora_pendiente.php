<?php

class Bitacora_pendiente extends Eloquent {
    //Uso de Revisionable para historicos
    use \Venturecraft\Revisionable\RevisionableTrait;
    
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'pendiente' => 'required',
		'comentarios' => 'required',
		'fec_planeada' => 'required',
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
    public function estatus()
    {
        return $this->belongsTo('Bit_st', 'bit_st_id');
    }
    public function avisoBnd()
    {
        return $this->belongsTo('Bnd', 'aviso');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function comentarios()
    {
        return $this->hasMany('A_comentarios_pendiente', 'pendiente_id', 'id');
    }
    

	
	/* Scopes */
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_pendientes.id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeEstatus($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_pendientes.estatus_id', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeFechaPlaneada($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_pendientes.fec_planeada', 'like', '%'.$valor.'%');
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('bitacora_pendientes.cia_id', 'like', '%'.$valor.'%');
    	}
    }
}
