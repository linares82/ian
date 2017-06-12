<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RrAmbientales extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:rrAmbientales';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa rr_ambientales y envia correos.';

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
								->join('a_rr_ambientales as p', 'e.id', '=', 'p.responsable_id')
								->where('p.st_archivo_id', '<>', '3')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->distinct()
								->get();
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					$registros=DB::Table('a_rr_ambientales as ara')
								->select('ara.id', 'cm.material', 'cc.categoria', 'cd.doc',
									'ara.descripcion', 'ara.fec_fin_vigencia', 'st.estatus', 'e.abreviatura',
									Db::Raw('DATEDIFF(ara.fec_fin_vigencia,CURDATE()) as dias_restantes'), 
									'ara.dias_aviso')
								->join('ca_materiales as cm', 'cm.id', '=', 'ara.material_id')
								->join('ca_categoria as cc', 'cc.id', '=', 'ara.categoria_id')
								->join('ca_aa_docs as cd', 'cd.id', '=', 'ara.documento_id')
								->join('a_st_archivos as st', 'st.id','=', 'ara.st_archivo_id')
								->join('entidades as e', 'e.id', '=', 'ara.cia_id')
								->where('ara.usu_mod_id', '=', $r->responsable_id)
								->where('ara.st_archivo_id', '<>','3')
								->where('ara.aviso', '=', 1)
								->get();
					$bnd_valida=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						Mail::queue('mails.rrAmbientales', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
						{
						    $message->to($mail);
						    if(!is_null($jefe_mail)){
						    	$message->jefe_mail;
						    }
						    $message->subject('Siam:Reg. y Req. Ambientales');
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
