<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\TipoActividades;

class TipoActividadesController extends Controller
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
        $tactividades = TipoActividades::all();
        return view('tipoactividades.index',compact('tactividades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $referencia = DB::select("select id, valor from param_referenciales where grupo = 'General-Actividades' and clave = 'Tipo'
        and deleted_at is null");

        $arefer = [];
        foreach($referencia as $refer){
            $arefer[$refer->id] = $refer->valor;
        }

        return view('TipoActividades.create',compact('arefer'));
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
      'descripcion' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $tactividad = new TipoActividades;
           $input = array_filter($data,'strlen');
           $tactividad->fill($input);
           $tactividad->save();
           Session::flash('message','Registro creado correctamente');
           return redirect()->action('TipoActividadesController@index');
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
      $referencia = DB::select("select id, valor from param_referenciales where grupo = 'General-Actividades' and clave = 'Tipo'
      and deleted_at is null");

      $arefer = [];
      foreach($referencia as $refer){
          $arefer[$refer->id] = $refer->valor;
      }

      $tactividad = TipoActividades::find($id);

      return view('tipoactividades.edit',compact('arefer','tactividad'));
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
      'descripcion' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $tactividad = TipoActividades::find($id);
           $input = array_filter($data,'strlen');
           $tactividad->fill($input);
           $tactividad->save();
           Session::flash('message','Registro editado correctamente');
           return redirect()->action('TipoActividadesController@index');
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
      $tactividad = TipoActividades::find($id);
      if(empty($tactividad))
      {
          Session::flash('message','Registro no encontrado');
          return redirect(route('tipoactividades.index'));
      }
      $tactividad->delete();


      Session::flash('message','Registro borrado sin problemas.');
      return redirect(route('tipoactividades.index'));
    }
}
