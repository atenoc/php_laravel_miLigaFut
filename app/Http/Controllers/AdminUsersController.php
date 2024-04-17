<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;   //importamos el modelo User
use App\Foto; //importar el modelo Foto
use App\Liga;
use Auth;
use Log;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  /*Agreganos el constructor para incluir este controlador a la Sesión*/
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

      $users=User::all();

      //Antes de devolver la vista, recuperar los datos de la BD*/

      //$users = User::select('users')
        //    ->leftJoin('ligas', 'ligas.id', '=', 'users.id')
        //    ->select('users.*', 'ligas.nombre_liga')
        //    ->get();

      return view('admin.users.index', compact('users'));
      //return $users;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();   //verificar el en navegador la info
        //insertar a la BD

        //Envio Datos simple

        //User::create($request->all());
        //return redirect('/admin/users');

        //Envio Datos con archivos


        $request->validate([
            'name' => 'required | max:30',
            // /^[a-zA-Z]+$/u
            'email' => 'required | regex:/^[^@]+@[^@]+\.[a-zA-Z]+$/u',
            'password' => 'required | min:8',
        ],[
            'name.required' =>'El campo Nombre es obligatorio',
            'name.max' =>'El Nombre no debe ser mayor a 30 caracteres',

            'email.required' =>'El campo Correo es obligatorio',
            'email.regex' =>'El Correo no es válido',

            'password.required' =>'El campo Contraseña es obligatorio',
            'password.min' =>'La Contraseña debe contener al menos 8 caracteres',
        ]);


        $entrada=$request->all();

        if($archivo=$request->file('foto_id')){

          $nombre=$archivo->getClientOriginalName();
          //mover el archivo a la carpeta images con su nombre
          $archivo->move('images',$nombre);
          //enviar la ruta a la BD
          $foto=Foto::create(['ruta_foto'=>$nombre]);
          //guarda el id
          $entrada['foto_id']=$foto->id;

        }

        $entrada['password']=bcrypt($request->password);
        User::create($entrada);

        return redirect('/admin/users')->with('alert', ' ¡Usuario agregado correctamente!');
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
        $user=User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
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

        $request->validate([
            'name' => 'required|max:30',
        ],[
            'name.required' =>'El campo Nombre es obligatorio',
        ]);

        /* validar si trae pass */
        if($request->password || $request->password2){

          if( strlen($request->password) ==0 || strlen($request->password2) ==0 ){
            return back()->with('error_pass', ' ¡Los dos campos son obligatorios!');
          }

          if( strlen($request->password) <8 || strlen($request->password2) <8 ){
            return back()->with('error_pass', ' ¡Las contraseña deben contener al menos 8 caracteres!');
          }

          if($request->password2!=$request->password){
            return back()->with('error_pass', ' ¡Las contraseñas no coinciden!');
          }
        }

        $user=User::findOrFail($id);

        $entrada=$request->all();

        if($archivo=$request->file('foto_id')){

          $nombre=$archivo->getClientOriginalName();
          //mover el archivo a la carpeta images con su nombre
          $archivo->move('images',$nombre);
          //enviar la ruta a la BD
          $foto=Foto::create(['ruta_foto'=>$nombre]);
          //guarda el id
          $entrada['foto_id']=$foto->id;

        }

        $entrada['password']=bcrypt($request->password);

        $user->update($entrada);

        if($request->password2){
          return redirect('/admin/users')->with('alert', ' ¡Contraseña actualizada!');
        }else{
          return redirect('/admin/users')->with('alert', ' ¡Perfil actualizado!');
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
        //$user=User::findOrFail($id);
        //$user->delete();
/*
        $user=User::findOrFail($id)->delete();
        Log::stack(['slack', 'single'])->info("¡Usuario eliminado!");
        return redirect('/admin/users'); */
        Log::stack(['slack', 'single'])->info("Entro a eliminar");
        $user=User::findOrFail($id)->delete();

        if ($user == 1) {
            Log::stack(['slack', 'single'])->info("¡ El usuario ha sido eliminado !");
            $success = true;
            $message = "¡El usuario ha sido eliminado!";
        } else {
            Log::stack(['slack', 'single'])->info("¡ No se encontró el usuario !");
            $success = true;
            $message = "¡No se encontró el usuario!";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }

}
