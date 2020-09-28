<?php

namespace App\Http\Controllers;

use App\User;
use App\Ofertas;
use App\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            $allCategories = Categorias::where('estado','A')->get();
            $ofertas=Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->where('ofertas.validez','>',Carbon::now())->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC')->paginate(9);
            //return $ofertas;
            return view('home_aspirante.index',compact('ofertas','allCategories'));
        }

        if (Auth::user()->role == 'empresa'){
            return view('home_empresa.index');
        }
    }
}
