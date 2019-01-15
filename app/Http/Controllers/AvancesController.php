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


class AvancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $proyectos = Proyectos::all();
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
      $actividades = DB::select("
      select det.id, det.nombre as actividad, u.name as usuario, det.duracion, det.fechainicio, det.fechafin
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      where det.id_cabecera = ? and det.deleted_at is null
      order by det.fechainicio asc",[$idpro]);
      $arreglotd = [];
      foreach($actividades as $act){
        $arr = [];
        $boton1 = '<button type="button" class="btn btn-primary" id="seguimiento">Avances</button>';
        array_push($arr,$boton1);
        array_push($arr,$act->actividad);
        array_push($arr,$act->usuario);
        array_push($arr,$act->duracion);
        array_push($arr,$act->fechainicio);
        array_push($arr,$act->fechafin);
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
        return response()->json(['cont'=>$proyecto,'responsable'=>$supervisor,'tr'=>$tiporecurso,'usersa'=>$arreglot,'detalle'=>$arreglotd]);
      }else{
        $usuario = User::find($proyecto->id_user);
        $nombre = $usuario->name;
        $userid = $usuario->id;
          return response()->json(['cont'=>$proyecto,'responsable'=>$supervisor,'tr'=>$tiporecurso,'user'=>$nombre,'userid'=>$userid,'detalle'=>$arreglotd]);
      }
    }


    public function seguimiento($id,Request $request){

      $estados = Estados::all();

      $arrestados = [];

      foreach($estados as $est){
        $arrestados[$est->id] = $est->descripcion;
      }

      $actividad = DB::select("select det.id, det.nombre as actividad, u.name as usuario,
      det.duracion, det.fechainicio, det.fechafin,cab.nombre as proyecto
      from det_actividad det
      inner join users u on (u.id = det.id_responsable)
      inner join cab_actividad cab on (cab.id = det.id_cabecera)
      where det.id = ? and det.deleted_at is null",[$id])[0];

      $avances = DB::select("select est.descripcion as estado, av.avance, av.fechaavance, av.observacion
        from seg_actividades av
        inner join estado est on (est.id = av.id_estado)
        where av.id_detalle = ? and av.deleted_at is null",[$id]);

        return view('avances.mostrar',compact('actividad','avances','arrestados'));
    }

    public function postavance($id,Request $request){
       $estado = Input::get('estado');
       $avance = Input::get('avance');
       $observacion = Input::get('observacion');
       date_default_timezone_set('America/Bogota');
       $actividad = Actividades::find($id);

       $id_detalle = $actividad->id;
       $id_cabecera = $actividad->id_cabecera;

       $segui = new Avances;
       $segui->id_cabecera = $id_cabecera;
       $segui->id_detalle = $id_detalle;
       $segui->id_estado = $estado;
       $segui->avance = $avance.'%';
       $segui->fechaavance =  date("Y-m-d H:i:s");
       $segui->observacion = $observacion;
       $segui->save();
       return response()->json(['mensaje'=>1]);

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
