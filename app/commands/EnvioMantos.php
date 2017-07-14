<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EnvioMantos extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:EnvioMantos';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa m_mantenimiento y envia correos.';

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
								->select('e.nombre', 'e.mail', 'p.responsable_id','jefe.mail as jefe_mail')
								->join('m_mantenimientos as p', 'e.id', '=', 'p.responsable_id')
								->where('p.estatus_id', '=', '1')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->distinct()
								->get();
				
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					
					$registros=DB::Table('m_mantenimientos as m')
								->select('m.id', 'm.no_orden', 'tm.tpo_manto', 'o.objetivo',
									's.subequipo', 'sol.nombre','m.fec_planeada',
									Db::Raw('DATEDIFF(m.fec_planeada,CURDATE()) as dias_restantes'), 
									'm.dias_aviso', 'st.estatus')
								->join('m_tpo_mantos as tm', 'tm.id', '=', 'm.m_tpo_manto_id')
								->join('m_objetivos as o', 'o.id', '=', 'm.objetivo_id')
								->join('subequipos as s', 's.id', '=', 'm.subequipo_id')
								->join('empleados as sol', 'sol.id','=', 'm.solicitante_id')
								->join('m_estatuses as st', 'st.id','=', 'm.estatus_id')
								->where('m.responsable_id', '=', $r->responsable_id)
								->where('m.dias_aviso', '>', 0)
								->where('m.aviso_bnd', '=', 1)
                                ->where('m.estatus_id', '=', 1)
								->get();
					
					$bnd_valida=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						
						Mail::queue('mails.mantenimientos', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
							{
								$message->to($mail);
								//dd($jefe_mail);
								if(!is_null($jefe_mail)){
									$message->cc($jefe_mail);
								}
								$message->subject('Siam:Mantenimientos');
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
		return array(
			
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			
		);
	}

}
