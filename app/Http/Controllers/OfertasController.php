<?php

namespace App\Http\Controllers;

use App\User;
use App\Ofertas;
use App\Categorias;
use App\Habilidades;
use App\CategoriasOfertas;
use App\HabilidadesOfertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $results = Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->orderBy('ofertas.validez', 'DESC')->get();  
        }
        if (Auth::user()->role == 'empresa'){
            $results = Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.empresa_id',Auth::user()->id)->orderBy('ofertas.validez', 'DESC')->get();  
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
      try {
            DB::beginTransaction();
            if (empty($request->id)) { # Id oferta es vacio se crea
                
                $ofertas = new Ofertas;
                $ofertas->titulo = $request->titulo;
                $ofertas->descripcion = $request->descripcion;
                $ofertas->validez =  $request->validez;
                $ofertas->salario = $request->salario;
                $ofertas->empresa_id = Auth::user()->role=='admin' ? $request->empresa : Auth::user()->id;
                $ofertas->save();

                if (!empty($ofertas)) {
                    foreach ($request->categorias as $key => $value) {
                        $categoria_oferta = new CategoriasOfertas;
                        $categoria_oferta->categoria_id = $value;
                        $categoria_oferta->oferta_id = $ofertas->id;
                        $categoria_oferta->save();
                    }
                    foreach ($request->habilidades as $key => $value) {
                        $habilidad_oferta = new HabilidadesOfertas;
                        $habilidad_oferta->habilidad_id = $value;
                        $habilidad_oferta->oferta_id = $ofertas->id;
                        $habilidad_oferta->save();
                    }
                }

                DB::commit();
            
                $result = $ofertas ? ['msg' => 'success', 'data' => 'Se ha creado correctamente la Oferta ' . $request->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear la Oferta ' . $request->titulo];

                return response()->json($result);
                
            }else{ # id oferta contine valor se edita
                $ofertas = Ofertas::find($request->id);
                $ofertas->titulo = $request->titulo;
                $ofertas->descripcion = $request->descripcion;
                $ofertas->validez =  $request->validez;
                $ofertas->salario = $request->salario;
                $ofertas->empresa_id = Auth::user()->role=='admin' ? $request->empresa : Auth::user()->id;
                $ofertas->save();

                if (!empty($ofertas)) {
                    CategoriasOfertas::where('oferta_id',$request->id)->delete();
                    foreach ($request->categorias as $key => $value) {
                        $categoria_oferta = new CategoriasOfertas;
                        $categoria_oferta->categoria_id = $value;
                        $categoria_oferta->oferta_id = $ofertas->id;
                        $categoria_oferta->save();
                    }
                    HabilidadesOfertas::where('oferta_id',$request->id)->delete();
                    foreach ($request->habilidades as $key => $value) {
                        $habilidad_oferta = new HabilidadesOfertas;
                        $habilidad_oferta->habilidad_id = $value;
                        $habilidad_oferta->oferta_id = $ofertas->id;
                        $habilidad_oferta->save();
                    }
                }

                DB::commit();
            
                $result = $ofertas ? ['msg' => 'success', 'data' => 'Se ha editado la Oferta ' . $request->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al editar la Oferta ' . $request->titulo];

                return response()->json($result);
            }

           

            

      } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ofertas  $ofertas
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.id',$request->id)->first(); 
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
