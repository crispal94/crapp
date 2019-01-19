<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\Prueba;
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
        return view('app');
    }

    public function email(){
      $to_name = 'Christian Palacios';
      $to_email = 'chrispalacios94@gmail.com';
      $data = array('name'=>"Sam Jose", "body" => "Test mail");

      Mail::to($to_email)->send(new Prueba($data));

      return 'enviado correo';
    }
}
