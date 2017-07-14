<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EnvioCorreos extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ian:envioCorreos';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revisa p_ambiental_correos y ejecuta comandos de correos';

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
		//$cia=User::find(Sentry::getUser()->id)->Entidad->id;
		//$cia=$valor = $this->argument('cia');
		$p=P_ambiental_correo::find(1);
		$dias=(strtotime(date('Y-m-d'))-strtotime($p->fec_ult_envio))/86400;
		if($dias>=1){
			try{
					Artisan::call('ian:procedimientosAmbientalesAvisos');
					Artisan::call('ian:manualCalidadAmbiental');
					Artisan::call('ian:noConformidadesAmbientales');
					Artisan::call('ian:rrAmbientales');
					Artisan::call('ian:procedimientosProtocolos');
					Artisan::call('ian:registrosSeguridad');
					Artisan::call('ian:documentosSeguridad');
					Artisan::call('ian:noConformidadesSeguridad');
					Artisan::call('ian:EnvioMantos');

					Artisan::call('ian:bPendientes');
					Artisan::call('ian:revRequisitosMail');
					Artisan::call('ian:revDocumentalCumplimiento');
					Artisan::call('ian:revDocumentalVencimiento');

				}
				catch(Exception $e){}
			$cias=Entidad::all();
			//dd($cias);
			foreach($cias as $cia)
			{
				try{
					Artisan::call('ian:bFuentesFijas', array('cia'=>$cia->id));
					Artisan::call('ian:bPlantas', array('cia'=>$cia->id));
					Artisan::call('ian:bConsumibles', array('cia'=>$cia->id));
					Artisan::call('ian:bResiduos', array('cia'=>$cia->id));

				}
				catch(Exception $e){}
			}
			$p->fec_ult_envio=date('Y-m-d');
			$p->save();	
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
