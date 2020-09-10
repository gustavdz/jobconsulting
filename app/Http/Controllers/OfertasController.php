<?php

namespace App\Http\Controllers;

use App\User;
use App\Ofertas;
use App\Categorias;
use App\Habilidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OfertasController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categorias = Categorias::where('estado','A')->get();
        $habilidades = Habilidades::where('estado','A')->get();
        $empresas = User::where('role','empresa')->get();
        return view('ofertas.index',compact('categorias','habilidades','empresas'));
    }

    public function data()
    {
        $results = [];
        if (Auth::user()->role == 'admin'){
            $results = Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->get();  
        }
        if (Auth::user()->role == 'empresa'){
            $results = Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.id',Auth::user()->id)->get();  
        }
        return view('ofertas.table',compact('results'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        $ofertas = new Ofertas;
        $ofertas->titulo = $request->titulo;
        $ofertas->descripcion = $request->descripcion;
        $ofertas->validez = $request->validez;
        $ofertas->salario = $request->salario;
        $ofertas->empresa_id = $request->empresa;
        $ofertas->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function show(Ofertas $ofertas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function edit(Ofertas $ofertas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ofertas $ofertas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ofertas $ofertas)
    {
        //
    }
}
