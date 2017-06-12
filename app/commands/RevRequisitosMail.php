<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RevRequisitosMail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:revRequisitosMail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa bitacora_accidentes y envia correos.';

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
								->select('e.nombre', 'e.mail', 'e.id', 'jefe1.mail as jefe1_mail', 'jefe2.mail as jefe2.mail')
								->join('rev_requisitos_lns as rrl', 'rrl.responsable_id', '=', 'e.id')
								->where('rrl.estatus_id', '<>', '2')
								->leftJoin('empleados as jefe1', 'jefe1.id', '=', 'e.jefe_id')
								->leftJoin('empleados as jefe2', 'jefe2.id', '=', 'jefe1.jefe_id')
								->distinct()
								->get();
				//dd($responsables);
				foreach($responsables as $r){
					$mail=$r->mail;
					$nombre=$r->nombre;
					if(isset($r->jefe1_mail)){
						$jefe1_mail=$r->jefe1_mail;
					}else{
						$jefe1_mail='';
					}
					if(isset($r->jefe2_mail)){
						$jefe2_mail=$r->jefe2_mail;
					}else{
						$jefe2_mail='';
					}
					
					$registros=DB::Table('rev_requisitos_lns as rrl')
								->select('m.mes', 'rr.anio', 'e.abreviatura','ai.impacto','condicion','a.area',
									'st.estatus', 'i.importancia', 'fec_cumplimiento',
									Db::Raw('DATEDIFF(rrl.fec_cumplimiento,CURDATE()) as dias_restantes'),
									'rrl.dias_advertencia1', 'rrl.dias_advertencia2', 'rrl.dias_advertencia3')
								->join('rev_requisitos as rr', 'rr.id', '=', 'rrl.rev_requisitos_id')
								->join('meses as m', 'm.id', '=', 'rr.mes_id')
								->join('aa_impactos as ai', 'ai.id', '=', 'rrl.impacto_id')
								->join('areas as a', 'a.id', '=', 'rrl.area_id')
								->join('estatus_condiciones as st', 'st.id','=', 'rrl.estatus_id')
								->join('importancia as i', 'i.id', '=', 'rrl.importancia_id')
								->join('entidades as e', 'e.id', '=', 'rr.cia_id')
								->join('empleados as em', 'em.id', '=', 'rrl.responsable_id')
								->where('rrl.responsable_id', '=', $r->id)
								->where('rrl.estatus_id', '<>','2')
								->get();
					//dd($registros);
					$bnd_advertencia1=0;
					$bnd_advertencia2=0;
					$bnd_advertencia3=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_advertencia1 and 
						   $registro->dias_restantes>$registro->dias_advertencia2){
						$bnd_advertencia1=1;		
						}
						if($registro->dias_restantes<=$registro->dias_advertencia2 and 
						   $registro->dias_restantes>$registro->dias_advertencia3){
						$bnd_advertencia2=1;		
						}
						if($registro->dias_restantes<=$registro->dias_advertencia3 and 
						   $registro->dias_restantes>0){
						$bnd_advertencia3=1;		
						}
					}
					//dd($bnd_advertencia2."-".$bnd_advertencia3);
					if($bnd_advertencia1==1){
						Mail::queue('mails.revRequisitosMail', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe1_mail, $jefe2_mail, $bnd_advertencia2, $bnd_advertencia3) 
						{
						    $message->to($mail);
						    
						    if($jefe1_mail<>'' and $bnd_advertencia2==1){
						    	$message->cc($jefe1_mail);
						    	//dd("jefe1_mail:".$jefe1_mail."-bnd_advertencia2:".$bnd_advertencia2);
						    }
						    if($jefe2_mail<>'' and $bnd_advertencia3==1){
						    	$message->cc($jefe2_mail);
						    }
						    $message->subject('Siam:Revision de Condiciones Fisicas');
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
