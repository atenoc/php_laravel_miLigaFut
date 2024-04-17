<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liga;
use App\Image;
use App\Temporada;
use App\Sede;
use Auth;
use App\User;
use App\Tipo;
use App\Rama;
use App\Estatu;
use Log;



class LigasController extends Controller
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
        //
        $ligas=Liga::all();

        foreach ($ligas as $liga){
          if($liga->fecha_inicio){
            $newFormat = date('d-m-Y', strtotime($liga->fecha_inicio));
            $liga['fecha_inicio'] = $newFormat;
            //echo $newFormat.' -- ';
          }
        }

        return view('ligas.ligas', compact('ligas'));
        //return $ligas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ligas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      //return $request->all();

      $request->validate([
          'nombre_liga' => 'required  | max:40',
          'temporada_id' => 'required | max:40',
          'fecha_inicio' => 'required | regex:/^[0-9]{2}[-][0-9]{2}[-][0-9]{4}$/ | max:10',
          'sede_id' => 'required | max:40',
      ],[
          'nombre_liga.required' =>'El campo Nombre de la Liga es obligatorio',
          'temporada_id.required' =>'El campo Nombre de la Temporada es obligatorio',

          'fecha_inicio.required' =>'El campo Fecha de Inicio es obligatorio',
          'fecha_inicio.regex' =>'El formato para la Fecha debe ser: dd-mm-aaaa',
          'fecha_inicio.max' =>'La Fecha no debe ser mayor que 10 caracteres',

          'sede_id.required' =>'El campo Ciudad/Lugar es obligatorio',
          'sede_id.max' =>'El campo Ciudad/Lugar no debe ser mayor a 40',
      ]);


      $entrada=$request->all();

      if($archivo=$request->file('image_id')){

        $nombre=$archivo->getClientOriginalName();
        //mover el archivo a la carpeta images con su nombre
        $archivo->move('images',$nombre);

        //enviar la ruta a la BD
        $imagen=Image::create(['nombre_imagen'=>$nombre]);

        //guarda el id
        $entrada['image_id']=$imagen->id;
      }

      if($temporada = $request->input('temporada_id')){
        $temporada=Temporada::create(['nombre_temporada'=>$temporada]);
        $entrada['temporada_id']=$temporada->id;
      }

      if($lugar = $request->input('sede_id')){
        $temporada=Sede::create(['nombre_sede'=>$lugar]);
        $entrada['sede_id']=$temporada->id;
      }

      /*Tipo Liga*/
      if($tipoLiga = $request->input('tipo_id')){
        $tipo=Tipo::create(['nombre_tipo'=>$tipoLiga]);
        $entrada['tipo_id']=$tipo->id;
      }

      /*Tipo Rama*/
      if($tipoRama = $request->input('rama_id')){
        $rama=Rama::create(['nombre_rama'=>$tipoRama]);
        $entrada['rama_id']=$rama->id;
      }

      /*Tipo Rama*/
      if($estatusLiga = $request->input('estatu_id')){
        $estatus=Estatu::create(['estatus'=>$estatusLiga]);
        $entrada['estatu_id']=$estatus->id;
      }

      /*Formato de fecha*/
      if($fe = $request->input('fecha_inicio')){
        $newFormat = date('Y-m-d', strtotime($fe));
        $entrada['fecha_inicio']=$newFormat;
      }

      /*Recuperar el id del usuario en sesion actual*/
      $id = Auth::id();
      $currentuser = User::find($id);
      $entrada['user_id']=$currentuser->id;

      Liga::create($entrada);
/*
      $user=User::findOrFail($currentuser->id);
      $ligaInsertada = Liga::where('user_id', '=', $currentuser->id)->firstOrFail();
      User::create(['liga_id'=>$ligaInsertada->id]);
*/
      return redirect('home')->with('alert', '¡Creaste una liga!');

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
        $liga=Liga::findOrFail($id);

        if($liga->fecha_inicio){
          $newFormat = date('d-m-Y', strtotime($liga->fecha_inicio));
          $liga['fecha_inicio'] = $newFormat;
          //echo $newFormat.' -- ';
        }

        return view('ligas.edit', compact('liga'));
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
            'nombre_liga' => 'required  | max:40',
            'temporada_id' => 'required | max:40',
            'fecha_inicio' => 'required | regex:/^[0-9]{2}[-][0-9]{2}[-][0-9]{4}$/ | max:10',
            'sede_id' => 'required | max:40',
        ],[
            'nombre_liga.required' =>'El campo Nombre de la Liga es obligatorio',
            'temporada_id.required' =>'El campo Nombre de la Temporada es obligatorio',

            'fecha_inicio.required' =>'El campo Fecha de Inicio es obligatorio',
            'fecha_inicio.regex' =>'El formato para la Fecha debe ser: dd-mm-aaaa',
            'fecha_inicio.max' =>'La Fecha no debe ser mayor que 10 caracteres',

            'sede_id.required' =>'El campo Ciudad/Lugar es obligatorio',
            'sede_id.max' =>'El campo Ciudad/Lugar no debe ser mayor a 40',
        ]);


        $liga=Liga::findOrFail($id);

        $entrada=$request->all();

        if($archivo=$request->file('image_id')){

          $nombre=$archivo->getClientOriginalName();
          //mover el archivo a la carpeta images con su nombre
          $archivo->move('images',$nombre);
          //enviar la ruta a la BD
          $image=Image::create(['nombre_imagen'=>$nombre]);
          //guarda el id
          $entrada['image_id']=$image->id;

        }

        if($temp = $request->input('temporada_id')){
          $temporada=Temporada::create(['nombre_temporada'=>$temp]);
          $entrada['temporada_id']=$temporada->id;
        }

        if($lugar = $request->input('sede_id')){
          $sede=Sede::create(['nombre_sede'=>$lugar]);
          $entrada['sede_id']=$sede->id;
        }

        /*Tipo Liga*/
        if($tipoLiga = $request->input('tipo_id')){
          $tipo=Tipo::create(['nombre_tipo'=>$tipoLiga]);
          $entrada['tipo_id']=$tipo->id;
        }

        /*Tipo Rama*/
        if($tipoRama = $request->input('rama_id')){
          $rama=Rama::create(['nombre_rama'=>$tipoRama]);
          $entrada['rama_id']=$rama->id;
        }

        /*Formato de fecha*/
        if($fe = $request->input('fecha_inicio')){
          $newFormat = date('Y-m-d', strtotime($fe));
          $entrada['fecha_inicio']=$newFormat;
        }

        $liga->update($entrada);

        return redirect('ligas')->with('alert', ' ¡Liga actualizada!');
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
        $liga=Liga::findOrFail($id)->delete();
        //return redirect('ligas');

        if ($liga == 1) {
            Log::stack(['slack', 'single'])->info("¡ Liga ha sido eliminada !");
            $success = true;
            $message = "¡Liga ha sido eliminada!";
        } else {
            Log::stack(['slack', 'single'])->info("¡ No se encontró la liga !");
            $success = true;
            $message = "¡No se encontró la liga!";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
