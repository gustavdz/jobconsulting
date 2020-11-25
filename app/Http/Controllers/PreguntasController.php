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
}
