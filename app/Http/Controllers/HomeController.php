<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Liga;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');

        //User::where('votes', '>', 100)->count();
        //$user = DB::table('users')->where('name', 'John')->first();
        //var_dump($user->name);

        /*Recuperar el id del usuario en sesion actual*/
        $id = Auth::id();
        Log::stack(['slack', 'single'])->info("Id de User logueado : " .$id);

        //Buscamos la fila del usuario
        $currentuser = User::find($id);

        //Buscamos la Liga del usuario Logueado
        $liga=Liga::where('user_id', '=', $currentuser->id)->first();
        Log::stack(['slack', 'single'])->info("La Liga del usuario es: " .$liga);

        return view('home', compact('liga'));
    }
}
