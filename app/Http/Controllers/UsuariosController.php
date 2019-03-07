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
use App\RolesTipo;
use Bouncer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         //$this->middleware('auth');
     }

    public function index()
    {
      //$usuario = User::with('roles:description')->orderBy('id')->get();
      $usuarios = User::all();
      $url = 'usuarios';
      $modulo = 'Seguridad';
      $nombre = 'Usuarios';
      return view('usuarios.index',compact('usuarios','url','modulo','nombre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $qrol = DB::select("select id,nombre from roles_tipo where deleted_at is null");
       $arrol = [];
       foreach($qrol as $r){
           $arrol[$r->id] = $r->nombre;
       }
       $url = 'usuarios';
       $modulo = 'Seguridad';
       $nombre = 'Usuarios';

       return view('usuarios.create',compact('arrol','url','modulo','nombre'));
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
       //$roleId = $request->get('rol_id');
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
          'nickname' =>$data['nickname'],
          'password' => bcrypt($data['password']),
          'id_roltipo' => $data['id_roltipo']
          ]);

          $rolestipo = RolesTipo::find($data['id_roltipo']);
          switch ($rolestipo->tipo->title) {
            case 'Administrador':
              $user->assign('admin');
              break;

            case 'Supervisor':
              $user->assign('super');
              break;

            case 'Recurso':
              $user->assign('recur');
              break;
          }
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
        $qrol = DB::select("select id,nombre from roles_tipo where deleted_at is null");
        $arrol = [];
        foreach($qrol as $r){
            $arrol[$r->id] = $r->nombre;
        }
        /*$rolide = RolUser::where('user_id',$id)->first();
        $rolid = $rolide->role_id;*/
        $url = 'usuarios';
        $modulo = 'Seguridad';
        $nombre = 'Usuarios';
        return view('usuarios.edit',compact('usuario','arrol','rolid','pagina','url','modulo','nombre'));
    }

    public function perfil($id){
      $usuario = User::find($id);
      $qrol = DB::select("select id,nombre from roles_tipo where deleted_at is null");
      $arrol = [];
      foreach($qrol as $r){
          $arrol[$r->id] = $r->nombre;
      }
      /*$rolide = RolUser::where('user_id',$id)->first();
      $rolid = $rolide->role_id;*/
      $url = URL::current();//'usuarios';
      $modulo = '';
      $nombre = 'Perfil';
      return view('usuarios.perfil',compact('usuario','arrol','rolid','pagina','url','modulo','nombre'));

    }


    public function perfilpost(Request $request, $id)
    {
      $data = $request->all();
      $cpass = $request->get('cpass');
      $roleId = $request->get('id_roltipo');
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
          //$roluser = RolUser::where('user_id',$id)->first();
          $hashedPassword = $user->password;
          if($cpass!=null){
          if (Hash::check($pantigua, $hashedPassword)) {
              $user->name = $data['name'];
              $user->nickname = $data['nickname'];
              $user->password = bcrypt($data['password']);
              $user->save();
              //$user->roles()->attach($roleId);
              /*$roluser->user_id = $roleId;
              $roluser->save();*/
              Session::flash('message','Perfil editado correctamente');
              $user = Auth::user();
               if($user->isAn('admin')){
                  return redirect()->action('ProyectosController@index');
               }else if($user->isA('super')){
                 return redirect()->action('ActividadesController@index');
               }else if($user->isA('recur')){
                 return redirect()->action('AvancesController@index');
               }
              //return redirect()->action('HomeController@index');
          }else{
              Session::flash('error','Contraseña no coincide con el sistema');
              return redirect()->back()->withInput();
          }}else{
             $user->name = $data['name'];
             $user->nickname = $data['nickname'];
             $user->save();
            /*$roluser->role_id = $roleId;
            $roluser->save();*/
              Session::flash('message','Perfil editado correctamente');
              $user = Auth::user();
               if($user->isAn('admin')){
                  return redirect()->action('ProyectosController@index');
               }else if($user->isA('super')){
                 return redirect()->action('ActividadesController@index');
               }else if($user->isA('recur')){
                 return redirect()->action('AvancesController@index');
               }
              //return redirect()->action('HomeController@index');
          }
          }
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
      $roleId = $request->get('id_roltipo');
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
          //$roluser = RolUser::where('user_id',$id)->first();
          $hashedPassword = $user->password;
          if($cpass!=null){
          if (Hash::check($pantigua, $hashedPassword)) {
              $user->name = $data['name'];
              $user->nickname = $data['nickname'];
              $user->password = bcrypt($data['password']);
              $user->id_roltipo = $data['id_roltipo'];
              $user->save();
              //$user->roles()->attach($roleId);
              /*$roluser->user_id = $roleId;
              $roluser->save();*/
              Session::flash('message','Registro editado correctamente');
              return redirect()->action('UsuarioController@index');
          }else{
              Session::flash('error','Contraseña no coincide con el sistema');
              return redirect()->back()->withInput();
          }}else{
             $user->name = $data['name'];
             $user->nickname = $data['nickname'];
             $user->id_roltipo = $data['id_roltipo'];
             $rolestipo = RolesTipo::find($data['id_roltipo']);
             switch ($rolestipo->tipo->title) {
               case 'Administrador':
                 //$roles = Bouncer::role()->where('name','admin')->first();
                 Bouncer::sync($user)->roles('admin');
                 break;

               case 'Supervisor':
                 //$roles = Bouncer::role()->where('name','super')->first();
                 //dd($roles);
                 Bouncer::sync($user)->roles('super');
                 break;

               case 'Recurso':
               //$roles = Bouncer::role()->where('name','recur')->first();
                Bouncer::sync($user)->roles('recur');
                 break;
             }
             $user->save();
            /*$roluser->role_id = $roleId;
            $roluser->save();*/
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
