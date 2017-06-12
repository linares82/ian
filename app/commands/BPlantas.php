<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BPlantas extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:bPlantas';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa bitacora_plantas.';

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
		$cia=$valor = $this->argument('cia');
		
		$p=DB::Table('p_correo_bitacoras')
			->where('cia_id',$cia)
			->where('bitacora_id',2)->first();
		
		if($p->bnd_enviar==1){
			$responsable=DB::Table('empleados as e')
						->select('e.nombre', 'e.mail', 'jefe.mail as jefe_mail')
						->leftJoin('empleados as jefe', 'jefe.id', '=', 'e.jefe_id')
						->where('e.id', $p->empleado_id)
						->distinct()
						->first();
			$ff=DB::Table('ca_plantas as cp')
				->select('e.abreviatura', 'cp.planta',
					Db::Raw('max(bp.fecha) as fecha, DATEDIFF(CURDATE(),max(bp.fecha)) as dias'))
				->join('bitacora_plantas as bp', 'bp.planta_id', '=', 'cp.id')
				->join('entidades as e', 'e.id', '=', 'bp.cia_id')
				->where('bp.cia_id', '=', $cia)
				->groupBy('cp.planta')
				->get();
			//dd($ff);
			$mail=$responsable->mail;
			$jefe_mail=$responsable->jefe_mail;
			$resp=$responsable->nombre;
			
			Mail::queue('mails.bPlantas', 
				array('rs'=>$ff, 'dias_plazo'=>$p->dias_plazo, 'resp'=>$resp), 
				function($message) use($mail, $jefe_mail) 
			{
			    $message->to($mail);
			    if(!is_null($jefe_mail)){
			    	$message->cc($jefe_mail);	
			    }
			    $message->subject('Siam:B. Plantas');
			});	

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
			array('cia', InputArgument::REQUIRED, 'Entidad actual de trabajo.'),
		);
		
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
		);
		*/
		return array();
	}

}
