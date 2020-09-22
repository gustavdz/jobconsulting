<?php

namespace App\Http\Controllers;

use App\User;
use App\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

        //dd(Auth::user()->role);
        if (Auth::user()->role == 'admin'){
            return view('home.index');
        }

        if (Auth::user()->role == 'aspirante'){
            $ofertas=Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC')->paginate(9);
            //return $ofertas;
            return view('home_aspirante.index',compact('ofertas'));
        }

        if (Auth::user()->role == 'empresa'){
            return view('home_empresa.index');
        }
    }
}
