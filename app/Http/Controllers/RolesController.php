<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use Redirect;
use App\User;
use App\Roles;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::all();
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view ('roles.create');
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
       'nombre' => 'required');

      // $eliminado = Inv_Operador::onlyTrashed()->where('invope_cedula',$data['invope_cedula'])->get()->first();

    /*   if($eliminado){
          $cargo = ['C'=>'Camarógrafo','P'=>'Productor','R'=>'Reportero','A'=>'Asistente de Cámara'];
          $pagina = 'Operadores';
          return view('operador.activar',compact('eliminado','cargo','pagina'));
       }else{*/
       $v = Validator::make($data,$rules);
      if($v->fails())
      {
          return redirect()->back()
              ->withErrors($v->errors())
              ->withInput();
      }
      else{
          $rol = new Roles;
          $input = array_filter($data,'strlen');
          $rol->fill($input);
          $rol->save();
          Session::flash('message','Registro creado correctamente');
          return redirect()->action('RolesController@index');
          }
    //  }
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
