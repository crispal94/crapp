<?php

namespace App\Console\Commands;

use App\ActividadesSp;
use App\Horarios;
use Illuminate\Console\Command;

class cronActividades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:actividades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina actividades que no han sido finalizadas';

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
    public function handle()
    {
        date_default_timezone_set('America/Bogota');
        $actividades = ActividadesSp::where('estado', 1)->get();
        foreach ($actividades as $act) {
            $idActividad = $act->id_actividad_horario;
            $act->estado = 3;
            $act->save();
            // $act->delete();
            $horario = Horarios::find($idActividad)->delete();
        }
    }
}
