<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\Prioridades;

class PrioridadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prioridades = Prioridades::all();
        return view('prioridades.index',compact('prioridades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('prioridades.create');
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
      'descripcion' => 'required',
      'peso' => 'required',
      'tiempo_limite' => 'required',
      'tiempo_alerta' => 'required',
      'tiempo_escala' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $prioridad = new Prioridades;
           $input = array_filter($data,'strlen');
           $prioridad->fill($input);
           $prioridad->save();
           Session::flash('message','Registro creado correctamente');
           return redirect()->action('PrioridadesController@index');
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
        $prioridad = Prioridades::find($id);
        return view('prioridades.edit',compact('prioridad'));
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
      'descripcion' => 'required',
      'peso' => 'required',
      'tiempo_limite' => 'required',
      'tiempo_alerta' => 'required',
      'tiempo_escala' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $prioridad = Prioridades::find($id);
           $input = array_filter($data,'strlen');
           $prioridad->fill($input);
           $prioridad->save();
           Session::flash('message','Registro editado correctamente');
           return redirect()->action('PrioridadesController@index');
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
      $prioridad = Prioridades::find($id);
      if(empty($prioridad))
      {
          Session::flash('message','Registro no encontrado');
          return redirect(route('prioridades.index'));
      }
      $prioridad->delete();


      Session::flash('message','Registro borrado sin problemas.');
      return redirect(route('prioridades.index'));
    }
}
