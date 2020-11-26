<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Ofertas;
use App\Preguntas;

class PreguntasController extends Controller
{
    
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        if (Auth::user()->role == 'aspirante') {
            return redirect()->route('home');
        }

        $oferta = Ofertas::find($id);

        return view('preguntas.index',compact('oferta'));
    }

    public function data(Request $request){
        $results = Preguntas::where('oferta_id',$request->oferta_id)->get();
        return view('preguntas.table',compact('results'));
    }

    public function store(Request $request){
    	//return $request;
        $pregunta = Preguntas::find($request->id);
        if (empty($pregunta)) {
            $pregunta = new Preguntas;
            $pregunta->oferta_id = $request->oferta_id;
            $pregunta->campo = $request->tipo;
            $pregunta->texto = $request->titulo;
            $pregunta->respuestas = $request->opcion ? implode(",",$request->opcion) : '';
            $pregunta->save();

            $result = $pregunta ? ['msg' => 'success', 'data' => 'Se ha creado correctamente la pregunta ' . $request->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear la pregunta ' . $request->titulo];
            return response()->json($result);
        }else{
            $pregunta->campo = $request->tipo;
            $pregunta->texto = $request->titulo;
            $pregunta->respuestas = $request->opcion ? implode(",",$request->opcion) : '';
            $pregunta->save();

            $result = $pregunta ? ['msg' => 'success', 'data' => 'Se ha modificado correctamente la pregunta ' . $request->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al modificar la pregunta ' . $request->titulo];
            return response()->json($result);
        }
        
    }
}
