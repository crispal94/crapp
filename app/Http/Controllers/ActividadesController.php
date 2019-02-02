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
use App\Mail\NotificaActividad;
use Mail;
use App\ParamReferenciales;

class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$proyectos = Proyectos::all();
        $proyectos = getRoleProyectoQuery();
        $arrproy = ['N'=>'Ingrese Dato'];
        foreach($proyectos as $pro){
          $arrproy[$pro->id] = $pro->nombre;
        }
        $tiempo = ParamReferenciales::where('grupo','Proyecto')->where('clave','Tiempo')->orderBy('id', 'asc')->get();

        return view('actividades.index',compact('arrproy','tiempo'));
    }

    public function getproyectos(Request $request){
      $idpro = Input::get('idpro');
      $proyecto = Proyectos::find($idpro);
      $supervisor = $proyecto->responsable->name;
      $tiporecurso = $proyecto->tipo_recurso;
      $tiempo = $proyecto->tiempo->valor;
      $idtiempo = $proyecto->tiempo->id;
      $qtiempo = ParamReferenciales::where('grupo','Proyecto')->where('clave','Tiempo')->orderBy('id', 'asc')->get();
      $arrayflags = [];
      foreach($qtiempo as $t){
          if($t->id<=$idtiempo){
            array_push($arrayflags,1);
          }else{
            array_push($arrayflags,0);
          }
      }

      $actividades = DB::select("
      select det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin, pt.valor
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      left join param_referenciales pt on (pt.id = det.id_refertiempo)
      where det.id_cabecera = ? and det.deleted_at is null
      order by det.fechainicio asc",[$idpro]);
      $arreglotd = [];
      foreach($actividades as $act){
        $arr = [];
        array_push($arr,$act->actividad);
        array_push($arr,$act->usuario);
        array_push($arr,$act->duracion.' '.$act->valor.'(s)');
        array_push($arr,$act->fechainicio);
        array_push($arr,$act->fechafin);
        array_push($arreglotd,$arr);
      }
      if($tiporecurso=='gt'){
        $grupo = GrupoUsuarios::find($proyecto->id_grupo);
        $ids = $grupo->usuarios;
        $nids = str_replace(";", ",",$ids);
        $idf = trim($nids,',');
        $qid = '('.$idf.')';
        $usuarios = DB::select("select id, name, email from users where id in ".$qid." and deleted_at is null");
        $arreglot = [];
                foreach($usuarios as $us){
                    $arr2 = [];
                    $arr2['nombre'] = $us->name;
                    $arr2['email'] = $us->email;
                      $arr2['id'] = $us->id;
                    array_push($arreglot,$arr2);
                }
        return response()->json(['cont'=>$proyecto,'responsable'=>$supervisor,'tr'=>$tiporecurso,'usersa'=>$arreglot,'detalle'=>$arreglotd,'tiempo'=>$tiempo,'arrayflags'=>$arrayflags]);
      }else{
        $usuario = User::find($proyecto->id_user);
        $nombre = $usuario->name;
        $userid = $usuario->id;
          return response()->json(['cont'=>$proyecto,'responsable'=>$supervisor,'tr'=>$tiporecurso,'user'=>$nombre,'userid'=>$userid,'detalle'=>$arreglotd,'tiempo'=>$tiempo,'arrayflags'=>$arrayflags]);

      }

    }

    public function ingresaractividad(Request $request){
        $tiporecurso = Input::get('tiporecurso');
        $idcabecera = Input::get('idcabecera');
        $nombreact = Input::get('nombreact');
        $duracionact = Input::get('duracionact');
        $fechainicio = Input::get('fechainicio');
        $tiempo = Input::get('tiempo');
        $userid = Input::get('userid');
        $proyecto = Proyectos::find($idcabecera);
        $usuario = User::find($userid);
        $fechap = date("Y-m-d H:i:s", strtotime($fechainicio));
        $qtiempo = ParamReferenciales::find($tiempo);
        switch ($qtiempo->valor) {
          case 'Hora':
            $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." hour"));
            break;

          case 'Día':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." day"));
            break;

          case 'Semana':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." week"));
            break;

          case 'Mes':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." month"));
            break;

          case 'Año':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." year"));
            break;
        }

        $ffinalproyecto = strtotime($proyecto->fechafin);

        if(strtotime($fechapf)>$ffinalproyecto){
            return response()->json(['flag'=>1,'mensaje'=>'La fecha final de esta actividad supera la fecha final del proyecto, por favor cambie la duración de la actividad']);
        }else{
        if($tiporecurso=='gt'){
          $ids = Input::get('ids');
           $jids = json_decode($ids);
           foreach($jids->indiceid as $k=>$v){
              $actividad = new Actividades;
              $actividad->id_cabecera = $idcabecera;
              $actividad->id_responsable = $v;
              $actividad->nombre = $nombreact;
              $actividad->fechainicio = $fechainicio;
              $actividad->duracion = $duracionact;
              $actividad->id_refertiempo = $tiempo;
              $actividad->fechafin = $fechapf;
              $actividad->save();

           }

           $actividades = DB::select("
           select det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin,det.fechafin,pt.valor
           from det_actividad det
           inner join users u on (u.id = det.id_responsable)
           left join param_referenciales pt on (pt.id = det.id_refertiempo)
           where det.id_cabecera = ? and det.deleted_at is null
           order by det.fechainicio asc",[$idcabecera]);

           $arreglotd = [];
           foreach($actividades as $act){
             $arr = [];
             array_push($arr,$act->actividad);
             array_push($arr,$act->usuario);
             array_push($arr,$act->duracion.' '.$act->valor.'(s)');
             array_push($arr,$act->fechainicio);
             array_push($arr,$act->fechafin);
             array_push($arreglotd,$arr);
           }

            return response()->json(['flag'=>2,'mensaje'=>'Actividad Ingresada y Sincronizada con éxito','detalle'=>$arreglotd]);
        }else{
              $actividad = new Actividades;
              $actividad->id_cabecera = $idcabecera;
              $actividad->id_responsable = $userid;
              $actividad->nombre = $nombreact;
              $actividad->fechainicio = $fechainicio;
              $actividad->duracion = $duracionact;
              $actividad->id_refertiempo = $tiempo;
              $actividad->fechafin = $fechapf;
              $actividad->activo = 1;
              $arregmail = [];
              array_push($arregmail,$usuario->name);
              array_push($arregmail,$proyecto->nombre);
              array_push($arregmail,$actividad->nombre);
              array_push($arregmail,$actividad->fechainicio);
              array_push($arregmail,$actividad->duracion);

              //Mail::to('crispal94@hotmail.com')->send(new NotificaActividad($arregmail));
              $actividad->save();

              $actividades = DB::select("
              select det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin,pt.valor
              from det_actividad det
              inner join users u on (u.id = det.id_responsable)
              left join param_referenciales pt on (pt.id = det.id_refertiempo)
              where det.id_cabecera = ? and det.deleted_at is null
              order by det.fechainicio asc",[$idcabecera]);

              $arreglotd = [];
              foreach($actividades as $act){
                $arr = [];
                array_push($arr,$act->actividad);
                array_push($arr,$act->usuario);
                array_push($arr,$act->duracion.' '.$act->valor.'(s)');
                array_push($arr,$act->fechainicio);
                array_push($arr,$act->fechafin);
                array_push($arreglotd,$arr);
              }

              return response()->json(['flag'=>2,'mensaje'=>'Actividad Ingresada y Sincronizada con éxito','detalle'=>$arreglotd]);
          }
       }
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
