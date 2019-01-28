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

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $supervisores = DB::select("select u.id as id, u.name as usuario
      from users u
      inner join role_user ru on (ru.user_id = u.id)
      inner join roles r on (r.id = ru.role_id)
      inner join param_referenciales pr on (pr.id = r.id_param)
      where pr.valor = 'Supervisor'");

      $arrsupervisores = ['N'=>'Ingrese Dato'];

      foreach($supervisores as $sus){
        $arrsupervisores[$sus->id] = $sus->usuario;
      }

      $usuarios = User::all();

      $arrusuarios = ['N'=>'Ingrese Dato'];

      foreach($usuarios as $user){
        $arrusuarios[$user->id] = $user->name;
      }

      $grupos = GrupoUsuarios::all();

      $arrgrupo = ['N'=>'Ingrese Dato'];

      foreach($grupos as $gr){
        $arrgrupo[$gr->id] = $gr->descripcion;
      }


      return view('reportes.index',compact('arrsupervisores','arrusuarios','arrgrupo'));

    }

    public function getproyectos(Request $request){
        $flag = Input::get('flag');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');
        $supervisor = Input::get('supervisor');
        $tiporecurso = Input::get('tiporecurso');
        $usuario = Input::get('supervisor');
        $gtrabajo = Input::get('gtrabajo');

        $qbase = "select cab.id as id, cab.nombre as nombre, cab.descripcion as descripcion, cab.duracion as duracion,
        us.name as responsable, cab.fechainicio as fechainicio, cab.fechafin as fechafin, pt.valor as tiempo,
        CASE WHEN cab.id_user IS NOT NULL THEN u.name ELSE gt.descripcion END recursos,
        CASE WHEN cab.tipo_recurso = 'gt' THEN 'Grupo de Trabajo' ELSE 'Usuario' END tipo
        from cab_actividad cab
        left join users u on (u.id = cab.id_user)
        left join users us on (us.id = cab.id_responsable)
        left join grupos_trabajos gt on (gt.id = cab.id_grupo)
        left join param_referenciales pt on (pt.id = cab.id_refertiempo)
        where cab.deleted_at is null";

        if($supervisor!='N'){
          $qbase.=" and cab.id_responsable = $supervisor";
        }

        switch ($tiporecurso) {
          case 'u':
            $qbase.=" and cab.id_user = $usuario and cab.tipo_recurso = 'u'";
            break;

          case 'gt':
            $qbase.=" and cab.id_grupo = $gtrabajo and cab.tipo_recurso = 'gt'";
            break;

          case 'am':
            $qbase.=" and (cab.id_user = $usuario or cab.id_grupo = $gtrabajo)";
            break;
        }

        if($flag==0){
                 $qbase.= " and (fechainicio BETWEEN '$fechadesde' and DATE_ADD('$fechahasta',INTERVAL 1 DAY))";
        }

        $query = DB::select($qbase);

        $arreglot = [];

        foreach($query as $q){
          $arr = [];
          $boton1 = '<button type="button" class="btn btn-primary" id="seguimiento">Seguimiento</button>';
          array_push($arr,$boton1);
          array_push($arr,$q->nombre);
          array_push($arr,$q->responsable);
          array_push($arr,$q->recursos.'-'.$q->tipo);
          array_push($arr,$q->duracion.' '.$q->tiempo.'(s)');
          array_push($arr,$q->fechainicio);
          array_push($arr,$q->fechafin);
          array_push($arr,$q->id);
          array_push($arreglot,$arr);
        }

        return response()->json(['consulta'=>$arreglot]);

    }


    public function seguimiento($id){
      $proyecto = Proyectos::find($id);
      $supervisor = $proyecto->responsable->name;
      $tiporecurso = $proyecto->tipo_recurso;
      $tiempo = $proyecto->tiempo->valor;
      $actividades = DB::select("
      select det.id, det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin, pt.valor
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      left join param_referenciales pt on (pt.id = det.id_refertiempo)
      where det.id_cabecera = ? and det.deleted_at is null
      order by det.fechainicio asc",[$id]);
      $arreglotd = [];
      foreach($actividades as $act){
        $arr = [];
        array_push($arr,$act->actividad);
        array_push($arr,$act->usuario);
        array_push($arr,$act->duracion.' '.$act->valor.'(s)');
        array_push($arr,$act->fechainicio);
        array_push($arr,$act->fechafin);
        array_push($arr,$act->id);
        array_push($arreglotd,$arr);
      }

      return view ('reportes.mostrar',compact('arreglotd','proyecto','supervisor','tiporecurso','tiempo'));
    }


    public function reporte($id){

      $proyecto = Proyectos::where('id',$id)->first();
      date_default_timezone_set('America/Bogota');
      $fecha = date("Y-m-d H:i:s");

      $query = DB::select("select det.id as idactividad, det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin, pt.valor,
              seg.id as idavance, est.descripcion as estado, seg.avance, seg.fechaavance, seg.observacion
              from det_actividad det
              inner join cab_actividad cab on (cab.id = det.id_cabecera)
              inner join users u on (u.id = det.id_responsable)
              left join seg_actividades seg on (det.id = seg.id_detalle)
              left join param_referenciales pt on (pt.id = det.id_refertiempo)
              left join estado est on (est.id = seg.id_estado)
              where det.id_cabecera = ?",[$id]);

        $primera = true;

        $arreglo = [];
        $arregloactividad = [];
        $contotal = 0;
        foreach($query as $q){
          ++$contotal;
          if($primera){
              $idantactividad = $q->idactividad;
              $idantavance = $q->idavance;
              $arregloactividad = [
                'actividad' => $q->actividad,
                'supervisor' => $q->usuario,
                'duracion' => $q->duracion.' '.$q->valor,
                'fechainicio' => $q->fechainicio,
                'fechafin' => $q->fechafin
              ];
                $arrato = [];
                $arrate = [
                'estado' => $q->estado,
                'avance' => $q->avance,
                'fecha' => $q->fechaavance,
                'observacion' => $q->observacion
              ];
                array_push($arrato,$arrate);
                $primera = false;
          }

          if(($idantactividad<>$q->idactividad)||($idantavance<>$q->idavance)){
               if($idantactividad<>$q->idactividad){
               $nivelcerrado = 2;
               $arregloactividad['avances'] = $arrato;
               $arrato = [];
               array_push($arreglo,$arregloactividad);
               $idantactividad = $q->idactividad;
               $idantavance = $q->idavance;
               $arregloactividad = [];
               $arregloactividad = [
                 'actividad' => $q->actividad,
                 'supervisor' => $q->usuario,
                 'duracion' => $q->duracion.' '.$q->valor,
                 'fechainicio' => $q->fechainicio,
                 'fechafin' => $q->fechafin,
               ];
               $arrato = [];
               $arrate = [
               'estado' => $q->estado,
               'avance' => $q->avance,
               'fecha' => $q->fechaavance,
               'observacion' => $q->observacion
             ];
               array_push($arrato,$arrate);
             }else if($idantavance<>$q->idavance){
               $nivelcerrado = 1;
               $idantavance = $q->idavance;
               $arrate = [
               'estado' => $q->estado,
               'avance' => $q->avance,
               'fecha' => $q->fechaavance,
               'observacion' => $q->observacion
              ];
               array_push($arrato,$arrate);
             }


             if($nivelcerrado==2){
               if(count($query)==$contotal){
                 $arregloactividad['avances'] = $arrato;
                 array_push($arreglo,$arregloactividad);
               }
             }
             if($nivelcerrado==1){
               if(count($query)==$contotal){
                 $arregloactividad['avances'] = $arrato;
                 array_push($arreglo,$arregloactividad);
               }
             }
          }
        }

        $data = [
          'fecha' => $fecha,
          'nombre' =>$proyecto->nombre,
          'supervisor' =>$proyecto->responsable->name,
          'duracion' =>$proyecto->duracion.' '.$proyecto->tiempo->valor.'(s)',
          'fechainicio' =>$proyecto->fechainicio,
          'fechafin' =>$proyecto->fechafin,
          'arreglo' => $arreglo
        ];
        //dd($arreglo);
        //return view('pdf.proyecto',$data);
       $pdf = PDF::loadView('pdf.proyecto',$data);
        return $pdf->stream('reporte.pdf');

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
       $pdf = PDF::loadView('pdf.proyectostotal',$data);
        return $pdf->stream('reporteproyectos.pdf');
        //return view('reportes.consolidado',compact('aconsulta','arrfecha'));
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
