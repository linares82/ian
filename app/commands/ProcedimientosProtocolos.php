<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProcedimientosProtocolos extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:procedimientosProtocolos';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa s_procedimientos y envia correos.';

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
								->select('e.nombre', 'e.mail', 'p.responsable_id', 'jefe.mail as jefe_mail')
								->join('s_procedimientos as p', 'e.id', '=', 'p.responsable_id')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->where('p.estatus_id', '<>', '3')
								->distinct()
								->get();
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					$registros=DB::Table('s_procedimientos as sp')
								->select('sp.id','cp.tpo_procedimiento', 'td.tpo_doc', 'sp.descripcion', 
									'sp.fec_fin_vigencia', 'st.estatus', 'e.abreviatura',
									Db::Raw('DATEDIFF(sp.fec_fin_vigencia,CURDATE()) as dias_restantes'), 
									'sp.dias_aviso')
								->join('cs_tpo_procedimientos as cp', 'cp.id', '=', 'sp.tpo_procedimiento_id')
								->join('cs_tpo_docs as td', 'td.id', '=', 'sp.tpo_doc_id')
								->join('s_estatus_procedimientos as st', 'st.id','=', 'sp.estatus_id')
								->join('entidades as e', 'e.id', '=', 'sp.cia_id')
								->where('sp.usu_mod_id', '=', $r->responsable_id)
								->where('sp.estatus_id', '<>','3')
								->where('sp.aviso', '=', 1)
								->get();
					$bnd_valida=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						Mail::queue('mails.procedimientosProtocolos', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
						{
						    $message->to($mail);
						    if(!is_null($jefe_mail)){
						    	$message->cc($jefe_mail);
						    }
						    $message->subject('Siam:Procedimientos y Protocolos');
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
