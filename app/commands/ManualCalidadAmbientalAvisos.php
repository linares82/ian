<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ManualCalidadAmbientalAvisos extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:manualCalidadAmbientalAvisos';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa a_archivos y envia correos.';

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
								->join('a_archivos as p', 'e.id', '=', 'p.responsable_id')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->where('p.st_archivo_id', '<>', '3')
								->distinct()
								->get();
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					$registros=DB::Table('a_archivos as aa')
								->select('cd.doc', 'aa.descripcion', 'aa.fec_ini_vigencia',
									'aa.fec_fin_vigencia', 'aa.obs', 'st.estatus', 'e.abreviatura',
									Db::Raw('DATEDIFF(aa.fec_fin_vigencia,CURDATE()) as dias_restantes'), 
									'aa.dias_aviso', 'aa.id')
								->join('ca_ca_docs as cd', 'cd.id', '=', 'aa.documento_id')
								->join('a_st_archivos as st', 'st.id','=', 'aa.st_archivo_id')
								->join('entidades as e', 'e.id', '=', 'aa.cia_id')
								->where('aa.usu_mod_id', '=', $r->responsable_id)
								->where('aa.st_archivo_id', '<>','3')
								->where('aa.aviso', '=', 1)
								->get();

					$bnd_valida=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						Mail::queue('mails.manualCalidadAmbiental', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
						{
						    $message->to($mail);
						    if(!is_null($jefe_mail)){
						    	$message->cc($jefe_mail);	
						    }
						    $message->subject('Siam:Manual de Calidad');
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
