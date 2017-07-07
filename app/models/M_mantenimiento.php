<?php

class M_mantenimiento extends Eloquent {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	
	protected $guarded = array();

	/* Reglas de validacion */
	public static $rules = array(
		'estatus_id' => 'not_in:0',
		'objetivo_id' => 'not_in:0',
		
		'descripcion' => 'required',
		
		'horas_inv' => 'required',
		'fec_planeada' => 'required',
		'tpo_manto_id' => 'not_in:0',
		'clase_manto_id' => 'not_in:0',
		'area_id' => 'not_in:0',
		'responsable_id' => 'not_in:0',
		
		'costo' => 'required',
		
	);
	
	/* Mensajes de validaciones */
	public static $rulesMessages=array(
		'required' => 'El campo :attribute es obligatorio.',
        'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email' => 'El campo :attribute debe ser un email válido.',
        'max' => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique' => 'El email ingresado ya existe en la base de datos',
        'not_in' => 'El valor ingresado no es valido'
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
    public function cia()
    {
        return $this->belongsTo('Entidad', 'cia_id');
    }
    public function objetivo()
    {
        return $this->belongsTo('M_objetivo', 'objetivo_id');
    }
	public function equipo()
    {
        return $this->belongsTo('Subequipo', 'subequipo_id');
    }
    public function tpoManto()
    {
        return $this->belongsTo('M_tpo_manto', 'm_tpo_manto_id');
    }
    public function claseManto()
    {
        return $this->belongsTo('M_clase_manto', 'm_clase_manto_id');
    }
    public function estatus()
    {
        return $this->belongsTo('M_estatus', 'estatus_id');
    }
    public function area()
    {
        return $this->belongsTo('Area', 'area_id');
    }
    public function solicitante()
    {
        return $this->belongsTo('Empleado', 'solicitante_id');
    }
    public function responsable()
    {
        return $this->belongsTo('Empleado', 'responsable_id');
    }
    public function ejecutor()
    {
        return $this->belongsTo('Empleado', 'ejecutor_id');
    }
    public function Tpp()
    {
        return $this->belongsTo('Bnd', 'tpp_bnd');
    }
    public function supervision(){
        return $this->belongsTo('Bnd', 'supervision_bnd');
    }
    public function conoceProcedimiento(){
        return $this->belongsTo('Bnd', 'conoce_procedimiento_bnd');
    }
    public function llevaEquipo(){
        return $this->belongsTo('Bnd', 'lleva_equipo_bnd');
    }
    public function cumplePuntos(){
        return $this->belongsTo('Bnd', 'cumple_puntos_bnd');
    }
    public function eventualidades(){
        return $this->belongsTo('Bnd', 'eventualidades_bnd');
    }
    public function levantarFormato(){
        return $this->belongsTo('Bnd', 'levantar_formato_bnd');
    }
    public function registroBitacora(){
        return $this->belongsTo('Bnd', 'registro_bitacora_bnd');
    }
    
    
	
	/* Scopes */
	public function scopeIsObjetivo($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('m_mantenimientos.objetivo_id', '=', $valor);
    	}
    }
	
	public function scopeIsSubequipo($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('m_mantenimientos.subequipo_id', '=', $valor);
    	}
    }
	public function scopeId($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('m_mantenimientos.id', '=', $valor);
    	}
    }
    public function scopeCia($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('m_mantenimientos.cia_id', '=', $valor);
    	}
    }
	
    public function scopeClase($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('m_mantenimientos.clase_manto_id', '=', $valor);
    	}
    }
    public function scopeTpo($query, $valor)
    {
    	if ($valor==0){
    		return $query;
    	}else{
    		return $query->where('m_mantenimientos.tpo_manto_id', '=', $valor);
    	}
    }
}
