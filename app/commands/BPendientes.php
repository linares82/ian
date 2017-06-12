<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BPendientes extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:bPendientes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'revisa bitacora_pendeintes y envia correos.';

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
			$responsables=DB::Table('empleados as e')
								->select('e.nombre', 'e.mail', 'p.responsable_id', 'jefe.mail as jefe_mail')								
								->join('bitacora_pendientes as p', 'e.id', '=', 'p.responsable_id')
								->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
								->where('p.bit_st_id', '<>', '4')
								->distinct()
								->get();
				foreach($responsables as $r){
					$mail=$r->mail;
					$jefe_mail=$r->jefe_mail;
					$nombre=$r->nombre;
					$registros=DB::Table('bitacora_pendientes as bp')
								->select('bp.id', 'bp.pendiente', 'bp.comentarios','bp.fec_planeada',
									'st.estatus', 'e.abreviatura',
									Db::Raw('DATEDIFF(bp.fec_planeada,CURDATE()) as dias_restantes'), 
									'bp.dias_aviso')
								->join('bit_sts as st', 'st.id','=', 'bp.bit_st_id')
								->join('entidades as e', 'e.id', '=', 'bp.cia_id')
								->where('bp.responsable_id', '=', $r->responsable_id)
								->where('bp.bit_st_id', '<>','4')
								->where('bp.aviso', '=', 1)
								->get();

					$bnd_valida=0;
					foreach($registros as $registro){
						if($registro->dias_restantes<=$registro->dias_aviso){
						$bnd_valida=1;		
						}
					}
					
					if($bnd_valida==1){
						//dd($registros);
						Mail::queue('mails.bPendientes', 
							array('rs'=>$registros, 'nombre'=>$r->nombre), 
							function($message) use($mail, $jefe_mail) 
						{
						    $message->to($mail);
						    if(!is_null($jefe_mail)){
						    	$message->cc($jefe_mail);
						    }
						    $message->subject('Siam:B. Pendientes');
						});
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
