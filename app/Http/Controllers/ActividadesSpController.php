<?php

namespace App\Http\Controllers;

use App\ActividadesSp;
use App\ParamReferenciales;
use App\TipoActividades;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Session;
use App\Mail\NotificaActividadSp;
use Mail;

class ActividadesSpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades = ActividadesSp::all();
        $url = 'spactividades';
        $modulo = '';
        $nombre = 'Actividades sin Planificación';

        $actividades = DB::table('sp_actividad')
            ->select('ta.descripcion as tipoactividad', 'ah.descripcion as descripcionhorario', 'sp_actividad.nombre', 'u.name as usuario', 'sp_actividad.duracion',
                'sp_actividad.fechainicio', 'sp_actividad.id', 'pt.valor', 'sp_actividad.fechafin','ah.id as idhorario','sp_actividad.descripcion as descripcionsp')
            ->join('users as u', 'u.id', '=', 'sp_actividad.id_responsable')
            ->leftJoin('param_referenciales as pt', 'pt.id', '=', 'sp_actividad.id_refertiempo')
            ->leftJoin('tipo_actividades as ta', 'ta.id', '=', 'sp_actividad.id_tipoactividad')
            ->leftJoin('actividades_horario as ah', 'ah.id', '=', 'sp_actividad.id_actividad_horario')
            ->whereNull('sp_actividad.deleted_at')
            ->where('sp_actividad.id_responsable', Auth::id())
            ->where('sp_actividad.estado', '1')
            ->orderBy('sp_actividad.fechainicio', 'asc')
            ->get();

        return view('sp_actividades.index', compact('actividades', 'actividades', 'url', 'modulo', 'nombre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoactividades = TipoActividades::all();
        $tiempo = ParamReferenciales::where('grupo', 'Proyecto')
            ->where('clave', 'Tiempo')
            ->whereIn('id', [12, 13])
            ->orderBy('id', 'asc')->get();
        foreach ($tipoactividades as $t) {
            $arrtipo[$t->id] = $t->descripcion;
        }
        $url = 'spactividades';
        $modulo = '';
        $nombre = 'Actividades sin Planificación';

        return view('sp_actividades.create', compact('arrtipo', 'tiempo', 'url', 'modulo', 'nombre'));
    }

    public function ingresarFecha(Request $request){
        $fecha = Input::get('fecha');
        $qfecha = DB::select("select * from det_actividad WHERE (? BETWEEN fechainicio AND fechafin)", [$fecha]);
        if(empty($qfecha)){
            $actividad = new ActividadesSp;
            $actividad->id_responsable = Auth::id();
            $actividad->id_tipoactividad = Input::get('tipoactividad');
            $actividad->nombre = Input::get('nombreact');
            $actividad->descripcion = Input::get('descripcion');
            $actividad->fechainicio = Input::get('fecha');
            $actividad->duracion = Input::get('duracionact');
            $actividad->estado = 1;
            $duracionact = Input::get('duracionact');
            $actividad->id_refertiempo = Input::get('tiempo');
            $fechap = date("Y-m-d H:i:s", strtotime(Input::get('fecha')));
            $usuario = Auth::user();
            $qtiempo = ParamReferenciales::find(Input::get('tiempo'));
            $tiempomail = '';
            switch ($qtiempo->valor) {
                case 'Hora':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " hour"));
                    $tiempomail = 'Hora(s)';
                    break;

                case 'Día':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " day"));
                    $tiempomail = 'Día(s)';
                    break;

                case 'Semana':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " week"));
                    $tiempomail = 'Semana(s)';
                    break;

                case 'Mes':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " month"));
                    $tiempomail = 'Mes(es)';
                    break;

                case 'Año':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " year"));
                    $tiempomail = 'Año(s)';
                    break;
            }
            //dd($fechapf);

            $actividad->fechafin = $fechapf;
            $arregmail = [];
            array_push($arregmail, $usuario->name);
            array_push($arregmail, $actividad->nombre);
            array_push($arregmail, $actividad->fechainicio);
            array_push($arregmail, $actividad->duracion);
            array_push($arregmail, $tiempomail);
            Mail::to('albertopl20095@gmail.com')->send(new NotificaActividadSp($arregmail));
            $actividad->save();
            return response()->json(['flag'=>2,'mensaje'=>'Registro creado correctamente']);
        }else {
            return response()->json(['flag'=>1]);
        }
        //return response()->json(['flag'=>1]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actividad = ActividadesSp::find($id);
        $tipoactividades = TipoActividades::all();
        $tiempo = ParamReferenciales::where('grupo', 'Proyecto')
        ->where('clave', 'Tiempo')
        ->whereIn('id', [12, 13])
        ->orderBy('id', 'asc')->get();
        foreach ($tipoactividades as $t) {
            $arrtipo[$t->id] = $t->descripcion;
        }
        $url = 'spactividades';
        $modulo = '';
        $nombre = 'Actividades sin Planificación';

        return view('sp_actividades.edit', compact('arrtipo', 'tiempo', 'url', 'modulo', 'nombre', 'actividad'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actividad = ActividadesSp::find($id);
        //$actividad->id_responsable = Auth::id();
        $actividad->id_tipoactividad = $request->tipoactividad;
        $actividad->nombre = $request->nombreact;
        $actividad->fechainicio = $request->fechainicio;
        $actividad->duracion = $request->duracion;
        $actividad->id_refertiempo = $request->tiempo;
        $actividad->save();
        Session::flash('message', 'Registro editado correctamente');
        return redirect()->action('ActividadesSpController@index');

    }

    public function editarFecha(Request $request,$id){
        $fecha = Input::get('fecha');
        $qfecha = DB::select("select * from det_actividad WHERE (? BETWEEN fechainicio AND fechafin)", [$fecha]);
        if(empty($qfecha)){
            $actividad = ActividadesSp::find($id);
            $actividad->id_tipoactividad = Input::get('tipoactividad');
            $actividad->nombre = Input::get('nombreact');
            $actividad->descripcion = Input::get('descripcion');
            $actividad->fechainicio = Input::get('fecha');
            $actividad->duracion = Input::get('duracionact');
            $duracionact = Input::get('duracionact');
            $actividad->id_refertiempo = Input::get('tiempo');
            $fechap = date("Y-m-d H:i:s", strtotime(Input::get('fecha')));
            $usuario = Auth::user();
            $qtiempo = ParamReferenciales::find(Input::get('tiempo'));
            $tiempomail = '';
            switch ($qtiempo->valor) {
                case 'Hora':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " hour"));
                    $tiempomail = 'Hora(s)';
                    break;

                case 'Día':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " day"));
                    $tiempomail = 'Día(s)';
                    break;

                case 'Semana':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " week"));
                    $tiempomail = 'Semana(s)';
                    break;

                case 'Mes':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " month"));
                    $tiempomail = 'Mes(es)';
                    break;

                case 'Año':
                    $fechapf = date("Y-m-d H:i:s", strtotime($fechap . "+ " . $duracionact . " year"));
                    $tiempomail = 'Año(s)';
                    break;
            }
            //dd($fechapf);

            $actividad->fechafin = $fechapf;
            $actividad->save();
            return response()->json(['flag'=>2,'mensaje'=>'Registro editado correctamente']);
        }else {
            return response()->json(['flag'=>1]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $idactividad = Input::get('idactividad');
        $actividad = ActividadesSp::find($idactividad)->delete();
        return response()->json(['flag' => 2, 'mensaje' => 'Actividad eliminada con éxito!']);

    }

    public function finalizaractividad(Request $request){
        date_default_timezone_set('America/Bogota');
        $idactividad = Input::get('idactividad');
        $observacion = Input::get('observacion');
        $actividad = ActividadesSp::find($idactividad);
        $actividad->observacion = $observacion;
        $actividad->estado = 2;
        $actividad->fecha_ultactivo = date("Y-m-d H:i:s");
        $actividad->save();
        return response()->json(['flag'=>2,'mensaje'=>'Actividad finalizada con éxito!']);
    }
}
