<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\Proyectos;
use Illuminate\Support\Facades\Input;

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
        us.name as responsable, cab.fechainicio as fechainicio, cab.fechafin as fechafin,
        CASE WHEN cab.id_user IS NOT NULL THEN u.name ELSE gt.descripcion END recursos
        from cab_actividad cab
        left join users u on (u.id = cab.id_user)
        left join users us on (us.id = cab.id_responsable)
        left join grupos_trabajos gt on (gt.id = cab.id_grupo)
        where cab.deleted_at is null");

        return view('proyectos.index',compact('proyectos'));
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
        inner join role_user ru on (ru.user_id = u.id)
        inner join roles r on (r.id = ru.role_id)
        inner join param_referenciales pr on (pr.id = r.id_param)
        where pr.valor = 'Supervisor'");

        $arrsupervisores = [];

        foreach($supervisores as $sus){
          $arrsupervisores[$sus->id] = $sus->usuario;
        }
        return view('proyectos.create',compact('arrsupervisores'));
    }

    public function getrecursos(Request $request){
      $vrecur = Input::get('vrecur');
      $arrgrecur = [];
      if($vrecur=='u'){
         $query = DB::select("select u.id as id, u.name as usuario
          from users u
          inner join role_user ru on (ru.user_id = u.id)
          inner join roles r on (r.id = ru.role_id)
          inner join param_referenciales pr on (pr.id = r.id_param)
          where pr.valor = 'Recurso'");
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
               $fechap = date("Y-m-d", strtotime($request->input('fechainicio')));
               $fechapf = date("Y-m-d",strtotime($fechap."+ ".$request->input('duracion')." week"));
               $proyecto->fechafin = $fechapf;
               $proyecto->id_responsable  = $data['supervisores'];
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
        inner join role_user ru on (ru.user_id = u.id)
        inner join roles r on (r.id = ru.role_id)
        inner join param_referenciales pr on (pr.id = r.id_param)
        where pr.valor = 'Supervisor'");

        $arrsupervisores = [];

        foreach($supervisores as $sus){
          $arrsupervisores[$sus->id] = $sus->usuario;
        }

        $vrecur = $proyecto->tipo_recurso;
        $arrgrecur = [];
        if($vrecur=='u'){
           $query = DB::select("select u.id as id, u.name as usuario
            from users u
            inner join role_user ru on (ru.user_id = u.id)
            inner join roles r on (r.id = ru.role_id)
            inner join param_referenciales pr on (pr.id = r.id_param)
            where pr.valor = 'Recurso'");
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
        return view('proyectos.edit',compact('arrsupervisores','proyecto','arrgrecur','rselect'));

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
           $fechap = date("Y-m-d", strtotime($request->input('fechainicio')));
           $fechapf = date("Y-m-d",strtotime($fechap."+ ".$request->input('duracion')." week"));
           $proyecto->fechafin = $fechapf;
           $proyecto->id_responsable  = $data['supervisores'];
           if($data['op_recursos']=='u'){
             $proyecto->id_user = $data['v_recursos'];
           }else{
             $proyecto->id_grupo = $data['v_recursos'];
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
