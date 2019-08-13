<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\Prueba;
use Bouncer;
use App\User;
use App\Proyectos;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
         if($user->isAn('admin')){
            return redirect()->action('HorariosController@index');
         }else if($user->isA('super')){
           return redirect()->action('ActividadesController@index');
         }else if($user->isA('recur')){
           return redirect()->action('ActividadesSpController@index');
         }
        //  return view('app');
        /*$administrador = Bouncer::is($user)->a('admin');
        dd($administrador);*/


        /*if($administrador){
          return 'es administrador';
        }else{
          return 'no es administrador';
        }*/


    }

    public function email(){
      $to_name = 'Christian Palacios';
      $to_email = 'crispal94@hotmail.com';
      $data = array('name'=>"Sam Jose", "body" => "Test mail");

      Mail::to($to_email)->send(new Prueba($data));

      return 'enviado correo';
    }


    public function crearoles(){

      /*  $super = Bouncer::role()->firstOrCreate([
        'name' => 'super',
        'title' => 'Supervisor',
        ]);
        $recur = Bouncer::role()->firstOrCreate([
        'name' => 'recur',
        'title' => 'Recurso',
      ]);*/

        /*$user = Auth::user();
        $f = Bouncer::is($user)->a('admin');
         Bouncer::allow('admin')->everything();
         $user = Auth::user();
        $user->allow('crear-proyecto', Proyectos::class);*/

        /*$user1 = User::find(7);
        $user1->assign('super');

        $user2 = User::find(9);
        $user2->assign('super');

        $user3 = User::find(10);
        $user3->assign('recur');

        $user4 = User::find(11);
        $user4->assign('super');

        $user5 = User::find(13);
        $user5->assign('super');*/

        return 'listo';


    }

    public function crearhabilidad(){
      /*$admin = Bouncer::role()->firstOrCreate([
      'name' => 'admin',
      'title' => 'Administrador',
      ]);

      $super = Bouncer::role()->firstOrCreate([
      'name' => 'super',
      'title' => 'Supervisor',
      ]);

      $recur = Bouncer::role()->firstOrCreate([
      'name' => 'recur',
      'title' => 'Recurso',
      ]);

      $cp = Bouncer::ability()->firstOrCreate([
      'name' => 'crear-proyecto',
      'title' => 'crear proyecto',
      ]);

      $ep = Bouncer::ability()->firstOrCreate([
      'name' => 'editar-proyecto',
      'title' => 'editar proyecto',
      ]);

      $bp = Bouncer::ability()->firstOrCreate([
      'name' => 'borrar-proyecto',
      'title' => 'borrar proyecto',
      ]);

      $bap = Bouncer::ability()->firstOrCreate([
      'name' => 'bajar-proyecto',
      'title' => 'bajar proyecto',
      ]);

      $cep = Bouncer::ability()->firstOrCreate([
      'name' => 'cerrar-proyecto',
      'title' => 'cerrar proyecto',
      ]);

      $ca = Bouncer::ability()->firstOrCreate([
      'name' => 'crear-actividad',
      'title' => 'crear actividad',
      ]);

      $cav = Bouncer::ability()->firstOrCreate([
      'name' => 'crear-avance',
      'title' => 'crear avance',
      ]);

      $mav = Bouncer::ability()->firstOrCreate([
      'name' => 'modificar-avance',
      'title' => 'modificar avance',
      ]);


      //HABILIDADES ROL Administrador
      Bouncer::allow($admin)->to($cp);
      Bouncer::allow($admin)->to($ep);
      Bouncer::allow($admin)->to($bp);
      Bouncer::allow($admin)->to($bap);
      Bouncer::allow($admin)->to($cep);
      Bouncer::allow($admin)->to($ca);
      Bouncer::allow($admin)->to($cav);
      Bouncer::allow($admin)->to($mav);

      //HABILIDADES ROL Supervisor
      Bouncer::allow($super)->to($ca);
      Bouncer::allow($super)->to($cav);
      Bouncer::allow($super)->to($mav);

      //HABILIDADES ROL Recurso
      Bouncer::allow($recur)->to($cav);
      Bouncer::allow($recur)->to($mav);*/

      /*$mantenimientos = Bouncer::ability()->firstOrCreate([
      'name' => 'mantenimientos-general',
      'title' => 'Mantenimientos Generales',
      ]);*/

      // $reportes = Bouncer::ability()->firstOrCreate([
      // 'name' => 'reportes',
      // 'title' => 'Reportes',
      // ]);

      // $super = Bouncer::role()->firstOrCreate([
      // 'name' => 'super',
      // 'title' => 'Supervisor',
      // ]);

      // Bouncer::allow($super)->to($reportes);

      $actividadesSp = Bouncer::ability()->firstOrCreate([
      'name' => 'actividades-sinplanificacion',
      'title' => 'Actividades Sin Planificación',
      ]);
      
      $horarios = Bouncer::ability()->firstOrCreate([
      'name' => 'horarios',
      'title' => 'Horarios',
      ]);

      $recur = Bouncer::role()->firstOrCreate([
      'name' => 'recur',
      'title' => 'Recurso',
      ]);

      Bouncer::disallow($recur)->to('horarios');


      //Bouncer::allow($recur)->to($actividadesSp);
      //Bouncer::allow($recur)->to($horarios);

     
      echo 'OK';


    }
}
