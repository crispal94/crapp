<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\GrupoUsuarios;
use App\User;

class GrupoUsuariosController extends Controller
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
        $grupos = GrupoUsuarios::all();
        $url = 'grupousuarios';
        $modulo = '';
        $nombre = 'Grupos de Trabajos';

        return view('grupousuarios.index',compact('grupos','url','modulo','nombre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::all();
        $url = 'grupousuarios';
        $modulo = '';
        $nombre = 'Grupos de Trabajos';

        return view('grupousuarios.create',compact('usuarios','url','modulo','nombre'));
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
      $data = $request->all();
      $rules = array(
          'descripcion'=>'required',
       );

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $grupos = new GrupoUsuarios;
           $input = array_filter($data,'strlen');
           $grupos->fill($input);

           /*$lenusers = $request->lenusers;
            $datousers=';';
            for ($i=0; $i < $lenusers; $i++) {
                $contcheck = $i + 1;
                $palabra = 'checkbox_'.$contcheck;

                if($request->input($palabra)!="0"){
                    $id = $request->input($palabra);
                     $datousers.=$id.';';
                }
            }*/

           //dd($datousers);
           $grupos->nickname = $request->lennickname;
           $grupos->usuarios = $request->lenid;
           $grupos->save();
           Session::flash('message','Registro creado correctamente');
           return redirect()->action('GrupoUsuariosController@index');
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
      $grupo = GrupoUsuarios::find($id);
      $usuarios = User::all();
      $arrayidusers = explode(";",$grupo->usuarios);

      $arrayidusers = array_filter($arrayidusers, "strlen");

      $arrauidn = [];

      foreach ($arrayidusers as $key => $value) {
          array_push($arrauidn, $value);
      }
      $url = 'grupousuarios';
      $modulo = '';
      $nombre = 'Grupos de Trabajos';

      return view('grupousuarios.edit',compact('usuarios','grupo','arrauidn','url','modulo','nombre'));
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
      //dd($request);
      $data = $request->all();
      $rules = array(
          'descripcion'=>'required',
       );

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $grupos = GrupoUsuarios::find($id);
           $input = array_filter($data,'strlen');
           $grupos->fill($input);

           /*$lenusers = $request->lenusers;
            $datousers=';';
            for ($i=0; $i < $lenusers; $i++) {
                $contcheck = $i + 1;
                $palabra = 'checkbox_'.$contcheck;

                if($request->input($palabra)!="0"){
                    $id = $request->input($palabra);
                     $datousers.=$id.';';
                }
            }*/
           $grupos->nickname = $request->lennickname;
           $grupos->usuarios = $request->lenid;
           $grupos->save();
           Session::flash('message','Registro editado correctamente');
           return redirect()->action('GrupoUsuariosController@index');
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
      $grupo = GrupoUsuarios::find($id);
      if(empty($grupo))
      {
          Session::flash('message','Registro no encontrado');
          return redirect(route('grupousuarios.index'));
      }
      $grupo->delete();


      Session::flash('message','Registro borrado sin problemas.');
      return redirect(route('grupousuarios.index'));
    }
}
