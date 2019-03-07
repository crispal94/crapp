<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\Proyectos;
use Illuminate\Support\Facades\Input;
use App\Actividades;
use App\GrupoUsuarios;
use App\User;
use App\Avances;
use App\Estados;
use Mail;
use PDF;
use App\Roles;

class ReportesHistoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $role = getRole();

      $roleid = Roles::where('name',$role)->first();

      $supervisores = DB::select("select u.id as id, u.name as usuario
      from users u
      inner join roles_tipo r on (r.id = u.id_roltipo)
      inner join roles ru on (ru.id = r.id_roles)
      where ru.title = 'Supervisor'");

      $arrsupervisores = ['N'=>'Ingrese Dato'];

      foreach($supervisores as $sus){
        $arrsupervisores[$sus->id] = $sus->usuario;
      }

      $url = 'historia';
      $modulo = 'Reportes';
      $nombre = 'Historia';

        return view('reportes_historia.index',compact('arrsupervisores','role','roleid','url','modulo','nombre'));
    }

    public function getproyectos(Request $request){
      $flag = Input::get('flag');
      $fechadesde = Input::get('fechadesde');
      $fechahasta = Input::get('fechahasta');
      $supervisor = Input::get('supervisor');
      $tipo = Input::get('tipo');

      $qbase = "select cab.id as id, cab.nombre as nombre, cab.descripcion as descripcion, cab.duracion as duracion,
      us.name as responsable, cab.fechainicio as fechainicio, cab.fechafin as fechafin, pt.valor as tiempo,
      CASE WHEN cab.id_user IS NOT NULL THEN u.name ELSE gt.descripcion END recursos,
      CASE WHEN cab.tipo_recurso = 'gt' THEN 'Grupo de Trabajo' ELSE 'Usuario' END tipo,
      ha.tipo as tipoh, ha.fechahistoria, ha.observacion
      from cab_actividad cab
      left join users u on (u.id = cab.id_user)
      left join users us on (us.id = cab.id_responsable)
      left join grupos_trabajos gt on (gt.id = cab.id_grupo)
      left join param_referenciales pt on (pt.id = cab.id_refertiempo)
      inner join historia_actividad ha on (ha.id_cabecera = cab.id)
      where cab.deleted_at is not null";

      if($supervisor!='N'){
        $qbase.=" and cab.id_responsable = $supervisor";
      }

      if($tipo!='Todos'){
        $qbase.=" and ha.tipo ='$tipo'";
      }


      if($flag==0){
               $qbase.= " and (fechainicio BETWEEN '$fechadesde' and DATE_ADD('$fechahasta',INTERVAL 1 DAY))";
      }

      $query = DB::select($qbase);

      $arreglot = [];

      foreach($query as $q){
        $arr = [];
        $boton1 = '<button type="button" class="btn btn-primary" id="novedades">Novedades</button>';
        $color = getEstadoProyectoDeleted($q->id);
        $avapor = getAvanceProyectoDeleted($q->id);
        switch ($color) {
          case 'rojo':
            $estado = '<h3><span class="badge badge-danger">Peligro</span></h3>';
            break;

          case 'anaranjado':
          $estado = '<h3><span class="badge badge-warning">Alerta</span></h3>';
            break;

          case 'azul':
          $estado = '<h3><span class="badge badge-primary">Estable</span></h3>';
            break;
          case 'gris':
          $estado = '<h3><span class="badge badge-secondary">Sin Actividad</span></h3>';
            break;

        }
        array_push($arr,$q->tipoh);
        array_push($arr,$q->fechahistoria);
        array_push($arr,$q->observacion);
        array_push($arr,$estado);
        array_push($arr,$avapor);
        array_push($arr,$q->nombre);
        array_push($arr,$q->responsable);
        array_push($arr,$q->recursos.'-'.$q->tipo);
        array_push($arr,$q->duracion.' '.$q->tiempo.'(s)');
        array_push($arr,$q->fechainicio);
        array_push($arr,$q->fechafin);
        array_push($arr,$q->id);
        array_push($arr,$color);
        array_push($arreglot,$arr);
      }

      return response()->json(['consulta'=>$arreglot]);
    }

    public function imprimir(Request $request){
        $arregloim = $request->input('adatai');
        $aconsulta = json_decode($arregloim);
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d H:i:s");

        $data = [
          'fecha' => $fecha,
          'aconsulta' => $aconsulta
        ];
       $pdf = PDF::loadView('pdf.historia',$data)->setPaper('a4')->setOrientation('landscape');
        return $pdf->stream('reportehistoriaproyectos.pdf');
       //return view('pdf.proyectostotal',compact('aconsulta','fecha'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
