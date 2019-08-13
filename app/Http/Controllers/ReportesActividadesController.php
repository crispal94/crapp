<?php

namespace App\Http\Controllers;

use App\Roles;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PDF;

class ReportesActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = getRole();

        $roleid = Roles::where('name', $role)->first();

        //$usuarios = User::all();
        //$
        $usuarios = DB::select("select u.id as id, u.name as usuario
      from users u
      inner join roles_tipo r on (r.id = u.id_roltipo)
      inner join roles ru on (ru.id = r.id_roles)
      where ru.title not in ('Supervisor','Administrador')");

        $arrusuarios = ['N' => 'Ingrese Dato'];

        foreach ($usuarios as $user) {
            $arrusuarios[$user->id] = $user->usuario;
        }

        $estado = ['N' => 'Todos', '1' => 'Activo', '2' => 'Finalizado', '3' => 'Incumplido'];

        $url = 'reportesactividades';
        $modulo = 'Reportes';
        $nombre = 'Actividad';

        return view('reportes_actividades.index', compact('arrusuarios', 'role', 'roleid', 'url', 'modulo', 'nombre', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getactividades()
    {
        $flag = Input::get('flag');
        $fechadesde = Input::get('fechadesde');
        $fechahasta = Input::get('fechahasta');
        $usuario = Input::get('usuario');
        $estado = Input::get('estado');

        $qbase = "select ta.descripcion as tipoactividad, ah.descripcion, sp_actividad.nombre, u.name as usuario, sp_actividad.duracion,
        sp_actividad.fechainicio, sp_actividad.id, pt.valor, sp_actividad.fechafin, sp_actividad.estado
        from sp_actividad
        inner join users as u on u.id  = sp_actividad.id_responsable
        left join param_referenciales as pt on pt.id = sp_actividad.id_refertiempo
        left join tipo_actividades as ta on ta.id = sp_actividad.id_tipoactividad
        left join actividades_horario as ah on ah.id = sp_actividad.id_actividad_horario
        where sp_actividad.deleted_at is null";

        if ($usuario != 'N') {
            $qbase .= " and sp_actividad.id_responsable = $usuario";
        }
        if ($estado != 'N') {
            $qbase .= " and sp_actividad.estado = $estado";
        }
        if ($flag == 0) {
            $qbase .= " and (sp_actividad.fechainicio BETWEEN '$fechadesde' and DATE_ADD('$fechahasta',INTERVAL 1 DAY))";
        }

        $query = DB::select($qbase);

        $arreglot = [];

        foreach ($query as $q) {
            $arr = [];
            $estado = $q->estado;
            switch ($estado) {
                case '3':
                    $estado = '<h3><span class="badge badge-danger">Incumplida</span></h3>';
                    break;

                case '2':
                    $estado = '<h3><span class="badge badge-success">Finalizada</span></h3>';
                    break;

                case '1':
                    $estado = '<h3><span class="badge badge-primary">En progreso</span></h3>';
                    break;
                    // case 'gris':
                    //     $estado = '<h3><span class="badge badge-secondary">Sin Actividad</span></h3>';
                    //     break;
            }
            array_push($arr, $estado);
            array_push($arr, $q->nombre);
            array_push($arr, $q->usuario);
            array_push($arr, $q->descripcion);
            array_push($arr, $q->duracion . ' ' . $q->valor . '(s)');
            array_push($arr, $q->fechainicio);
            array_push($arr, $q->fechafin);
            array_push($arr, $q->estado);
            array_push($arreglot, $arr);
        }

        return response()->json(['consulta' => $arreglot]);

    }

    public function imprimir(Request $request)
    {
        $arregloim = $request->input('adatai');
        $aconsulta = json_decode($arregloim);
        date_default_timezone_set('America/Bogota');
        $fecha = date("Y-m-d H:i:s");

        $data = [
            'fecha' => $fecha,
            'aconsulta' => $aconsulta,
        ];
        $pdf = PDF::loadView('pdf.actividadestotal', $data)->setPaper('a4')->setOrientation('landscape');
        return $pdf->stream('reporteactividadesSP.pdf');

    }
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
