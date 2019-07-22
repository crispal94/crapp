<?php

namespace App\Http\Controllers;

use App\ActividadesSp;
use App\Horarios;
use App\TipoActividades;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Mail\NotificaActividadSp;
use Mail;



class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'horarios';
        $modulo = '';
        $nombre = 'Horarios';

        $arrgrecur = [];

        $query = DB::select("select u.id as id, u.name as usuario
         from users u
         inner join roles_tipo r on (r.id = u.id_roltipo)
         inner join roles ru on (ru.id = r.id_roles)
         where ru.title = 'Recurso' and r.id = 5");
        foreach ($query as $q) {
            $arrgrecur[$q->id] = $q->usuario;
        }
        $tipoactividades = TipoActividades::all();
        foreach ($tipoactividades as $t) {
            $arrtipo[$t->id] = $t->descripcion;
        }

        return view('horarios.index', compact('url', 'modulo', 'nombre', 'arrgrecur', 'arrtipo'));
    }

    public function gethorarios(Request $request)
    {
        $queryresp = DB::select('select u.name from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        group by ah.id_responsable');

        $queryhorario = DB::select("select u.name, DATE_FORMAT(ah.fechainicio, '%Y-%m-%d %H:%i') fechainicio,
        DATE_FORMAT(ah.fechafin, '%Y-%m-%d %H:%i') fechafin, ah.lugar, ah.id
        from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        where ah.deleted_at is null and
        (fechainicio >= CURDATE()
        AND fechainicio < CURDATE() + INTERVAL 1 DAY) and
        (fechafin >= CURDATE()
        AND fechafin < CURDATE() + INTERVAL 1 DAY)
        order by u.name,ah.fechainicio,ah.fechafin");

        $resp = [];
        foreach ($queryresp as $q) {
            array_push($resp, $q->name);
        }

        return response()->json(['responsables' => $resp, 'horarios' => $queryhorario]);
    }

    public function getHorarioId(Request $request)
    {
        $idHorario = Input::get('id');
        $queryIdHorario = DB::select("select u.name, fechainicio, fechafin, ah.lugar,
        ah.id idhorario, ta.id idtactividad, u.id iduser, ah.descripcion
        from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        inner join tipo_actividades ta on (ta.id = ah.id_tipoactividad)
        where ah.deleted_at is null and ah.id = ? and
        (fechainicio >= CURDATE()
        AND fechainicio < CURDATE() + INTERVAL 1 DAY) and
        (fechafin >= CURDATE()
        AND fechafin < CURDATE() + INTERVAL 1 DAY)
        order by u.name,ah.fechainicio,ah.fechafin", [$idHorario]);

        return response()->json(['flag' => 2, 'horario' => $queryIdHorario]);

    }

    public function ingresarhorario(Request $request)
    {
        $id_responsable = Input::get('id_responsable');
        $user = User::find($id_responsable);
        $id_tipoactividad = Input::get('id_tipoactividad');
        $lugar = Input::get('lugar');
        $descripcion = Input::get('descripcion');
        $fechainicio = Input::get('fechainicio');
        $duracion = Input::get('duracion');
        $fechafin = Input::get('fechafin');
        $usuario = User::find($id_responsable);

        $horario = new Horarios;
        $horario->id_responsable = $id_responsable;
        $horario->id_tipoactividad = $id_tipoactividad;
        $horario->lugar = $lugar;
        $horario->descripcion = $descripcion;
        $horario->fechainicio = $fechainicio;
        $horario->fechafin = $fechafin;
        $horario->save();

        $idHorario = $horario->id;

        $actividad = new ActividadesSp;
        $actividad->id_actividad_horario = $idHorario;
        $actividad->id_responsable = $id_responsable;
        $actividad->id_tipoactividad = $id_tipoactividad;
        $actividad->nombre = $lugar;
        $actividad->fechainicio = $fechainicio;
        $actividad->duracion = $duracion;
        $actividad->fechafin = $fechafin;
        $actividad->id_refertiempo = 12;

        $arregmail = [];
        array_push($arregmail, $usuario->name);
        array_push($arregmail, $actividad->nombre);
        array_push($arregmail, $actividad->fechainicio);
        array_push($arregmail, $actividad->duracion);
        array_push($arregmail, 'Hora(s)');
        Mail::to('albertopl20095@gmail.com')->send(new NotificaActividadSp($arregmail));

        $actividad->save();

        $queryhorario = DB::select("select u.name, DATE_FORMAT(ah.fechainicio, '%Y-%m-%d %H:%i') fechainicio,
        DATE_FORMAT(ah.fechafin, '%Y-%m-%d %H:%i') fechafin, ah.lugar, ah.id
        from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        where ah.deleted_at is null and
        (fechainicio >= CURDATE()
        AND fechainicio < CURDATE() + INTERVAL 1 DAY) and
        (fechafin >= CURDATE()
        AND fechafin < CURDATE() + INTERVAL 1 DAY)
        order by u.name,ah.fechainicio,ah.fechafin");

        $queryresp = DB::select('select u.name from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        group by ah.id_responsable');

        $resp = [];
        foreach ($queryresp as $q) {
            array_push($resp, $q->name);
        }

        return response()->json(['flag' => 2, 'horarios' => $queryhorario, 'responsables' => $resp, 'mensaje' => 'Actividad ingresada y sincronizada con éxito.']);
    }

    public function editarhorario(Request $request)
    {
        $idHorario = Input::get('idHorario');
        $id_responsable = Input::get('id_responsable');
        $user = User::find($id_responsable);
        $id_tipoactividad = Input::get('id_tipoactividad');
        $lugar = Input::get('lugar');
        $descripcion = Input::get('descripcion');
        $fechainicio = Input::get('fechainicio');
        $fechafin = Input::get('fechafin');
        $horario = Horarios::find($idHorario);
        $horario->id_responsable = $id_responsable;
        $horario->id_tipoactividad = $id_tipoactividad;
        $horario->lugar = $lugar;
        $horario->descripcion = $descripcion;
        $horario->fechainicio = $fechainicio;
        $horario->fechafin = $fechafin;
        $horario->save();

        $queryhorario = DB::select("select u.name, DATE_FORMAT(ah.fechainicio, '%Y-%m-%d %H:%i') fechainicio,
        DATE_FORMAT(ah.fechafin, '%Y-%m-%d %H:%i') fechafin, ah.lugar, ah.id
        from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        where ah.deleted_at is null and
        (fechainicio >= CURDATE()
        AND fechainicio < CURDATE() + INTERVAL 1 DAY) and
        (fechafin >= CURDATE()
        AND fechafin < CURDATE() + INTERVAL 1 DAY)
        order by u.name,ah.fechainicio,ah.fechafin");

        $queryresp = DB::select('select u.name from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        group by ah.id_responsable');

        $resp = [];
        foreach ($queryresp as $q) {
            array_push($resp, $q->name);
        }

        return response()->json(['flag' => 2, 'horarios' => $queryhorario, 'responsables' => $resp, 'mensaje' => 'Actividad Editada y sincronizada con éxito.']);
    }

    public function eliminarhorario(Request $request)
    {
        $idHorario = Input::get('idHorario');
        $horario = Horarios::find($idHorario)->delete();
        $queryhorario = DB::select("select u.name, DATE_FORMAT(ah.fechainicio, '%Y-%m-%d %H:%i') fechainicio,
        DATE_FORMAT(ah.fechafin, '%Y-%m-%d %H:%i') fechafin, ah.lugar, ah.id
        from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        where ah.deleted_at is null and
        (fechainicio >= CURDATE()
        AND fechainicio < CURDATE() + INTERVAL 1 DAY) and
        (fechafin >= CURDATE()
        AND fechafin < CURDATE() + INTERVAL 1 DAY)
        order by u.name,ah.fechainicio,ah.fechafin");

        $queryresp = DB::select('select u.name from actividades_horario ah
        inner join users u on (u.id = ah.id_responsable)
        group by ah.id_responsable');

        $resp = [];
        foreach ($queryresp as $q) {
            array_push($resp, $q->name);
        }

        return response()->json(['flag' => 2, 'horarios' => $queryhorario, 'responsables' => $resp, 'mensaje' => 'Actividad Eliminada con éxito.']);

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
