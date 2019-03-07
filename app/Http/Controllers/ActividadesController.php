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
use App\Prioridades;
use App\TipoActividades;

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
        $tipoactividades = TipoActividades::all();
        $prioridades = Prioridades::all();

        $arrproy = ['N'=>'Ingrese Dato'];
        foreach($proyectos as $pro){
          $arrproy[$pro->id] = $pro->nombre;
        }
        $tiempo = ParamReferenciales::where('grupo','Proyecto')->where('clave','Tiempo')->orderBy('id', 'asc')->get();

        $url = 'actividades';
        $modulo = '';
        $nombre = 'Actividades';

        foreach($tipoactividades as $t){
          $arrtipo[$t->id] = $t->descripcion;
        }

        foreach($prioridades as $p){
          $arrprioridad[$p->id] = $p->descripcion;
        }

        return view('actividades.index',compact('arrproy','tiempo','url','modulo','nombre','arrtipo','arrprioridad'));
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
      select det.id,det.nombre as actividad,ta.descripcion as tipoactividad, p.descripcion as prioridad, u.name as usuario,
      det.id_refertiempo, det.id_prioridad,det.id_tipoactividad,det.id_responsable,
      det.duracion, det.fechainicio, det.fechafin, pt.valor
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      left join prioridades p on (p.id = det.id_prioridad)
      left join tipo_actividades ta on (ta.id = det.id_tipoactividad)
      left join param_referenciales pt on (pt.id = det.id_refertiempo)
      where det.id_cabecera = ? and det.deleted_at is null
      order by det.fechainicio asc",[$idpro]);
      $arreglotd = [];
      foreach($actividades as $act){
        $arr = [];
        $botone = '<button class="btn btn-primary" id="editar">Editar</button>';
        array_push($arr,$botone);
        array_push($arr,$act->actividad);
        array_push($arr,$act->usuario);
        array_push($arr,$act->duracion.' '.$act->valor.'(s)');
        array_push($arr,$act->tipoactividad);
        array_push($arr,$act->prioridad);
        array_push($arr,$act->fechainicio);
        array_push($arr,$act->fechafin);
        array_push($arr,$act->id);
        array_push($arr,$act->id_refertiempo);
        array_push($arr,$act->id_prioridad);
        array_push($arr,$act->id_tipoactividad);
        array_push($arr,$act->duracion);
        array_push($arr,$act->id_responsable);
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
        $tipoactividad = Input::get('tipoactividad');
        $prioridad = Input::get('prioridad');
        $duracionact = Input::get('duracionact');
        $fechainicio = Input::get('fechainicio');
        $tiempo = Input::get('tiempo');
        $userid = Input::get('userid');
        $proyecto = Proyectos::find($idcabecera);
        $usuario = User::find($userid);
        $fechap = date("Y-m-d H:i:s", strtotime($fechainicio));
        $qtiempo = ParamReferenciales::find($tiempo);
        $tiempomail = '';
        switch ($qtiempo->valor) {
          case 'Hora':
            $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." hour"));
            $tiempomail = 'Hora(s)';
            break;

          case 'Día':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." day"));
          $tiempomail = 'Día(s)';
          break;

          case 'Semana':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." week"));
          $tiempomail = 'Semana(s)';
          break;

          case 'Mes':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." month"));
          $tiempomail = 'Mes(es)';
          break;

          case 'Año':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." year"));
          $tiempomail = 'Año(s)';
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
              $actividad->id_tipoactividad = $tipoactividad;
              $actividad->id_prioridad = $prioridad;
              $actividad->fechainicio = $fechainicio;
              $actividad->duracion = $duracionact;
              $actividad->id_refertiempo = $tiempo;
              $actividad->fechafin = $fechapf;
              $arregmail = [];
              array_push($arregmail,$usuario->name);
              array_push($arregmail,$proyecto->nombre);
              array_push($arregmail,$actividad->nombre);
              array_push($arregmail,$actividad->fechainicio);
              array_push($arregmail,$actividad->duracion);
              array_push($arregmail,$tiempomail);
              Mail::to($usuario->email)->send(new NotificaActividad($arregmail));
              $actividad->save();

           }

           $actividades = DB::select("
           select det.id, det.nombre as actividad, u.name as usuario, ta.descripcion as tipoactividad,
           det.id_refertiempo, det.id_prioridad,det.id_tipoactividad,det.id_responsable,
           p.descripcion as prioridad ,det.duracion, det.fechainicio, det.fechafin,det.fechafin,pt.valor
           from det_actividad det
           inner join users u on (u.id = det.id_responsable)
           left join prioridades p on (p.id = det.id_prioridad)
           left join tipo_actividades ta on (ta.id = det.id_tipoactividad)
           left join param_referenciales pt on (pt.id = det.id_refertiempo)
           where det.id_cabecera = ? and det.deleted_at is null
           order by det.fechainicio asc",[$idcabecera]);

           $arreglotd = [];
           foreach($actividades as $act){
             $arr = [];
             $botone = '<button class="btn btn-primary" id="editar">Editar</button>';
             array_push($arr,$botone);
             array_push($arr,$act->actividad);
             array_push($arr,$act->usuario);
             array_push($arr,$act->tipoactividad);
             array_push($arr,$act->prioridad);
             array_push($arr,$act->duracion.' '.$act->valor.'(s)');
             array_push($arr,$act->fechainicio);
             array_push($arr,$act->fechafin);
             array_push($arr,$act->id);
             array_push($arr,$act->id_refertiempo);
             array_push($arr,$act->id_prioridad);
             array_push($arr,$act->id_tipoactividad);
             array_push($arr,$act->duracion);
             array_push($arr,$act->id_responsable);
             array_push($arreglotd,$arr);
           }

            return response()->json(['flag'=>2,'mensaje'=>'Actividad ingresada y sincronizada con éxito','detalle'=>$arreglotd]);
        }else{
              $actividad = new Actividades;
              $actividad->id_cabecera = $idcabecera;
              $actividad->id_responsable = $userid;
              $actividad->nombre = $nombreact;
              $actividad->id_tipoactividad = $tipoactividad;
              $actividad->id_prioridad = $prioridad;
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
              array_push($arregmail,$tiempomail);
              Mail::to($usuario->email)->send(new NotificaActividad($arregmail));
              $actividad->save();

              $actividades = DB::select("
              select det.id, det.nombre as actividad, u.name as usuario,ta.descripcion as tipoactividad, p.descripcion as prioridad,
              det.id_refertiempo, det.id_prioridad,det.id_tipoactividad, det.id_responsable,
              det.duracion, det.fechainicio, det.fechafin,pt.valor
              from det_actividad det
              inner join users u on (u.id = det.id_responsable)
              left join prioridades p on (p.id = det.id_prioridad)
              left join tipo_actividades ta on (ta.id = det.id_tipoactividad)
              left join param_referenciales pt on (pt.id = det.id_refertiempo)
              where det.id_cabecera = ? and det.deleted_at is null
              order by det.fechainicio asc",[$idcabecera]);

              $arreglotd = [];
              foreach($actividades as $act){
                $arr = [];
                $botone = '<button class="btn btn-primary" id="editar">Editar</button>';
                array_push($arr,$botone);
                array_push($arr,$act->actividad);
                array_push($arr,$act->usuario);
                array_push($arr,$act->tipoactividad);
                array_push($arr,$act->prioridad);
                array_push($arr,$act->duracion.' '.$act->valor.'(s)');
                array_push($arr,$act->fechainicio);
                array_push($arr,$act->fechafin);
                array_push($arr,$act->id);
                array_push($arr,$act->id_refertiempo);
                array_push($arr,$act->id_prioridad);
                array_push($arr,$act->id_tipoactividad);
                array_push($arr,$act->duracion);
                array_push($arr,$act->id_responsable);
                array_push($arreglotd,$arr);
              }

              return response()->json(['flag'=>2,'mensaje'=>'Actividad ingresada y sincronizada con éxito','detalle'=>$arreglotd]);
          }
       }
    }


    public function editaractividad(Request $request){
        $idactividad = Input::get('idactividad');
        $tiporecurso = Input::get('tiporecurso');
        $idcabecera = Input::get('idcabecera');
        $nombreact = Input::get('nombreact');
        $tipoactividad = Input::get('tipoactividad');
        $prioridad = Input::get('prioridad');
        $duracionact = Input::get('duracionact');
        $fechainicio = Input::get('fechainicio');
        $tiempo = Input::get('tiempo');
        $userid = Input::get('userid');
        $proyecto = Proyectos::find($idcabecera);
        $usuario = User::find($userid);
        $fechap = date("Y-m-d H:i:s", strtotime($fechainicio));
        $qtiempo = ParamReferenciales::find($tiempo);
        $tiempomail = '';
        switch ($qtiempo->valor) {
          case 'Hora':
            $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." hour"));
            $tiempomail = 'Hora(s)';
            break;

          case 'Día':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." day"));
          $tiempomail = 'Día(s)';
          break;

          case 'Semana':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." week"));
          $tiempomail = 'Semana(s)';
          break;

          case 'Mes':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." month"));
          $tiempomail = 'Mes(es)';
          break;

          case 'Año':
          $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$duracionact." year"));
          $tiempomail = 'Año(s)';
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
              $actividad = Actividades::find($idactividad);
              $actividad->id_cabecera = $idcabecera;
              $actividad->id_responsable = $v;
              $actividad->nombre = $nombreact;
              $actividad->id_tipoactividad = $tipoactividad;
              $actividad->id_prioridad = $prioridad;
              $actividad->fechainicio = $fechainicio;
              $actividad->duracion = $duracionact;
              $actividad->id_refertiempo = $tiempo;
              $actividad->fechafin = $fechapf;
              $actividad->save();

           }

           $actividades = DB::select("
           select det.id, det.nombre as actividad, u.name as usuario, ta.descripcion as tipoactividad,
           det.id_refertiempo, det.id_prioridad,det.id_tipoactividad,det.id_responsable,
           p.descripcion as prioridad ,det.duracion, det.fechainicio, det.fechafin,det.fechafin,pt.valor
           from det_actividad det
           inner join users u on (u.id = det.id_responsable)
           left join prioridades p on (p.id = det.id_prioridad)
           left join tipo_actividades ta on (ta.id = det.id_tipoactividad)
           left join param_referenciales pt on (pt.id = det.id_refertiempo)
           where det.id_cabecera = ? and det.deleted_at is null
           order by det.fechainicio asc",[$idcabecera]);

           $arreglotd = [];
           foreach($actividades as $act){
             $arr = [];
             $botone = '<button class="btn btn-primary" id="editar">Editar</button>';
             array_push($arr,$botone);
             array_push($arr,$act->actividad);
             array_push($arr,$act->usuario);
             array_push($arr,$act->tipoactividad);
             array_push($arr,$act->prioridad);
             array_push($arr,$act->duracion.' '.$act->valor.'(s)');
             array_push($arr,$act->fechainicio);
             array_push($arr,$act->fechafin);
             array_push($arr,$act->id);
             array_push($arr,$act->id_refertiempo);
             array_push($arr,$act->id_prioridad);
             array_push($arr,$act->id_tipoactividad);
             array_push($arr,$act->duracion);
             array_push($arr,$act->id_responsable);
             array_push($arreglotd,$arr);
           }

            return response()->json(['flag'=>2,'mensaje'=>'Actividad editada y sincronizada con éxito','detalle'=>$arreglotd]);
        }else{
              $actividad = Actividades::find($idactividad);
              $actividad->id_cabecera = $idcabecera;
              $actividad->id_responsable = $userid;
              $actividad->nombre = $nombreact;
              $actividad->id_tipoactividad = $tipoactividad;
              $actividad->id_prioridad = $prioridad;
              $actividad->fechainicio = $fechainicio;
              $actividad->duracion = $duracionact;
              $actividad->id_refertiempo = $tiempo;
              $actividad->fechafin = $fechapf;
              $actividad->activo = 1;
              /*$arregmail = [];
              array_push($arregmail,$usuario->name);
              array_push($arregmail,$proyecto->nombre);
              array_push($arregmail,$actividad->nombre);
              array_push($arregmail,$actividad->fechainicio);
              array_push($arregmail,$actividad->duracion);
              array_push($arregmail,$tiempomail);
              Mail::to($usuario->email)->send(new NotificaActividad($arregmail));*/
              $actividad->save();

              $actividades = DB::select("
              select det.id, det.nombre as actividad, u.name as usuario,ta.descripcion as tipoactividad,
              det.id_refertiempo, det.id_prioridad,det.id_tipoactividad,det.id_responsable,
              p.descripcion as prioridad, det.duracion, det.fechainicio, det.fechafin,pt.valor
              from det_actividad det
              inner join users u on (u.id = det.id_responsable)
              left join prioridades p on (p.id = det.id_prioridad)
              left join tipo_actividades ta on (ta.id = det.id_tipoactividad)
              left join param_referenciales pt on (pt.id = det.id_refertiempo)
              where det.id_cabecera = ? and det.deleted_at is null
              order by det.fechainicio asc",[$idcabecera]);

              $arreglotd = [];
              foreach($actividades as $act){
                $arr = [];
                $botone = '<button class="btn btn-primary" id="editar">Editar</button>';
                array_push($arr,$botone);
                array_push($arr,$act->actividad);
                array_push($arr,$act->usuario);
                array_push($arr,$act->tipoactividad);
                array_push($arr,$act->prioridad);
                array_push($arr,$act->duracion.' '.$act->valor.'(s)');
                array_push($arr,$act->fechainicio);
                array_push($arr,$act->fechafin);
                array_push($arr,$act->id);
                array_push($arr,$act->id_refertiempo);
                array_push($arr,$act->id_prioridad);
                array_push($arr,$act->id_tipoactividad);
                array_push($arr,$act->duracion);
                array_push($arr,$act->id_responsable);
                array_push($arreglotd,$arr);
              }

              return response()->json(['flag'=>2,'mensaje'=>'Actividad editada y sincronizada con éxito','detalle'=>$arreglotd]);
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
