<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NoConformidadesSeguridad extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:noConformidadesSeguridad';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa bitacoras_seguridad y envia correos.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$p=P_ambiental_correo::find(1);
		if($p->bnd_envio==1){
			if($p->bnd_responsable==1){
				$responsables=DB::Table('empleados as e')
								->select('e.nombre', 'e.mail', 'e.id', 'jefe.mail as jefe_mail')
								->join('bitacora_seguridads as p', 'p.responsable_id', '=', 'e.id')
								->where('p.estatus_id', '<>', '4')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->distinct()
								->get();
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					$registros=DB::Table('bitacora_seguridads as bs')
								->select('bs.id', 'bs.inconformidad','bs.fecha','a.area','bs.solucion',
									'bs.fec_planeada', 'em.nombre','st.estatus', 'e.abreviatura',
									Db::Raw('DATEDIFF(bs.fec_planeada,CURDATE()) as dias_restantes'),
									'bs.dias_aviso')
								->join('areas as a', 'a.id', '=', 'bs.area_id')
								->join('s_st_bs as st', 'st.id','=', 'bs.estatus_id')
								->join('entidades as e', 'e.id', '=', 'bs.cia_id')
								->join('empleados as em', 'em.id', '=', 'bs.responsable_id')
								->where('bs.responsable_id', '=', $r->id)
								->where('bs.estatus_id', '<>','4')
								->get();

					$bnd_valida=0;
					
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						Mail::queue('mails.noConformidadesSeguridad', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
						{
						    $message->to($mail);
						    if(!is_null($jefe_mail)){
						    	$message->cc($jefe_mail);
						    }
						    $message->subject('Siam:No Conformidades de Seguridad');
						});	
					}
				}
				
			}
		
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		/*return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);*/
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		/*return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);*/
		return array();
	}

}
