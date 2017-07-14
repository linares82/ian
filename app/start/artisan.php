<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
//comandos para correos
Artisan::add(new EnvioCorreos);
Artisan::add(new ProcedimientosAmbientalesAvisos);
Artisan::add(new ManualCalidadAmbientalAvisos);
Artisan::add(new NoConformidadesAmbientales);
Artisan::add(new RrAmbientales);
Artisan::add(new ProcedimientosProtocolos);
Artisan::add(new RegistrosSeguridad);
Artisan::add(new DocumentosSeguridad);
Artisan::add(new NoConformidadesSeguridad);
Artisan::add(new EnvioMantos);

Artisan::add(new BFuentesFijas);
Artisan::add(new BPlantas);
Artisan::add(new BConsumibles);
Artisan::add(new BResiduos);
Artisan::add(new BPendientes);

Artisan::add(new RevRequisitosMail);
Artisan::add(new RevDocumentalCumplimiento);
Artisan::add(new RevDocumentalVencimiento);
/*Artisan::add(new BAccidentes);
Artisan::add(new BEnfermedades);
*/
