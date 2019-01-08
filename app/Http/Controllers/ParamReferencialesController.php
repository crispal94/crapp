<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\ParamReferenciales;

class ParamReferencialesController extends Controller
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
        $parametros = ParamReferenciales::all();
        return view('parametros.index',compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parametros.create');
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
      'grupo' => 'required',
      'clave' => 'required',
      'valor' => 'required',
      'descripcion' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $parametro = new ParamReferenciales;
           $input = array_filter($data,'strlen');
           $parametro->fill($input);
           $parametro->save();
           Session::flash('message','Registro creado correctamente');
           return redirect()->action('ParamReferencialesController@index');
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
        $parametro = ParamReferenciales::find($id);
        return view('parametros.edit',compact('parametro'));
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
      'valor' => 'required',
      'descripcion' => 'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $parametro = ParamReferenciales::find($id);
           $input = array_filter($data,'strlen');
           $parametro->fill($input);
           $parametro->save();
           Session::flash('message','Registro editado correctamente');
           return redirect()->action('ParamReferencialesController@index');
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
      $parametro = ParamReferenciales::find($id);
      if(empty($parametro))
      {
          Session::flash('message','Registro no encontrado');
          return redirect(route('parametros.index'));
      }
      $parametro->delete();


      Session::flash('message','Registro borrado sin problemas.');
      return redirect(route('parametros.index'));
    }
}
