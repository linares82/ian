<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NoConformidadesAmbientales extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:noConformidadesAmbientales';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa a_no_conformidades y envia correos.';

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
								->join('a_no_conformidades as p', 'p.responsable_id', '=', 'e.id')
								->where('p.estatus_id', '<>', '4')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->distinct()
								->get();
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					$registros=DB::Table('a_no_conformidades as anc')
								->select('anc.id', 'anc.no_conformidad','anc.fecha','a.area','anc.solucion',
									'anc.fec_planeada', 'em.nombre','st.estatus', 'e.abreviatura',
									Db::Raw('DATEDIFF(anc.fec_planeada,CURDATE()) as dias_restantes'),
									'anc.dias_aviso')
								->join('areas as a', 'a.id', '=', 'anc.area_id')
								->join('a_st_ncs as st', 'st.id','=', 'anc.estatus_id')
								->join('entidades as e', 'e.id', '=', 'anc.cia_id')
								->join('empleados as em', 'em.id', '=', 'anc.responsable_id')
								->where('anc.responsable_id', '=', $r->id)
								->where('anc.estatus_id', '<>','4')
								->get();
					$bnd_valida=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						Mail::queue('mails.noConformidadesAmbientales', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
						{
						    $message->to($mail);
						    if(!is_null($jefe_mail)){
						    	$message->cc($jefe_mail);
						    }
						    $message->subject('Siam:No Conformidades Ambientales');
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
