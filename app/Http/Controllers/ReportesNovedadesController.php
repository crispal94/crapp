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

class ReportesNovedadesController extends Controller
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

        return view('reportes_novedades.index',compact('arrsupervisores','role','roleid'));
    }

    public function getproyectos(Request $request){
        $flag = Input::get('flag');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');
        $supervisor = Input::get('supervisor');

        $qbase = "select cab.id as id, cab.nombre as nombre, cab.descripcion as descripcion, cab.duracion as duracion,
        us.name as responsable, cab.fechainicio as fechainicio, cab.fechafin as fechafin, pt.valor as tiempo,
        CASE WHEN cab.id_user IS NOT NULL THEN u.name ELSE gt.descripcion END recursos,
        CASE WHEN cab.tipo_recurso = 'gt' THEN 'Grupo de Trabajo' ELSE 'Usuario' END tipo
        from cab_actividad cab
        left join users u on (u.id = cab.id_user)
        left join users us on (us.id = cab.id_responsable)
        left join grupos_trabajos gt on (gt.id = cab.id_grupo)
        left join param_referenciales pt on (pt.id = cab.id_refertiempo)
        left join seg_novedades nov on (nov.id_cabecera = cab.id)
        where cab.deleted_at is null group by cab.id";

        if($supervisor!='N'){
          $qbase.=" and cab.id_responsable = $supervisor";
        }


        if($flag==0){
                 $qbase.= " and (fechainicio BETWEEN '$fechadesde' and DATE_ADD('$fechahasta',INTERVAL 1 DAY))";
        }

        $query = DB::select($qbase);

        $arreglot = [];

        foreach($query as $q){
          $arr = [];
          $boton1 = '<button type="button" class="btn btn-primary" id="novedades">Novedades</button>';
          $color = getEstadoProyecto($q->id);
          $avapor = getAvanceProyecto($q->id);
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
          array_push($arr,$boton1);
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


    public function getnovedades(){
      $id = Input::get('id');
      $query = DB::select("select det.nombre as actividad, nov.estado_anterior, nov.estado_nuevo,
      nov.observacion_anterior, nov.observacion_nuevo,nov.fecha_anterior, nov.fecha_nuevo
      from seg_novedades nov
      inner join det_actividad det on (det.id = nov.id_actividad)
      where det.id_cabecera = ?",[$id]);

      $arreglot = [];

      foreach($query as $q){
          $arr = [];
          array_push($arr,$q->actividad);
          array_push($arr,$q->estado_anterior);
          array_push($arr,$q->estado_nuevo);
          array_push($arr,$q->observacion_anterior);
          array_push($arr,$q->observacion_nuevo);
          array_push($arr,$q->fecha_anterior);
          array_push($arr,$q->fecha_nuevo);
          array_push($arreglot,$arr);
      }

      return response()->json(['consulta'=>$arreglot]);
    }

    public function imprimir(Request $request){
        $arregloim = $request->input('adatai');
        $id = $request->input('cabecera');
        $proyecto = Proyectos::find($id);
        //dd($arregloim);
        $aconsulta = json_decode($arregloim);
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d H:i:s");

        $data = [
          'fecha' => $fecha,
          'aconsulta' => $aconsulta,
          'nombre' =>$proyecto->nombre,
          'supervisor' =>$proyecto->responsable->name,
          'duracion' =>$proyecto->duracion.' '.$proyecto->tiempo->valor.'(s)',
          'fechainicio' =>$proyecto->fechainicio,
          'fechafin' =>$proyecto->fechafin,
        ];
       $pdf = PDF::loadView('pdf.novedades',$data)->setPaper('a4')->setOrientation('landscape');
        return $pdf->stream('reportenovedades.pdf');
        //return view('pdf.novedades',$data);
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
