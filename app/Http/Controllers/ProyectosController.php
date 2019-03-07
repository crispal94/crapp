<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\Proyectos;
use App\Historia;
use App\Mail\NotificaProyecto;
use App\User;
use Mail;
use Illuminate\Support\Facades\Input;
use App\ParamReferenciales;

class ProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = DB::select("select cab.id as id, cab.nombre as nombre, cab.descripcion as descripcion, cab.duracion as duracion,
        us.name as responsable, cab.fechainicio as fechainicio, cab.fechafin as fechafin, pt.valor as tiempo,
        CASE WHEN cab.id_user IS NOT NULL THEN u.name ELSE gt.descripcion END recursos
        from cab_actividad cab
        left join users u on (u.id = cab.id_user)
        left join users us on (us.id = cab.id_responsable)
        left join grupos_trabajos gt on (gt.id = cab.id_grupo)
        left join param_referenciales pt on (pt.id = cab.id_refertiempo)
        where cab.deleted_at is null and cab.activo = 1");
        $url = 'proyectos';
        $modulo = '';
        $nombre = 'Proyectos';
        return view('proyectos.index',compact('proyectos','url','modulo','nombre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisores = DB::select("select u.id as id, u.name as usuario
        from users u
        inner join roles_tipo r on (r.id = u.id_roltipo)
        inner join roles ru on (ru.id = r.id_roles)
        where ru.title = 'Supervisor' or ru.title ='Administrador'");

        $arrsupervisores = [];

        foreach($supervisores as $sus){
          $arrsupervisores[$sus->id] = $sus->usuario;
        }

        $tiempo = ParamReferenciales::where('grupo','Proyecto')->where('clave','Tiempo')->get();

      /*  $arrtiempo = [];

        foreach($tiempo as $t){
          $arrtiempo[$t->id] = $t->valor;
        }*/
        $url = 'proyectos';
        $modulo = '';
        $nombre = 'Proyectos';

        return view('proyectos.create',compact('arrsupervisores','tiempo','url','modulo','nombre'));
    }

    public function getrecursos(Request $request){
      $vrecur = Input::get('vrecur');
      $arrgrecur = [];
      if($vrecur=='u'){
         $query = DB::select("select u.id as id, u.name as usuario
         from users u
         inner join roles_tipo r on (r.id = u.id_roltipo)
         inner join roles ru on (ru.id = r.id_roles)
         where ru.title = 'Recurso'");
         foreach($query as $q){
            $arrgrecur[$q->id] = $q->usuario;
          }
          return response()->json(['cont'=>$arrgrecur]);

      }else{
         $query = DB::select("select id, descripcion from grupos_trabajos where deleted_at is null");
         foreach($query as $q){
           $arrgrecur[$q->id] = $q->descripcion;
         }
           return response()->json(['cont'=>$arrgrecur]);
         }
    }


    public function bajaproyecto(Request $request){
      date_default_timezone_set('America/Bogota');
      $observacion = Input::get('observacion');
      $idproyecto = Input::get('idproyecto');
      $tipo = Input::get('tipo');
      $actividades = Proyectos::find($idproyecto)->actividades;

      foreach($actividades as $actividad){
        $avances = $actividad->avances;
        foreach($avances as $avance){
          $avance->delete();
        }
        $actividad->activo = 0;
        $actividad->save();
        $actividad->delete();
      }

      $proyecto = Proyectos::find($idproyecto);
      $proyecto->activo = 0;
      switch ($tipo) {
        case 'c':
          $proyecto->fecha_completo = date('Y-m-d H:i:s');
          $historia = new Historia;
          $historia->id_cabecera = $idproyecto;
          $historia->tipo = 'Completo';
          $historia->fechahistoria = date('Y-m-d H:i:s');
          $historia->observacion = 'Proyecto Completo 100%';
          $historia->save();
          break;

        case 'b':
          $proyecto->fecha_baja = date('Y-m-d H:i:s');
          $historia = new Historia;
          $historia->id_cabecera = $idproyecto;
          $historia->tipo = 'Baja';
          $historia->fechahistoria = date('Y-m-d H:i:s');
          $historia->observacion = $observacion;
          $historia->save();
      }
      $proyecto->save();
      $proyecto->delete();

      return response()->json(['flag'=>2,'mensaje'=>'Proceso realizado con éxito!']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $data = $request->all();
          $rules = array(
          'nombre' => 'required',
          'descripcion' => 'required',
          'duracion' => 'required',
          'v_recursos' => 'required');

           $v = Validator::make($data,$rules);
           if($v->fails())
           {
               return redirect()->back()
                   ->withErrors($v->errors())
                   ->withInput();
           }
           else{
               $proyecto = new Proyectos;
               $proyecto->nombre = $data['nombre'];
               $proyecto->descripcion = $data['descripcion'];
               $proyecto->duracion = $data['duracion'];
               $proyecto->fechainicio = $data['fechainicio'];
               $proyecto->id_refertiempo = $data['tiempo'];
               $proyecto->activo = 1;
               $fechap = date("Y-m-d H:i:s", strtotime($request->input('fechainicio')));
               $qtiempo = ParamReferenciales::find($data['tiempo']);
               $tiempomail = '';
               switch ($qtiempo->valor) {
                 case 'Hora':
                   $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." hour"));
                   $tiempomail = 'Hora(s)';
                   break;

                 case 'Día':
                 $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." day"));
                    $tiempomail = 'Día(s)';
                   break;

                 case 'Semana':
                 $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." week"));
                 $tiempomail = 'Semana(s)';
                   break;

                 case 'Mes':
                 $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." month"));
                 $tiempomail = 'Mes(es)';
                   break;

                 case 'Año':
                 $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." year"));
                 $tiempomail = 'Año(s)';
                   break;
               }

               //$fechapf = date("Y-m-d",strtotime($fechap."+ ".$request->input('duracion')." week"));
               $proyecto->fechafin = $fechapf;
               $proyecto->id_responsable  = $data['supervisores'];
               $proyecto->notifica = $data['notifica'];
               if($proyecto->notifica=='s'&&$data['op_recursos']=='u'){
                 $arregmail = [];
                 $usuario = User::find($data['v_recursos']);
                 array_push($arregmail,$usuario->name);
                 array_push($arregmail,$data['nombre']);
                 $supervisores = DB::select("select u.id as id, u.name as usuario
                 from users u
                 inner join roles_tipo r on (r.id = u.id_roltipo)
                 inner join roles ru on (ru.id = r.id_roles)
                 where ru.title = 'Supervisor' and u.id = ? and u.deleted_at is null",[$data['supervisores']])[0];
                 array_push($arregmail,$supervisores->usuario);
                 array_push($arregmail,$data['descripcion']);
                 array_push($arregmail,$data['fechainicio']);
                 array_push($arregmail,$data['duracion']);
                 array_push($arregmail,$tiempomail);
                 Mail::to($usuario->email)->send(new NotificaProyecto($arregmail));
               }
               if($data['op_recursos']=='u'){
                 $proyecto->id_user = $data['v_recursos'];
               }else{
                 $proyecto->id_grupo = $data['v_recursos'];
               }
               $proyecto->tipo_recurso = $data['op_recursos'];
               $proyecto->save();
               Session::flash('message','Registro creado correctamente');
               return redirect()->action('ProyectosController@index');
             }
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
        $proyecto=Proyectos::find($id);
        $supervisores = DB::select("select u.id as id, u.name as usuario
        from users u
        inner join roles_tipo r on (r.id = u.id_roltipo)
        inner join roles ru on (ru.id = r.id_roles)
        where ru.title = 'Supervisor' or ru.title ='Administrador'");

        $arrsupervisores = [];

        foreach($supervisores as $sus){
          $arrsupervisores[$sus->id] = $sus->usuario;
        }

        $vrecur = $proyecto->tipo_recurso;
        $arrgrecur = [];
        $tiempo = ParamReferenciales::where('grupo','Proyecto')->where('clave','Tiempo')->get();
        if($vrecur=='u'){
           $query = DB::select("select u.id as id, u.name as usuario
           from users u
           inner join roles_tipo r on (r.id = u.id_roltipo)
           inner join roles ru on (ru.id = r.id_roles)
           where ru.title = 'Recurso'");
           foreach($query as $q){
              $arrgrecur[$q->id] = $q->usuario;
            }
            $rselect = $proyecto->id_user;
        }else{
           $query = DB::select("select id, descripcion from grupos_trabajos where deleted_at is null");
           foreach($query as $q){
             $arrgrecur[$q->id] = $q->descripcion;
           }
             $rselect = $proyecto->id_grupo;
           }
      //  dd($arrgrecur);
      $url = 'proyectos';
      $modulo = '';
      $nombre = 'Proyectos';

        return view('proyectos.edit',compact('arrsupervisores','proyecto','arrgrecur','rselect','tiempo','url','modulo','nombre'));

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
      $data = $request->all();
      $rules = array(
      'nombre' => 'required',
      'descripcion' => 'required',
      'duracion' => 'required',
      'v_recursos' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $proyecto = Proyectos::find($id);
           $proyecto->nombre = $data['nombre'];
           $proyecto->descripcion = $data['descripcion'];
           $proyecto->duracion = $data['duracion'];
           $proyecto->fechainicio = $data['fechainicio'];
           $proyecto->id_refertiempo = $data['tiempo'];
           $fechap = date("Y-m-d", strtotime($request->input('fechainicio')));
           $fechap = date("Y-m-d H:i:s", strtotime($request->input('fechainicio')));
           $qtiempo = ParamReferenciales::find($data['tiempo']);
           switch ($qtiempo->valor) {
             case 'Hora':
               $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." hour"));
               break;

             case 'Día':
             $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." day"));
               break;

             case 'Semana':
             $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." week"));
               break;

             case 'Mes':
             $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." month"));
               break;

             case 'Año':
             $fechapf = date("Y-m-d H:i:s",strtotime($fechap."+ ".$data['duracion']." year"));
               break;
           }
           //$fechapf = date("Y-m-d",strtotime($fechap."+ ".$request->input('duracion')." week"));
           $proyecto->fechafin = $fechapf;
           $proyecto->id_responsable  = $data['supervisores'];
           if($data['op_recursos']=='u'){
             $proyecto->id_user = $data['v_recursos'];
             $proyecto->id_grupo = null;
           }else{
             $proyecto->id_grupo = $data['v_recursos'];
             $proyecto->id_user = null;
           }
           $proyecto->tipo_recurso = $data['op_recursos'];
           $proyecto->save();
           Session::flash('message','Registro editado correctamente');
           return redirect()->action('ProyectosController@index');
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $proyecto = Proyectos::find($id);
      if(empty($proyecto))
      {
          Session::flash('message','Registro no encontrado');
          return redirect(route('proyectos.index'));
      }
      $proyecto->delete();


      Session::flash('message','Registro borrado sin problemas.');
      return redirect(route('proyectos.index'));
    }
}
