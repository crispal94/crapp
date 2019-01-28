<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Redirect;
use App\Estados;

class EstadosController extends Controller
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
       $estados = Estados::orderBy('id','asc')->get();
       return view('estados.index',compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $valor = $request->input('valor');
      $data = $request->all();
      var_dump($data);
      $rules = array(
      'descripcion' => 'required',
      'valor' =>'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $estado = new Estados;
           $input = array_filter($data,'strlen');
           $estado->fill($input);
           $estado->valor = $valor.'%';
           $estado->save();
           Session::flash('message','Registro creado correctamente');
           return redirect()->action('EstadosController@index');
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
        $estado = Estados::find($id);
        $valor = $estado->valor;
        $valor = trim($valor, '%');
        //dd($valor);
        return view('estados.edit',compact('estado','valor'));
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
      $valor = $request->input('valor');
      $data = $request->all();
      $rules = array(
      'descripcion' => 'required',
      'valor' =>'required');

       $v = Validator::make($data,$rules);
       if($v->fails())
       {
           return redirect()->back()
               ->withErrors($v->errors())
               ->withInput();
       }
       else{
           $estado = Estados::find($id);
           $input = array_filter($data,'strlen');
           $estado->fill($input);
           $estado->valor = $valor.'%';
           $estado->save();
           Session::flash('message','Registro editado correctamente');
           return redirect()->action('EstadosController@index');
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
      $estado = Estados::find($id);
      if(empty($estado))
      {
          Session::flash('message','Registro no encontrado');
          return redirect(route('estados.index'));
      }
      $estado->delete();


      Session::flash('message','Registro borrado sin problemas.');
      return redirect(route('estados.index'));
    }
}
