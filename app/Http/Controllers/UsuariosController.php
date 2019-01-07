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
use App\RolUser;

class UsuariosController extends Controller
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
      //$usuario = User::with('roles:description')->orderBy('id')->get();
      $usuarios = User::all();
      return view('usuarios.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $qrol = DB::select("select id,nombre from roles where deleted_at is null");
       $arrol = [];
       foreach($qrol as $r){
           $arrol[$r->id] = $r->nombre;
       }
       return view('usuarios.create',compact('arrol'));
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
       $roleId = $request->get('rol_id');
       $rules = array(
       'name' => 'required|string|max:255',
       'email' => 'required|string|email|max:255|unique:users',
       'password' => 'required|string|min:1|confirmed');

       //|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/

       $v = Validator::make($data,$rules);
      if($v->fails())
      {
          return redirect()->back()
              ->withErrors($v->errors())
              ->withInput();
      }
      else{
          $user = User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
          ]);
          $user->roles()->attach($roleId);
          Session::flash('message','Registro creado correctamente');
          return redirect()->action('UsuariosController@index');
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
        $usuario = User::find($id);
        $qrol = DB::select("select id,nombre from roles where deleted_at is null");
        $arrol = [];
        foreach($qrol as $r){
            $arrol[$r->id] = $r->nombre;
        }
        $rolide = RolUser::where('user_id',$id)->first();
        $rolid = $rolide->role_id;
        return view('usuarios.edit',compact('usuario','arrol','rolid','pagina'));
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
      $cpass = $request->get('cpass');
      $roleId = $request->get('rol_id');
      if($cpass!=null){
       $rules = array(
       'name' => 'required|string|max:255',
       'password' => 'required|string|min:1|confirmed');
       }else{
        $rules = array(
       'name' => 'required|string|max:255');
       }

       $v = Validator::make($data,$rules);
      if($v->fails())
      {
          return redirect()->back()
              ->withErrors($v->errors())
              ->withInput();
      }
      else{
          $pantigua = $request->get('password_old');
          $user = User::find($id);
         $roluser = RolUser::where('user_id',$id)->first();
          $hashedPassword = $user->password;
          if($cpass!=null){
          if (Hash::check($pantigua, $hashedPassword)) {
              $user->name = $data['name'];
              $user->password = bcrypt($data['password']);
              $user->save();
              $user->roles()->attach($roleId);
              $roluser->user_id = $roleId;
              $roluser->save();
              Session::flash('message','Registro editado correctamente');
              return redirect()->action('UsuarioController@index');
          }else{
              Session::flash('error','Contraseña no coincide con el sistema');
              return redirect()->back()->withInput();
          }}else{
             $user->name = $data['name'];
             $user->save();
             $roluser->role_id = $roleId;
            $roluser->save();
              Session::flash('message','Registro editado correctamente');
              return redirect()->action('UsuariosController@index');
          }
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
      $usuario = User::find($id);
    if(empty($usuario))
    {
        Session::flash('message','Registro no encontrado');
        return redirect(route('usuarios.index'));
    }
    $usuario->delete();


    Session::flash('message','Registro borrado sin problemas.');
    return redirect(route('usuarios.index'));
    }
}
