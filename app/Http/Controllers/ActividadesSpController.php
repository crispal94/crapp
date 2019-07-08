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
            ->select('ta.descripcion as tipoactividad', 'sp_actividad.nombre', 'u.name as usuario', 'sp_actividad.duracion', 'sp_actividad.fechainicio', 'sp_actividad.id', 'pt.valor')
            ->join('users as u', 'u.id', '=', 'sp_actividad.id_responsable')
            ->leftJoin('param_referenciales as pt', 'pt.id', '=', 'sp_actividad.id_refertiempo')
            ->leftJoin('tipo_actividades as ta', 'ta.id', '=', 'sp_actividad.id_tipoactividad')
            ->whereNull('sp_actividad.deleted_at')
            ->where('sp_actividad.id_responsable', Auth::id())
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
        $tiempo = ParamReferenciales::where('grupo', 'Proyecto')->where('clave', 'Tiempo')->orderBy('id', 'asc')->get();
        foreach ($tipoactividades as $t) {
            $arrtipo[$t->id] = $t->descripcion;
        }
        $url = 'spactividades';
        $modulo = '';
        $nombre = 'Actividades sin Planificación';

        return view('sp_actividades.create', compact('arrtipo', 'tiempo', 'url', 'modulo', 'nombre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $actividad = new ActividadesSp;
        $actividad->id_responsable = Auth::id();
        $actividad->id_tipoactividad = $request->tipoactividad;
        $actividad->nombre = $request->nombreact;
        $actividad->fechainicio = $request->fechainicio;
        $actividad->duracion = $request->duracion;
        $actividad->id_refertiempo = $request->tiempo;
        $actividad->save();
        Session::flash('message', 'Registro creado correctamente');
        return redirect()->action('ActividadesSpController@index');
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
        $tiempo = ParamReferenciales::where('grupo', 'Proyecto')->where('clave', 'Tiempo')->orderBy('id', 'asc')->get();
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
}
