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
use App\Novedades;
use App\Estados;
use Mail;
use App\Mail\NotificaAvance;
use Bouncer;
use Illuminate\Support\Facades\Auth;

class AvancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    public function index()
    {
      //dd($role);
      $proyectos = getRoleProyectoQuery();
      $arrproy = ['N'=>'Ingrese Dato'];
      foreach($proyectos as $pro){
        $arrproy[$pro->id] = $pro->nombre;
      }
      return view('avances.index',compact('arrproy'));
    }


    public function getproyectos(Request $request){
      $idpro = Input::get('idpro');
      $proyecto = Proyectos::find($idpro);
      $supervisor = $proyecto->responsable->name;
      $tiporecurso = $proyecto->tipo_recurso;
      $tiempo = $proyecto->tiempo->valor;
      $actividades = DB::select("
      select det.id, det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin, pt.valor, det.activo
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      left join param_referenciales pt on (pt.id = det.id_refertiempo)
      where det.id_cabecera = ? and det.deleted_at is null
      order by det.fechainicio asc",[$idpro]);
      $arreglotd = [];
      foreach($actividades as $act){
        $arr = [];
        $boton1 = '';
        $estadoact = 'Cerrado';
        if($act->activo==1){
        $boton1 = '<button type="button" class="btn btn-primary" id="seguimiento">Avances</button>';
        $estadoact = 'Activo';
        }
        array_push($arr,$boton1);
        array_push($arr,$act->actividad);
        array_push($arr,$act->usuario);
        array_push($arr,$act->duracion.' '.$act->valor.'(s)');
        array_push($arr,$act->fechainicio);
        array_push($arr,$act->fechafin);
        array_push($arr,$estadoact);
        array_push($arr,$act->id);
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
        return response()->json(['cont'=>$proyecto,'responsable'=>$supervisor,'tr'=>$tiporecurso,'usersa'=>$arreglot,'detalle'=>$arreglotd,'tiempo'=>$tiempo]);
      }else{
        $usuario = User::find($proyecto->id_user);
        $nombre = $usuario->name;
        $userid = $usuario->id;
          return response()->json(['cont'=>$proyecto,'responsable'=>$supervisor,'tr'=>$tiporecurso,'user'=>$nombre,'userid'=>$userid,'detalle'=>$arreglotd,'tiempo'=>$tiempo]);
      }
    }


    public function seguimiento($id,Request $request){

      $estados = Estados::all();

      $arrestados = [];

      /*foreach($estados as $est){
        $arrestados[$est->id] = $est->descripcion;
      }*/

      $actividad = DB::select("select det.id, det.nombre as actividad, u.name as usuario,
      det.duracion, det.fechainicio, det.fechafin,cab.nombre as proyecto
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      inner join cab_actividad cab on (cab.id = det.id_cabecera)
      where det.id = ? and det.deleted_at is null",[$id])[0];

      $avances = DB::select("select av.id, est.descripcion as estado, av.avance, av.fechaavance, av.observacion
        from seg_actividades av
        inner join estado est on (est.id = av.id_estado)
        where av.id_detalle = ? and av.deleted_at is null
        order by av.secuencial_avance",[$id]);

        $favance = Avances::where('avance','100%')->where('id_detalle',$id)->first();

        if($favance){
          $bloqueo = true;
        }else{
          $bloqueo = false;
        }

        return view('avances.mostrar',compact('actividad','avances','estados','bloqueo'));
    }

    public function postavance($id,Request $request){
       $estado = Input::get('estado');
       $avance = Input::get('avance');
       $observacion = Input::get('observacion');
       date_default_timezone_set('America/Bogota');
       $actividad = Actividades::find($id);

       $id_detalle = $actividad->id;
       $id_cabecera = $actividad->id_cabecera;

       $cavance = Avances::where('id_detalle',$id_detalle)->where('id_cabecera',$id_cabecera)->orderBy('id','desc')->limit(1)->first();

       if($cavance){
       $cvalor = trim($cavance->avance, '%');
     }else{
       $cvalor = 0;
     }

       if($avance<$cvalor){
         return response()->json(['flag'=>1,'mensaje'=>'El valor porcentual del avance es menor al ultimo ingresado, por favor elija un estado mayor al último ingresado']);
       }else{
         $secfinal = Avances::where('id_detalle',$id)->max('secuencial_avance');
         $nextsecuencial = $secfinal + 1;
         $segui = new Avances;
         $segui->id_cabecera = $id_cabecera;
         $segui->id_detalle = $id_detalle;
         $segui->id_estado = $estado;
         $segui->avance = $avance.'%';
         $actividad->ultavance = $segui->avance;
         $segui->secuencial_avance = $nextsecuencial;
         $segui->fechaavance =  date("Y-m-d H:i:s");
         $segui->observacion = $observacion;
         $proyecto = Proyectos::find($id_cabecera);
         $idusactividad = $actividad->id_responsable;
         $id_responsable = $proyecto->id_responsable;
         $usuariosupervisor = User::find($id_responsable);
         $usuarioactividad = User::find($idusactividad);
         $nsupervisor = $usuariosupervisor->name;
         $nresponsable = $usuarioactividad->name;
         $estado = Estados::find($estado);
         $arregmail = [];
         array_push($arregmail,$nsupervisor);
         array_push($arregmail,$actividad->nombre);
         array_push($arregmail,$nresponsable);
         array_push($arregmail,$estado->descripcion);
         array_push($arregmail,$segui->avance);
         array_push($arregmail,$segui->fechaavance);
        // Mail::to('crispal94@hotmail.com')->send(new NotificaAvance($arregmail));
         if($segui->avance=='100%'){
           $actividad->activo = 0;
         }
         $actividad->fecha_ultavance = date("Y-m-d H:i:s");
         $actividad->save();
         $segui->save();

         return response()->json(['flag'=>2,'mensaje'=>'Avance ingresado correctamente']);
       }

       /**/

    }


    public function editar($id,$idavance){
        $estados = Estados::all();
        return view ('avances.editar',compact('estados'));
    }

    public function editaravance($id,Request $request){
      $estado = Input::get('estado');
      $avance = Input::get('avance');
      $observacion = Input::get('observacion');
      $idavance = Input::get('idavance');
      date_default_timezone_set('America/Bogota');
      $actividad = Actividades::find($id);

      $id_detalle = $actividad->id;
      $id_cabecera = $actividad->id_cabecera;

      /*$cavance = Avances::where('id_detalle',$id_detalle)->where('id_cabecera',$id_cabecera)->orderBy('id','desc')->limit(1)->first();
      $cvalor = trim($cavance->avance, '%');
      if($avance<=$cvalor){
        return response()->json(['flag'=>1,'mensaje'=>'El valor porcentual del avance es menor al ultimo ingresado, por favor elija un estado mayor al último ingresado']);
      }else{
      }*/

      $eavance = Avances::find($idavance);
      $secavance = $eavance->secuencial_avance;
      if($secavance!=1){
      $secavanceant = $secavance - 1;
      }else{
      $secavanceant = $secavance;
      }


      $avanceant = Avances::where('id_detalle',$id)->where('secuencial_avance',$secavanceant)->first();

      $vavanceant = trim($avanceant->avance,'%');


      if(($avance<=$vavanceant)&&($secavanceant>=1)){
      return response()->json(['flag'=>1,'mensaje'=>'Inconsistencia al modificar el avance por favor corrija los errores']);
      }else{
      $valorant = $eavance->avance;
      $estadoant = $eavance->id_estado;
      $fechaant = $eavance->fechaavance;
      $observacionant = $eavance->observacion;
      $eavance->id_estado = $estado;
      $eavance->avance = $avance.'%';
      $eavance->fechaavance = date("Y-m-d H:i:s");
      $eavance->observacion = $observacion;
      if($eavance->avance=='100%'){
        $actividad->activo = 0;

      }
      $actividad->ultavance = $avance.'%';
      $actividad->fecha_ultavance = date("Y-m-d H:i:s");
      $actividad->save();
      $eavance->save();

      $novedades = new Novedades;
      $novedades->id_avance = $idavance;
      $novedades->id_actividad = $id;
      $novedades->estado_nuevo = $eavance->avance;
      $novedades->estado_anterior = $valorant;
      $novedades->estado_nuevo = $eavance->avance;
      $novedades->observacion_nuevo = $observacion;
      $novedades->observacion_anterior = $observacionant;
      $novedades->fecha_anterior = $fechaant;
      $novedades->fecha_nuevo = $eavance->fechaavance;
      $novedades->save();


      $avances = DB::select("select av.id, est.descripcion as estado, av.avance, av.fechaavance, av.observacion
        from seg_actividades av
        inner join estado est on (est.id = av.id_estado)
        where av.id_detalle = ? and av.deleted_at is null
        order by av.secuencial_avance",[$id]);

        $arregloav = [];
        foreach($avances as $act){
          $arr = [];
          if($act->avance!='20%'){
            $td = '<button type="button" class="btn btn-primary centeralg" id="editar">Modificar</button>';
          }else{
            $td = '';
          }
          array_push($arr,$td);
          array_push($arr,$act->estado);
          array_push($arr,$act->avance);
          array_push($arr,$act->fechaavance);
          array_push($arr,$act->observacion);
          array_push($arr,$act->id);
          array_push($arregloav,$arr);
        }

       return response()->json(['flag'=>2,'mensaje'=>'Cambio realizado con éxito!','detalle'=>$arregloav]);
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
